<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 2/25/2019
 * Time: 8:57 AM
 */

namespace rednaoeasycalculationforms\core;

use rednaoeasycalculationforms\ajax\EntriesAjax;
use rednaoeasycalculationforms\ajax\EntryUtilsAjax;
use rednaoeasycalculationforms\ajax\FormListAjax;
use rednaoeasycalculationforms\ajax\SettingsAjax;
use rednaoeasycalculationforms\ajax\SubmissionAjax;
use rednaoeasycalculationforms\blocks\BlockLoader;
use rednaoeasycalculationforms\core\db\core\DBManager;
use rednaoeasycalculationforms\core\Managers\HTMLSanitizer;
use rednaoeasycalculationforms\core\Managers\LogManager\LogManager;
use rednaoeasycalculationforms\core\Managers\TwigManager\TwigManager;
use rednaoeasycalculationforms\DTO\BuilderOptionsDTO;
use rednaoeasycalculationforms\pr\PRLoader;


class Loader extends PluginBase
{
    /** @var PRLoader */
    public $PRLoader=null;
    /** @var TwigManager */
    private $Twig;

    /** @var HTMLSanitizer */
    public $HTMLSanitizer;
    public $FORM_LIST_TABLE;
    public $RECORDS_TABLE;
    public $RECORDS_DETAIL;
    public $RECORDS_FILES;
    public $RECORDS_META;
    public $LINKS;




    public function __construct($filePath,$prefix,$dbVersion,$fileVersion)
    {
        LogManager::Initialize($this);
        $dbManager=new DBManager();
        $this->FORM_LIST_TABLE=$dbManager->GetPrefix() . $prefix.'_forms';
        $this->RECORDS_TABLE=$dbManager->GetPrefix().$prefix.'_records';
        $this->RECORDS_META=$dbManager->GetPrefix().$prefix.'_records_meta';
        $this->RECORDS_DETAIL=$dbManager->GetPrefix().$prefix.'_records_detail';
        $this->RECORDS_FILES=$dbManager->GetPrefix().$prefix.'_records_files';
        $this->LINKS=$dbManager->GetPrefix().$prefix.'_links';

        \add_shortcode('rnformpreview',array($this,'LoadFormPreview'));
        \add_shortcode('rnform',array($this,'LoadForm'));

        parent::__construct($filePath,$prefix,$dbVersion,$fileVersion);
        require_once realpath($this->DIR.'Integration/RNECForms.php');

        load_plugin_textdomain( 'rednaoeasycalculationforms', false, dirname( plugin_basename( dirname(__FILE__) ) ) . '/languages/' );
        $this->AddMenu('All in one forms','rednao_calculation_form','administrator',$this->URL.'images/icon16.png',"rednaoeasycalculationforms\pages\FormList");
        $this->AddMenu('Entries','rednao_calculation_form_entries','administrator','','rednaoeasycalculationforms\pages\Entries');

        if($this->IsPR())
        {
            new PRLoader($this);
        }

        $this->AddMenu('Settings','rednao_calculation_form_settings','administrator','','rednaoeasycalculationforms\pages\Settings');



        new FormListAjax($this);
        new SubmissionAjax($this);
        new SettingsAjax($this);
        new EntryUtilsAjax($this);
        new EntriesAjax($this);


    }

    public function GetHTMLSanitizer(){
        if($this->HTMLSanitizer==null)
        {
            $this->HTMLSanitizer=new HTMLSanitizer($this);
        }
        return $this->HTMLSanitizer;
    }
    public function IsPR(){

        return \file_exists($this->DIR.'pr');
    }



    public function CheckIfPDFAdmin(){
        if(!current_user_can('manage_options'))
        {
            die('Forbidden');
        }
    }


    /**
     * @return TwigManager
     */
    public function GetTwigManager($paths=[]){

        if($this->Twig==null)
        {
            $this->Twig=new TwigManager($this,$paths);
        }
        return $this->Twig;
    }

    public function OnCreateTable()
    {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');


        $sql="CREATE TABLE ".$this->LINKS." (
        link_id int AUTO_INCREMENT,    
        reference VARCHAR(100) not null, 
        entry_id VARCHAR(100) NOT NULL,          
        date datetime NOT NULL,
        expiration_date datetime NOT NULL,
        options MEDIUMTEXT NOT NULL,
        PRIMARY KEY  (link_id),
        KEY reference (reference)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);

        $sql="CREATE TABLE ".$this->FORM_LIST_TABLE." (
        form_id int AUTO_INCREMENT,    
        creation_date datetime not null, 
        update_date datetime NOT NULL,          
        form_name VARCHAR(200) NOT NULL,
        element_options MEDIUMTEXT NOT NULL,
        client_form_options MEDIUMTEXT NOT NULL,
        server_options MEDIUMTEXT NOT NULL,
        emails MEDIUMTEXT Not null,
        extension_options MEDIUMTEXT Not null,
        dependencies MEDIUMTEXT,
        icons MEDIUMTEXT Not null,
        PRIMARY KEY  (form_id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);

        $sql="CREATE TABLE ".$this->RECORDS_TABLE." (
        entry_id int AUTO_INCREMENT,
        user_id VARCHAR(50),
        sequence int,
        formatted_sequence VARCHAR(50),
        form_id int,
        date datetime NOT NULL,
        data MEDIUMTEXT NOT NULL,
        ip VARCHAR(39),
        status VARCHAR(50) NOT NULL,
        reference_id VARCHAR(100),
        meta_values MEDIUMTEXT,
        total decimal(19,4),
        PRIMARY KEY  (entry_id),
        KEY sequence_number (sequence),
        KEY user_id (user_id),
        KEY date (date),
        KEY status (status),
        KEY reference_id (reference_id)                       
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);

        $sql="CREATE TABLE ".$this->RECORDS_META." (
        entry_meta_id bigint AUTO_INCREMENT,
        entry_id int,
        meta_name VARCHAR(200),
        meta_value longtext,
        display_value longtext,
        display_label VARCHAR(400),
        data_type VARCHAR(20),
        is_visible tinyint,
        PRIMARY KEY  (entry_meta_id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);


        $sql="CREATE TABLE ".$this->RECORDS_DETAIL." (
        entry_detail_id int AUTO_INCREMENT,
        entry_id int,
        uniq_id int,
        type VARCHAR(30),
        field_id int NOT NULL,
        subtype varchar(200) NOT NULL,
        value MEDIUMTEXT NOT NULL,
        exvalue1 MEDIUMTEXT NOT NULL,
        exvalue2 MEDIUMTEXT NOT NULL,
        exvalue3 MEDIUMTEXT NOT NULL,
        exvalue4 MEDIUMTEXT NOT NULL,
        exvalue5 MEDIUMTEXT NOT NULL,
        exvalue6 MEDIUMTEXT NOT NULL,
        numericvalue DOUBLE,        
        numericvalue2 DOUBLE,
        datevalue DATETIME,
        datevalue2 DATETIME,
        unit_price decimal(19,4),
        total_field_price decimal(19,4),
        PRIMARY KEY  (entry_detail_id),
        KEY subtype (subtype),
        KEY entry_id (entry_id),
        KEY field_id (field_id),
        KEY numericvalue (numericvalue),   
        KEY numericvalue2 (numericvalue2),   
        KEY datevalue (datevalue),
        KEY datevalue2 (datevalue2),
        FULLTEXT KEY value (value),
        FULLTEXT KEY exvalue1 (exvalue1),
        FULLTEXT KEY exvalue2 (exvalue2),
        FULLTEXT KEY exvalue3 (exvalue3),
        FULLTEXT KEY exvalue4 (exvalue4),
        FULLTEXT KEY exvalue5 (exvalue5),
        FULLTEXT KEY exvalue6 (exvalue6)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);

        $sql="CREATE TABLE ".$this->RECORDS_FILES." (
        file_id int AUTO_INCREMENT,
        file_sequence_id bigint,
        entry_reference VARCHAR(100),
        file_reference VARCHAR(100),
        field_id int NOT NULL,
        field_file_id int NOT NULL,
        name VARCHAR(200) NOT NULL,
        physical_name VARCHAR(200) NOT NULL,
        upload_date DATETIME,
        mime_type VARCHAR(50),
        file_type VARCHAR(20),
        PRIMARY KEY  (file_id),
        KEY file_sequence_id (file_sequence_id),
        KEY entry_reference (entry_reference),
        KEY file_reference (file_reference),
        KEY  field_file_id (field_file_id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);
    }


    public function CreateHooks()
    {
        new BlockLoader($this);
        add_filter('rednao-calculated-fields-get-additional-fields',array($this,'GetAllFields'),10,5);
        \add_filter('allinoneforms_get_loader',array($this,'GetLoader'));
        add_action('init',array($this,'Init'));
    }

    public function GetLoader(){
        return $this;
    }

    public function Init(){
        if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
            return;
        }

        register_post_type('rednao_forms_preview',
            array(
                'labels' => array(
                    'name' => __( 'Easy Calculation Forms Preview' ),
                    'singular_name' => __( 'rednaoeasycalculationformsPreview' )
                ),
                'public' => true,
                'show_ui'=>false,
                'has_archive' => false,
            )
        );
    }

    public function GetAllFields($fields){

        $fields[]='FBCheckBox';
        $fields[]='FBName';
        $fields[]='FBImage';
        $fields[]='FBRecaptcha';
        $fields[]='FBAddress';
        $fields[]='FBEmailField';
        $fields[]='FBDivider';
        $fields[]='FBDropDown';
        $fields[]='FBParagraph';
        $fields[]='FBSingleLabel';
        $fields[]='FBHTML';
        $fields[]='FBRadio';
        $fields[]='FBTextArea';
        $fields[]='FBTextField';
        $fields[]='FBNumericField';
        $fields[]='FBTotalField';
        $fields[]='FBSubmitButton';
        $fields[]='FBRecaptcha';
        $fields[]='FBActionButton';
        $fields[]='FBHidden';
        $fields[]='FBSurvey';
        $fields[]='FBList';
        $fields[]='FBGroupPanel';
        $fields[]='FBFloatPanel';
        $fields[]='FBFile';
        $fields[]='FBRepeater';
        $fields[]='FBImagePicker';
        $fields[]='FBDatePicker';
        $fields[]='FBDateRange';
        $fields[]='FBMaskedField';
        $fields[]='FBColorPickerField';
        $fields[]='FBSlider';
        $fields[]='FBButtonSelection';
        $fields[]='FBSwitch';
        $fields[]='FBSignature';
        $fields[]='FBColorSwatcher';
        $fields[]='FBTermOfService';
        $fields[]='FBGoogleMaps';
        $fields[]='FBTextualImage';

        return $fields;
    }

    public function LoadFormPreview($formId,$content){
        $formOptions=null;
        if (!isset($_POST['_nonce'])&&!isset($_GET['_nonce']))
        {
            echo 'Invalid Request';
            return;
        }
        $nonce='';

        if(isset($_POST['_nonce']))
            $nonce=\strval($_POST['_nonce']);
        if(isset($_GET['_nonce']))
            $nonce=\strval($_GET['_nonce']);


        if(!\wp_verify_nonce($nonce,'rednaoeasycalculationforms_FormList'))
        {
            echo "Forbidden";
            return;
        }


        $formLoader = new Managers\FormLoader\FormLoader($this);
        if(isset($_POST['data']) && \is_scalar($_POST['data']))
        {

            $builderOptions =(new BuilderOptionsDTO())->Merge(json_decode(stripslashes($_POST['data'])));

            $formLoader->LoadForm($builderOptions);
            $formLoader->SetAsQuickPreview($nonce);
        }else if(isset($_GET['formid']))
        {
            $formId=\intval($_GET['formid']);
            if(!$formLoader->LoadFromId($formId))
            {
                echo "Form not found";
                return;
            }
        }

        $content=$formLoader->Load();

        return $content;

    }


    public function LoadForm($attr,$content){

        $formLoader=new Managers\FormLoader\FormLoader($this);
        if(!$formLoader->LoadFromId($content)){
            echo 'Form not found';
            return;
        }
        return $formLoader->Load();

    }
}