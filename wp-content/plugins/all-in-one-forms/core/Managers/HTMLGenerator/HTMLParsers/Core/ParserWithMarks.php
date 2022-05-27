<?php

namespace rednaoeasycalculationforms\core\Managers\HTMLGenerator\HTMLParsers\Core;

use rednaoeasycalculationforms\Utilities\ObjectSanitizer;

class ParserWithMarks extends HTMLParserBase
{
    public $Marks=[];
    /** @var HTMLParserBase */
    public $ChildNode;
    public function __construct($formBuilder, $parent, $data,$childNode)
    {
        parent::__construct($formBuilder, $parent, $data);
        $this->ChildNode=$childNode;
    }

    public function ParseContent()
    {
        $this->Marks=$this->Data->marks;
        $this->ChildNode->Parent=$this;

        return $this;
    }

    public function GetLinkData(){
        foreach($this->Marks as $currentMark)
        {
            if($currentMark->type=='link')
                return ObjectSanitizer::Sanitize($currentMark->attrs,(object)[
                   'href'=>'',
                   'target'=>''
                ]);
        }

        return null;
    }


    public function GetStyles(){
        $styles='';
        foreach ($this->Marks as $currentMark)
        {
            switch ($currentMark->type)
            {
                case 'strong':
                    $styles.='font-weight:bold;';
                    break;
                case 'em':
                    $styles.='font-style:italic;';
                    break;
                case 'color':
                    $styles.='color:'.$currentMark->attrs->color;
                case 'link':
                    break;
                default:
                    $styles=$styles.'';

            }
        }
            return $styles;
    }


    protected function GetTemplateName()
    {
        return 'core/Managers/HTMLGenerator/HTMLParsers/Core/ParserWithMarks.twig';
    }
}