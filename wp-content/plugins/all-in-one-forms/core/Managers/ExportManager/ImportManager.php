<?php


namespace rednaoeasycalculationforms\core\Managers\ExportManager;


use Exception;
use rednaoeasycalculationforms\core\db\FormRepository;
use rednaoeasycalculationforms\core\Loader;
use rednaoeasycalculationforms\core\Managers\FileManager\FileManager;
use rednaoeasycalculationforms\core\Utils\FormSettingsIterator;
use rednaoeasycalculationforms\DTO\BuilderOptionsDTO;
use rednaoeasycalculationforms\DTO\FormBuilderOptionsDTO;
use ZipArchive;

class ImportManager
{
    /** @var ZipArchive */
    public $zip;
    public $Loader;
    /** @var $FileManager */
    public $FileManager;
    public $TempFolderPath;
    /** @var FormBuilderOptionsDTO */
    public $FormOptions;
    /**
     * ImportManager constructor.
     * @param $loader Loader
     * @param $zipPath
     */
    public function __construct($loader)
    {
        $this->Loader=$loader;
        $this->FileManager=new FileManager($loader);
    }

    /**
     * @param $path
     * @return BuilderOptionsDTO
     * @throws \rednaoeasycalculationforms\core\Exception\FriendlyException
     */
    public function Import($path)
    {
        $this->zip=new ZipArchive();
        $this->TempFolderPath=$this->FileManager->GetTempPath(). $this->FileManager->GetSafeFileName($this->FileManager->GetTempPath(),'extracted_'.str_replace('.','',str_replace(' ','',\microtime()))).'/';
        if($this->zip->open($path)!==true)
            throw new Exception('Invalid zip file');

        $this->zip->extractTo($this->TempFolderPath);


        $content=\file_get_contents($this->TempFolderPath.'Export.json');
        if($content===false)
        {
            throw new Exception('The zip file does not have the required files');
        }

        $content=\json_decode($content);

        if($content===false||!isset($content->FormBuilder)||!isset($content->ServerOptions))
        {
            throw new Exception('The template.json is not valid');
        }

        $builderOptions=(new BuilderOptionsDTO())->Merge($content);

        $this->FormOptions=$builderOptions->FormBuilder;
        $builderOptions->Id=0;
        $repository=new FormRepository($this->Loader);

        $this->ImportAttachments();


        try
        {
            $repository->SaveForm($builderOptions, true);
        }catch(Exception $e)
        {
            throw $e;
        }

        return $builderOptions;

    }

    public function Remove(){
        \unlink($this->TempFolderPath);
    }

    private function ImportAttachments()
    {
        $formSettings=new FormSettingsIterator($this->FormOptions);
        $formSettings->Iterate(function ($field){
            if($field->Type=='image')
            {
                if($field->Src!=null)
                {
                    $newAttachment=$this->FileManager->UploadFileToMedia($this->TempFolderPath.'Attachments/'.$field->Src->URLId);
                    if($newAttachment==null)
                        return;

                    $field->Src->URLId=$newAttachment->URLId;
                    $field->Src->URL=$newAttachment->URL;
                }
                $imageCondition=$this->GetConditionsByType($field,'Image');
                foreach($imageCondition as $currentImageCondition)
                {
                    if($currentImageCondition->Src!=null)
                    {
                        $newAttachment=$this->FileManager->UploadFileToMedia($this->TempFolderPath.'Attachments/'.$currentImageCondition->Src->URLId);
                        if($newAttachment!=null)
                        {
                            $currentImageCondition->Src->URLId=$newAttachment->URLId;
                            $currentImageCondition->Src->URL=$newAttachment->URL;

                        }
                    }

                }
            }

            if($field->Type=='buttonselection')
            {
                foreach($field->Options as $currentOption)
                {
                    if($currentOption->ImageType=='image')
                    {
                        $newAttachment=$this->FileManager->UploadFileToMedia($this->TempFolderPath.'Attachments/'.$currentOption->Ref->URLId);
                        if($newAttachment==null)
                            continue;

                        $currentOption->Ref->URLId=$newAttachment->URLId;
                        $currentOption->Ref->URL=$newAttachment->URL;
                    }
                }

            }
        });
    }


    private function GetConditionsByType($field, $type)
    {
        $conditionToReturn=array();
        foreach($field->Conditions as $currentCondition)
            if($currentCondition->Type==$type)
                $conditionToReturn[]=$currentCondition;

        return $conditionToReturn;
    }


}


