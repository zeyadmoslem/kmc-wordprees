<?php


namespace rednaoeasycalculationforms\Parser\Elements;


use rednaoeasycalculationformsParser\Core\ParseFactory;
use rednaoeasycalculationforms\Parser\Core\ParserElementBase;

class ParseReturn extends ParserElementBase
{
    /** @var ParserElementBase */
    public $Sentence;

    public function __construct($parent,$data)
    {
        parent::__construct($parent,$data);
        $this->Sentence=ParseFactory::GetParseElement($this,$data->Sentence);
    }


    public function Parse()
    {
        return $this->Sentence->Parse();
    }
}