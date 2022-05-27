<?php


namespace rednaoeasycalculationforms\core\Managers\EmailManager;


use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use rednaoeasycalculationforms\core\Integration\FilterManager;
use rednaoeasycalculationforms\core\Integration\SiteIntegration;
use rednaoeasycalculationforms\core\Managers\ConditionManager\ConditionManager;
use rednaoeasycalculationforms\core\Managers\FormManager\FormBuilder;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\Context\HTMLEmailContext;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLGenerator;
use rednaoeasycalculationforms\core\Managers\LogManager\LogManager;
use rednaoeasycalculationforms\core\Managers\SingleLineGenerator\SingleLineGenerator;
use rednaoeasycalculationforms\core\Managers\SlateGenerator\Core\SlateGenerator;
use rednaoeasycalculationforms\core\Managers\SlateTextGenerator\SlateTextGenerator;
use rednaoeasycalculationforms\DTO\EmailAddressDTO;
use rednaoeasycalculationforms\DTO\EmailItemOptionsDTO;
use stdClass;

class EmailManager
{

    /** @var FormBuilder */
    public $Model;
    /** @var EmailItemOptionsDTO */
    public $Email;

    /**
     * @param $model FormBuilder
     * @param $email
     */
    public function Initialize($model,$email){
        $this->Model=$model;
        $this->Email=$email;
    }


    public function Send()
    {
        $generator=new SingleLineGenerator($this->Model);
        $subject=$generator->GetText($this->Email->Subject);
        $toEmailAddress=$this->ProcessEmails($this->Email->To);
        $bcc=$this->ProcessEmails($this->Email->BCC);
        $cc=$this->ProcessEmails($this->Email->CC);
        $replyTo=$this->ProcessEmails($this->Email->ReplyTo);
        $from=$this->GetFromName();


        $context=new HTMLEmailContext();
        $htmlGenerator=new HTMLGenerator($this->Model,$this->Email->Content,$context);
        $content=$htmlGenerator->GetHTML();




        $headers=array(
            'From: '.$from,
            'Content-Type: text/html; charset=UTF-8'
        );

        if($cc!='')
            $headers[]='CC:'.$cc;

        if($bcc!='')
            $headers[]='BCC:'.$bcc;

        if($replyTo!='')
            $headers[]='Reply-To:'.$replyTo;

        if($toEmailAddress=='')
        {
            $email=new SiteIntegration($this->Model->Loader);
            $toEmailAddress=$email->GetEmail();
        }
        $slateTextGenerator=new SlateTextGenerator($this->Model);

        $emailData=new stdClass();
        $emailData->to=$toEmailAddress;
        $emailData->Subject=$generator->GetText($subject);
        $emailData->Content=$content;
        $emailData->Headers=$headers;
        $emailData->Attachments=[];

        FilterManager::ApplyFilters('allinoneforms_before_sending_email',(object)array('EmailData'=>$emailData,'FormBuilder'=>$this->Model,'EmailConfig'=>$this->Email));

        /**
         * @param $phpmailer PHPMailer
         */
        $emailCallBack=function(&$phpmailer)use($context){

            if(count($context->InlinedImages)>0)
            {
                $phpmailer->SMTPKeepAlive = true;
                foreach($context->InlinedImages as $id=>$path)
                {
                    $phpmailer->AddEmbeddedImage($path,$id);
                }


            }

        };

        add_action( 'phpmailer_init', $emailCallBack);

        $success= wp_mail($emailData->to,$emailData->Subject,$emailData->Content,$emailData->Headers,$emailData->Attachments);
        remove_action('phpmailer_init',$emailCallBack);
        return $success;

    }


    /**
     * @param $emailAddresses EmailAddressDTO[]
     * @return string
     */
    private function ProcessEmails($emailAddresses)
    {
        $emails=[];
        foreach($emailAddresses as $currentEmail)
        {
            if($currentEmail->Type=='Field')
            {
                $emailToAdd=$this->GetEmailFromField($currentEmail->Value);
                if($emailToAdd!='')
                    $emails[]=$emailToAdd;
            }else{
                $emails[]=$currentEmail->Value;
            }
        }
        return \implode(',',$emails);
    }

    private function GetEmailFromField($Value)
    {
        $field=$this->Model->ContainerManager->GetFieldById($Value);
        if($field==null)
            return '';

        $value=trim($field->ToText());
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return '';
        }

        return $value;

    }

    private function GetFromName()
    {

        $fromName=$this->Email->FromName;
        if($fromName=='')
        {
            $fromName=get_bloginfo('name');
        }

        $rule = array("\r" => '',
            "\n" => '',
            "\t" => '',
            '"'  => "'",
            '<'  => '[',
            '>'  => ']',
        );

        $fromName= trim(strtr($fromName, $rule));
        $FromEmail = apply_filters('wp_mail_from', get_bloginfo('admin_email'));


        return $fromName." <$FromEmail>";


    }

    public function GetSubject(){
        return $this->Email->Subject;
    }

    public function ShouldEmailBeSend()
    {
        $condition=new ConditionManager();
        return $condition->ShouldProcess($this->Model,$this->Email->Condition);
    }


}