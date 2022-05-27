<?php


namespace rednaoeasycalculationforms\ajax;


use Exception;
use rednaoeasycalculationforms\core\db\EntryRepository;
use rednaoeasycalculationforms\core\db\FormDataDTO;
use rednaoeasycalculationforms\core\db\FormRepository;
use rednaoeasycalculationforms\core\Exception\FriendlyException;
use rednaoeasycalculationforms\core\Managers\LogManager\LogManager;
use rednaoeasycalculationforms\DTO\FilterConditionOptionsDTO;
use rednaoeasycalculationforms\Managers\QueryManager\Formatter\CSVFormatter\CSVQueryFormatter;
use rednaoeasycalculationforms\Managers\QueryManager\QueryManager;

class EntriesAjax extends AjaxBase
{

    function GetDefaultNonce()
    {
        return 'Entries';
    }

    protected function RegisterHooks()
    {
        $this->RegisterPrivate('search_entries','SearchEntries');
        $this->RegisterPrivate('load_entry','LoadEntry');
        $this->RegisterPrivate('update_field','UpdateField');
        $this->RegisterPrivate('delete_entries','DeleteEntry');
        $this->RegisterPrivate('save_status','SaveStatus');

    }


    public function SaveStatus(){
        $entryId=$this->GetRequired('EntryId');
        $status=$this->GetRequired('Status');

        $repository=new EntryRepository($this->Loader);
        $repository->SaveStatus($entryId,$status);
        $this->SendSuccessMessage(true);

    }


    public function LoadEntry(){
        $entryId=$this->GetRequired('EntryIds');


        if(!\is_array($entryId))
            $entryId=array($entryId);
        $repository=new EntryRepository($this->Loader);


        $results=array();

        /** @var FormDataDTO $currentForm */
        $currentForm=null;
        foreach($entryId as $currentEntry)
        {
            $entry=$repository->LoadEntry($currentEntry);
            $formRepository = new FormRepository($this->Loader);
            if($currentForm==null)
                $currentForm = $formRepository->GetForm($entry->FormId)->Options;
            else{
                if($currentForm->FormOptions->Id!=$entry->FormId)
                    $this->SendErrorMessage('All the entries must belong to the same form');
            }



            $queryManager=new QueryManager($this->Loader,$entry->FormId);
            $queryManager->CreateWhereGroup()->AddEntryId($currentEntry);

            $rowResult=$queryManager->GetResults();
            if(count($rowResult)>0)
                $results[]=$rowResult[0];
        }



        $this->SendSuccessMessage(array(
            'Entries'=>$results,
            'Id'=>$currentForm->FormOptions->Id,
            'Form'=>$currentForm->FormOptions->Rows,
            'Name'=>$currentForm->FormOptions->Name,
            'ClientOptions'=>$currentForm->FormOptions->ClientOptions
        ));
    }

    public function DeleteEntry(){
        $ids=$this->GetRequired('Ids');

        $entryRepository=new EntryRepository($this->Loader);
        foreach($ids as $currentId)
        {
            $entryRepository->DeleteEntry($currentId);
        }

        $this->SendSuccessMessage('Record(s) deleted successfully');

    }

    public function SearchEntries(){
        $queryManager=new QueryManager($this->Loader,$this->GetRequired('Form'));
        $whereGroup=$queryManager->CreateWhereGroup();

        $startDate=$this->GetOptional('StartDate',0);
        $endDate=$this->GetOptional('EndDate',0);
        $pageIndex=$this->GetRequired('PageIndex');
        $pageSize=$this->GetRequired('PageSize');
        $condition=$this->GetOptional('FilterCondition',null);

        if($startDate>0||$endDate>0)
        {

            $whereGroup=$queryManager->CreateWhereGroup();

            if($startDate>0)
                $whereGroup->AddStartDate($startDate);

            if($endDate>0)
                $whereGroup->AddEndDate($endDate+(60*60*24));
        }

        do_action('allinoneforms_before_entry_search',$queryManager,$condition);


        $results=$queryManager->GetResults($pageSize,$pageIndex*$pageSize);
        foreach($results as $currentRow)
        {
            $currentRow->EditNonce=wp_create_nonce('edit_entry_'.$currentRow->EntryId);
        }
        $count=$queryManager->GetCount();



        $this->SendSuccessMessage(array('Rows'=>$results,'Count'=>$count));
    }
}