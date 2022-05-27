<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\ContainerManager;



use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;
use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBRecaptcha;
use rednaoeasycalculationforms\core\Managers\FormManager\Fields\LineItems\Core\LineItem;
use rednaoeasycalculationforms\core\Managers\FormManager\FormBuilder;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\Context\HTMLContextBase;
use rednaoeasycalculationforms\Utilities\Sanitizer;

class ContainerManager
{

    /** @var ContainerDataRetriever */
    public $Container;
    public $LineItems;


    public function __construct($Container)
    {
        $this->Container=$Container;
        $this->LineItems=null;

    }

    public function GetFormBuilder(){
        return Sanitizer::GetValueFromPath($this->Container,'Columns.Rows.Form');
    }

    /**
     * @return FormBuilder
     */
    public function GetRootFormBuilder(){
        $form=$this->GetFormBuilder();
        if($form==null)
            return $this->Container;

        return $form->ContainerManager->GetRootFormBuilder();
    }

    /**
     * @param bool $includeFieldsOfRepeaters
     * @param bool $IncludeFieldsOfParentContainers
     * @param bool $includeFieldsOfGroupPanel
     * @return FBFieldBase[]
     */
    public function GetFields($includeFieldsOfRepeaters=false,$IncludeFieldsOfParentContainers=false,
                              $includeFieldsOfGroupPanel=true) {
        /** @var FBFieldBase[] $fields */
        $fields=[];

        foreach($this->Container->Rows as $row)
        {
            foreach($row->Columns as $column)
            {
                $field=$column->Field;
                $fields[]=$field;

                if(($field->Options->Type=='grouppanel'||$field->Options->Type=='floatpanel')&&$includeFieldsOfGroupPanel)
                {
                    foreach($field->ContainerManager->GetFields(true) as $subField)
                    {
                        $fields[]=$subField;
                    }
                }

                if($includeFieldsOfRepeaters&&($field->Options->Type=='repeater'||$field->Options->Type=='repeateritem'))
                {
                    foreach($field->ContainerManager->GetFields(true) as $subField)
                        $fields[]=$subField;
                }
            }
        }

        if($IncludeFieldsOfParentContainers)
        {
            if($this->Container->GetForm()!=null)
                $fields=\array_merge($fields,array_values(\array_filter($this->Container->GetForm()->ContainerManager->GetFields(false,true),
                    function ($element) use($fields){
                        $found=false;
                       foreach($fields as $currentField)
                       {
                           if($currentField->Options->Id==$element->Options->Id)
                               $found=true;
                       }
                        return $found;
                    })));
        }

        return $fields;


    }

    public function GetFieldById($id,$searchInChildContainer=false,$searchInParentContainers=false){
        foreach($this->GetFields() as $field)
        {
            if($field->Options->Id== $id)
                return $field;

            if($searchInChildContainer&&isset($field->ContainerManager))
            {
                $field=$field->ContainerManager->GetFieldById($id,true);
                if($field!=null)
                    return $field;
            }

            if($searchInParentContainers&&$this->Container->GetForm()!=null)
            {
                return $this->Container->GetForm()->ContainerManager->GetFieldById($id,false,true);
            }
        }

        return null;
    }

    /**
     * @return HTMLContextBase
     */
    public function GetHtml($context)
    {

        return (new ContainerManagerRenderer($this,$context))->Render();

    }

    public function PrepareForSerialization(){
        foreach ($this->GetFields(false,false,false) as $field)
        {
            if ($field->Entry == null&&!($field instanceof FBRecaptcha))
                continue;

            $field->PrepareForSerialization();
        }
    }


    /**
     * @return LineItem[]
     */
    public function GetLineItems()
    {
        if($this->LineItems==null)
        {

            $this->LineItems = array();
            foreach ($this->GetFields(false,false,false) as $field)
            {
                if (!$field->IsUsed())
                    continue;

                $lineItems=$field->GetLineItems();
                if($lineItems==null)
                    continue;
                $this->LineItems = \array_merge($this->LineItems, $lineItems);
            }
        }

        return $this->LineItems;

    }

    public function ToText()
    {
        $text=[];
        foreach($this->Container->GetRows() as $row)
        {

            foreach ($row->Columns as $column)
            {
                $currentField = $column->Field;
                if (!$currentField->IsUsed())
                    continue;

                $text[]=$currentField->GetLabel().":". $currentField->ToText();


            }


        }
        return \implode('|| ',$text);

    }

    public function CommitFiles()
    {
        foreach ($this->GetFields(false,false,false) as $field)
        {
            if ($field->Entry == null)
                continue;

            $field->CommitFiles();
        }
    }


}