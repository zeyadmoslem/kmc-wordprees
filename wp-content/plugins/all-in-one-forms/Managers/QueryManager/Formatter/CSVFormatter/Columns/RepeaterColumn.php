<?php


namespace rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter\Columns;


use rednaoeasycalculationforms\core\Managers\FileManager\FileManager;

class RepeaterColumn extends CSVColumn
{
    public function __construct($loader, $title, $path, $field)
    {
        parent::__construct($loader, $title, $path, $field);
    }


    public function Format($dataSource)
    {
       return $this->Field->ToText();

    }
}