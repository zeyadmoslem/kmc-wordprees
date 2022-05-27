<?php

namespace rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate;

use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use Twig\Markup;

class OneFieldPerRowTemplate extends HTMLParserBase
{
    /** @var FBFieldBase[] */
    public $Fields=[];
    public function ParseContent()
    {
        $fields=$this->FormBuilder->GetFields(true,true);
        foreach($fields as $currentField)
        {
            if(isset($currentField->ContainerManager))
            {
                continue;
            }
            if($currentField->IsUsed())
                $this->Fields[]=$currentField;
        }


        return $this;
    }

    public function Render()
    {
        return $this->RenderTemplate($this->GetTemplateName(),$this);
    }


    protected function GetTemplateName()
    {
        return 'core/Managers/HTMLGenerator/HTMLParsers/Templates/FieldSummaryTemplate/OneFieldPerRowTemplate.twig';
    }


    public function RenderTemplate($templateName,$model)
    {
        $markup= new Markup($this->FormBuilder->Loader->GetTwigManager()->Render($templateName,$model,['Context'=>$this->GetDocument()->Context]),"UTF-8");
        return $markup;
    }
}