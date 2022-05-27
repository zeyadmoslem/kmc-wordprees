<?php


namespace rednaoeasycalculationforms\Managers\QueryManager\Formatter;


use rednaoeasycalculationforms\core\Managers\EntrySaver\EasyCalculationEntry;
use rednaoeasycalculationforms\core\Managers\EntrySaver\EasyCalculationMeta;

class ObjectQueryFormatter extends QueryFormatterBase
{
    public function FormatRow($row){
        $rowToReturn=new EasyCalculationEntry();
        $rowToReturn->UserId=$row->user_id;
        $rowToReturn->FormattedSequence=$row->formatted_sequence;
        $rowToReturn->Sequence=$row->sequence;
        $rowToReturn->UnixDate=\strtotime($row->date);
        $rowToReturn->Data=$row->data;
        $rowToReturn->Total=\floatval($row->total);
        $rowToReturn->Status=$row->status;
        $rowToReturn->EntryId=$row->entry_id;
        $rowToReturn->FormId=$row->form_id;
        $rowToReturn->UserName='';
        $rowToReturn->UserEmail='';
        $rowToReturn->ReferenceId=$row->reference_id;

        $userInfo=$this->UserIntegration->GetUserInfoById($rowToReturn->UserId);
        if($userInfo!=null)
        {
            $rowToReturn->UserName = $userInfo->Name;
            $rowToReturn->UserEmail=$userInfo->Email;
        }

        if($row->meta_values!=null)
        {
            $metaValues=\json_decode($row->meta_values);
            foreach($metaValues as $currentMeta)
            {
                $meta=new EasyCalculationMeta();
                $meta->Load($currentMeta);
                $rowToReturn->Meta[]=$meta;
            }
        }



        return $rowToReturn;
    }
}