<?php

namespace rednaoeasycalculationforms\Parser\Elements;


use rednaoeasycalculationforms\Parser\Core\ParseFactory;
use rednaoeasycalculationforms\Parser\Core\ParserElementBase;

class ParseParenthesis extends ParserElementBase{

    /** @var ParserElementBase[] */
    public $Args;
    function __construct($Parent,$Data) {
        parent::__construct($Parent,$Data);

        $this->Args=[];
        foreach($this->Data->Args as $current)
        {
            $this->Args[]=ParseFactory::GetParseElement($this,$current);
        }
    }

    function Parse() {
        if(count($this->Args)==0)
            return null;

        return ($this->Args[0])->Parse();
    }

}