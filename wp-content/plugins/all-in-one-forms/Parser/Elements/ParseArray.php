<?php
namespace rednaoeasycalculationforms\Parser\Elements;


use rednaoeasycalculationforms\Parser\Core\ParseFactory;
use rednaoeasycalculationforms\Parser\Core\ParserElementBase;

class ParseArray extends ParserElementBase{

    /** @var ParserElementBase[] */
    public $Elements;
    function __construct($Parent,$Data) {
        parent::__construct($Parent,$Data);

        $this->Elements=[];
        foreach($this->Data->Elements as &$current)
        {
            $this->Elements[]=(ParseFactory::GetParseElement($this,$current))->Parse();
        }
    }

    function Parse() {
        return $this->Elements;
    }

}