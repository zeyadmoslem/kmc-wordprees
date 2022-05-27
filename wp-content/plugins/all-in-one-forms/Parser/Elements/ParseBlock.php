<?php


namespace rednaoeasycalculationforms\Parser\Elements;


use rednaoeasycalculationforms\Parser\Core\ParseFactory;
use rednaoeasycalculationforms\Parser\Core\ParserElementBase;

class ParseBlock extends ParserElementBase
{
    /** @var ParserElementBase */
    public $Sentences;

    public function __construct($parent,$data)
    {
        parent::__construct($parent,$data);
        $this->Sentences=array();
        foreach($data->Sentences as $sentence)
            $this->Sentences[]=ParseFactory::GetParseElement($this,$sentence);
    }


    public function Parse()
    {
        $defaultReturn=null;
        foreach($this->Sentences as $sentence)
        {
            if($sentence instanceof ParseReturn )
                return $sentence;

            $result=$sentence->Parse();

            if($result instanceof ParseReturn )
                return $result;

            if($result!=null)
                $defaultReturn=$result;
        }

        return $defaultReturn;
    }
}