<?php


namespace rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter;


use rednaoeasycalculationforms\core\Utils\ArrayUtils;
use rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter\Columns\BasicStringCSVColumn;
use rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter\Columns\CSVColumn;
use rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter\Columns\CSVColumnFactory;
use rednaoeasycalculationforms\Managers\QueryManager\Formatter\QueryFormatterBase;
use stdClass;

class CSVQueryFormatter extends QueryFormatterBase
{
    /** @var CSVColumn[] */
    public $Columns=null;

    public function FormatRow($row)
    {

        $formBuilder=$this->GetFormBuilder();
        $entry=new stdClass();
        $entry->Data=$row->data;
        $formBuilder->SetEntry($entry->Data);

        $columns=$this->GetColumns();
        $data=[];
        foreach($columns as $currentColumn)
        {
            $currentColumn->Field=$formBuilder->GetFieldById($currentColumn->Field->Options->Id);
            $data[]=$currentColumn->Format($row);
        }

        return $data;
    }

    private function GetColumns()
    {
        if($this->Columns==null)
        {
            $this->Columns=[];
            $this->Columns[]=new BasicStringCSVColumn($this->QueryManager->Loader,'EntryId',['entry_id'],null);
            $this->Columns[]=new BasicStringCSVColumn($this->QueryManager->Loader,'Date',['date'],null);
            $this->Columns[]=new BasicStringCSVColumn($this->QueryManager->Loader,'Status',['status'],null);

            $formBuilder=$this->GetFormBuilder();
            $fields=$formBuilder->ContainerManager->GetFields(false,false,false);
            foreach($fields as $currentField)
            {
                $this->Columns=\array_merge($this->Columns,CSVColumnFactory::GetCSVColumnByField($this->QueryManager->Loader,$currentField));
            }

            $this->Columns[]=new BasicStringCSVColumn($this->QueryManager->Loader,'Total',['total'],null);
        }

        return $this->Columns;
    }

    public function PostProcess($itemsToReturn)
    {
        $arrayToReturn=array(
            'Columns'=>ArrayUtils::Map($this->GetColumns(),function ($item){return $item->Title;}),
            'Data'=>$itemsToReturn
        );
        return (object)$arrayToReturn;
    }


}