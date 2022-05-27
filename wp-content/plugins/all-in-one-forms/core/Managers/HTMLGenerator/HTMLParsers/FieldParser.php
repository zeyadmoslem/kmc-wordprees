<?php

namespace rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers;

use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Core\HTMLSimpleContainer;
use rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Core\ParserUtilities;

class FieldParser extends HTMLParserBase
{
    public $Id;
    public $Options;
    /** @var FBFieldBase */
    public $Field;
    public function ParseContent()
    {
        $this->Id=$this->GetAttributeValue('id');
        $this->Options=$this->GetAttributeValue('options');

        $this->Field=$this->FormBuilder->GetFieldById($this->Id);
        if($this->Field==null)
            return null;

        return ParserUtilities::MaybeApplyMarks($this);
    }

    public function Render()
    {
        $field=$this->FormBuilder->GetFieldById($this->Id);
        if($this->FormBuilder->IsTest){
            if($field==null)
                return "[Unknown Field]";
            else
                return "[".$field->GetLabel().']';
        }

        if($field==null)
            return '';

        return $field->ToText();

    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}