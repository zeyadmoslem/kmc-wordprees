<?php

namespace rednaoeasycalculationforms\Parser\Elements;

use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;
use rednaoeasycalculationforms\core\Utils\ArrayUtils;
use rednaoeasycalculationforms\Parser\Core\ParseFactory;
use rednaoeasycalculationforms\Parser\Core\ParserElementBase;
use rednaoeasycalculationforms\Parser\Core\ParserElementThatUsesFieldsBase;
use stdClass;
use undefined\DTO\FBFieldBaseOptions;

class ParseMain extends ParserElementThatUsesFieldsBase{

    /** ParserElementBase[] */
    public $Sentences;

    /** @var FBFieldBase[] */
    public $FieldList;
    /** @var FBFieldBase */
    public $Owner;
    private $Variables;
    function __construct($FieldList,$Data,$Owner=null) {
        parent::__construct(null,$Data);
        $this->Variables=array();
        $this->Owner=$Owner;
        $this->FieldList=$FieldList;
        $this->Sentences=[];
        foreach(($this->Data[0])->Sentences as $sentence )
            $this->Sentences[]=ParseFactory::GetParseElement($this,$sentence);
    }

    private function InternalParse(){
        $defaultReturn=null;
        foreach($this->Sentences as $sentence)
        {

            if($sentence instanceof ParseReturn)
                return $sentence->Parse();

            $result=$sentence->Parse();
            if($result instanceof ParseReturn) {
                return $result->Parse();
            }

            if($result!=null)
                $defaultReturn=$result;


        }

        return $defaultReturn;
    }

    function Parse() {
        $result=$this->InternalParse();
        if(\is_array($result))
        {
            return \array_reduce($result,function ($carry,$item){return $carry+$this->ParseSingleNumber($item);},0);
        }

        return $this->ParseSingleNumber($result);
    }

    private function ParseSingleNumber($element)
    {
        if($element==null)
            return 0;

        if($element instanceof FBFieldBase)
            return $element->GetPrice();
        return \floatval($element);

    }

    function ParseText() {
        $result=$this->InternalParse();
       if(\is_array($result))
       {
           return implode(", ",\array_map(function ($element){return $this->ParseSingleText($element);},$result));
       }

       return $this->ParseSingleText($result);
    }

    private function ParseSingleText($element) {
        if($element==null)
            return '';

        if($element instanceof FBFieldBase)
            return $this->GetPriceFromField($element);
        return \strval($element);
    }

    public function SetVariable($variableName,$value)
    {
        $variable=ArrayUtils::Find($this->Variables,function ($item)use($variableName){return $item->Name==$variableName;});
        if($variable==null)
        {
            $variable=new stdClass();
            $variable->Name=$variableName;
            $variable->Value=null;
            $this->Variables[]=$variable;
        }

        $variable->Value=$value;

    }


    public function GetVariable($variableName)
    {
        $variable=ArrayUtils::Find($this->Variables,function ($item)use($variableName){return $item->Name==$variableName;});
        if($variable==null)
            return null;

        return $variable->Value;

    }



}

