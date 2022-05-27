<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;


use Exception;
use rednaoeasycalculationforms\core\db\core\DBManager;
use rednaoeasycalculationforms\core\db\core\FBFieldWithFiles;
use rednaoeasycalculationforms\core\db\core\FileItem;
use rednaoeasycalculationforms\core\db\FormRepository;
use rednaoeasycalculationforms\core\db\SettingsRepository;
use rednaoeasycalculationforms\core\Managers\FileManager\FileManager;
use rednaoeasycalculationforms\core\Managers\SlateGenerator\Core\HtmlTagWrapper;
use rednaoeasycalculationforms\core\Utils\IdUtils;

class FBGoogleMaps extends FBFieldWithFiles
{
    public function GetValue()
    {
        return $this->GetEntryValue('Value','');
    }



    public function PrepareForSerialization()
    {
        parent::PrepareForSerialization();
        if(isset($this->Entry->Value->Latitude)&&$this->Entry->Value->Latitude!=0)
        {
            $value=$this->Entry->Value;
            $form=$form=$this->GetRootForm();
            $url='';
            $settingsRepository=new SettingsRepository($this->Loader);
            $apiKey=$settingsRepository->GetGoogleMapsApiKey();
            if($apiKey!='')
            {

                $url="https://maps.googleapis.com/maps/api/staticmap?center=";
                if($value->MarkerLongitude!=0||$value->MarkerLatitude!=0)
                {
                    $url .= $value->MarkerLatitude . ',' . $value->MarkerLongitude;
                    $url.='&markers=red|'.$value->MarkerLatitude.','.$value->MarkerLongitude;
                }
                else
                    $url.=$value->Latitude.','.$value->Longitude;
                $url.='&size=600x300';
                $url.='&zoom='.$value->Zoom;
                $url.='&maptype=roadmap';
                $url.='&key='.$apiKey;

                $formRepository=new FormRepository($this->Loader);

                $data=\file_get_contents($url);
                $fileManager=new FileManager($this->Loader);
                $path=$fileManager->GetMapsFolderRootPath();
                $fileName=$fileManager->GetSafeFileName($path,uniqid("",true).'.png');
                \file_put_contents($path.$fileName,$data);
                $this->Entry->Value->FileName=$fileName;
                $this->Entry->Value->EntryReference=$this->GetRootForm()->GetReference();
                $this->Entry->Value->FileReference=IdUtils::GetUniqueId();
                $this->Entry->Value->UploadDate=date('c');
                $this->Entry->Value->FileId=$formRepository->GetNextFileId();
                $dbManager=new DBManager();

                $fileItem=new FileItem();
                $fileItem->MimeType='image/png';
                $fileItem->EntryReference=$this->Entry->Value->EntryReference;
                $fileItem->UploadDate=$this->Entry->Value->UploadDate;
                $fileItem->FileReference=$this->Entry->Value->FileReference;
                $fileItem->FileSequenceId=$this->Entry->Value->FileId;
                $fileItem->Name='';
                $fileItem->PhysicalName=$this->Entry->Value->FileName;
                $fileItem->FileType='map';
                $fileItem->FieldId=$this->Options->Id;

                $this->AddFile($fileItem);

            }

        }


    }

    public function InternalToText()
    {
        $address=[];
        if(trim($this->Entry->Value->Address1)!='')
            $address[]=trim($this->Entry->Value->Address1);
        if(trim($this->Entry->Value->Address2)!='')
            $address[]=trim($this->Entry->Value->Address2);
        if(trim($this->Entry->Value->City)!='')
            $address[]=trim($this->Entry->Value->City);
        if(trim($this->Entry->Value->State)!='')
            $address[]=trim($this->Entry->Value->State);
        if(trim($this->Entry->Value->Zip)!='')
            $address[]=trim($this->Entry->Value->Zip);
        if(trim($this->Entry->Value->CountryLong)!='')
            $address[]=trim($this->Entry->Value->CountryLong);


        return \implode(', ',$address);
    }

    public function GetAddress1(){
        return $this->Entry->Value->Address1;
    }

    public function GetAddress2(){
        return $this->Entry->Value->Address2;
    }

    public function GetCity(){
        return $this->Entry->Value->City;
    }

    public function GetState(){
        return $this->Entry->Value->State;
    }

    public function GetZip(){
        return $this->Entry->Value->Zip;
    }

    public function GetCountry(){
        return $this->Entry->Value->CountryLong;
    }

    protected function InternalGetHtml($document, $formatter = null)
    {
        $container=new HtmlTagWrapper($document,$document->createElement('table'));
        $table=$container->CreateAndAppendChild('tbody');
        $row=$table->CreateAndAppendChild('tr');

        if(trim($this->Entry->Value->Address1)!='')
        {
            $column = $row->CreateAndAppendChild('td');
            if($this->Options->Address1Label!='')
            {

                $label = $column->CreateAndAppendChild('div');
                $label->AddClass('rnFieldLabel');
                $label->AddStyle('font-weight','bold');
                $label->SetText($this->Options->Address1Label);
            }

            $valueContainer=$column->CreateAndAppendChild('div');
            $valueContainer->AddStyle('margin-bottom','10px');
            $valueContainer=$valueContainer->CreateAndAppendChild('span');
            $valueContainer->SetText($this->Entry->Value->Address1);

        }

        if(trim($this->Entry->Value->Address2)!='')
        {
            $column = $row->CreateAndAppendChild('td');
            if($this->Options->Address2Label!='')
            {

                $label = $column->CreateAndAppendChild('div');
                $label->AddClass('rnFieldLabel');
                $label->AddStyle('font-weight','bold');
                $label->SetText($this->Options->Address2Label);
            }

            $valueContainer=$column->CreateAndAppendChild('div');
            $valueContainer->AddStyle('margin-bottom','10px');

            $valueContainer=$valueContainer->CreateAndAppendChild('span');
            $valueContainer->SetText($this->Entry->Value->Address2);

        }


        if(trim($this->Entry->Value->City)!=''||trim($this->Entry->Value->State)!='')
        {
            $row=$table->CreateAndAppendChild('tr');

            if(trim($this->Entry->Value->City)!='')
            {
                $column = $row->CreateAndAppendChild('td');
                if ($this->Options->CityLabel != '')
                {

                    $label = $column->CreateAndAppendChild('div');
                    $label->AddClass('rnFieldLabel');
                    $label->AddStyle('font-weight', 'bold');
                    $label->SetText($this->Options->CityLabel);
                }

                $valueContainer = $column->CreateAndAppendChild('div');
                $valueContainer->AddStyle('margin-bottom','10px');
                $valueContainer = $valueContainer->CreateAndAppendChild('span');
                $valueContainer->SetText($this->Entry->Value->City);
            }

            if(trim($this->Entry->Value->State)!='')
            {
                $column = $row->CreateAndAppendChild('td');
                if ($this->Options->StateLabel != '')
                {

                    $label = $column->CreateAndAppendChild('div');
                    $label->AddClass('rnFieldLabel');
                    $label->AddStyle('font-weight', 'bold');
                    $label->SetText($this->Options->StateLabel);
                }

                $valueContainer = $column->CreateAndAppendChild('div');
                $valueContainer->AddStyle('margin-bottom','10px');
                $valueContainer = $valueContainer->CreateAndAppendChild('span');
                $valueContainer->SetText($this->Entry->Value->State);
            }

        }


        if(trim($this->Entry->Value->Zip)!=''||trim($this->Entry->Value->CountryLong)!='')
        {
            $row=$table->CreateAndAppendChild('tr');

            if(trim($this->Entry->Value->Zip)!='')
            {
                $column = $row->CreateAndAppendChild('td');
                if ($this->Options->ZipLabel != '')
                {

                    $label = $column->CreateAndAppendChild('div');
                    $label->AddClass('rnFieldLabel');
                    $label->AddStyle('font-weight', 'bold');
                    $label->SetText($this->Options->ZipLabel);
                }

                $valueContainer = $column->CreateAndAppendChild('div');
                $valueContainer->AddStyle('margin-bottom','10px');
                $valueContainer = $valueContainer->CreateAndAppendChild('span');
                $valueContainer->SetText($this->Entry->Value->Zip);
            }

            if(trim($this->Entry->Value->CountryLong)!='')
            {
                $column = $row->CreateAndAppendChild('td');
                if ($this->Options->CountryLabel != '')
                {

                    $label = $column->CreateAndAppendChild('div');
                    $label->AddClass('rnFieldLabel');
                    $label->AddStyle('font-weight', 'bold');
                    $label->SetText($this->Options->CountryLabel);
                }

                $valueContainer = $column->CreateAndAppendChild('div');
                $valueContainer->AddStyle('margin-bottom','10px');
                $valueContainer = $valueContainer->CreateAndAppendChild('span');
                $valueContainer->SetText($this->Entry->Value->CountryLong);
            }

        }

        $colspan=1;
        foreach($table->Children as $row)
        {
            $colspan=max(count($row->Children),$colspan);
        }

        $row=$table->CreateAndAppendChild('tr');
        $column=$row->CreateAndAppendChild('td');
        $column->SetAttribute('colspan',$colspan);
        $column=$column->CreateAndAppendChild('div');
        $column->AddStyle('margin-top','10px');
        $column->AddStyle('width','100%');
        $column->AddStyle('text-align','center');

        $fileManager=new FileManager($this->Loader);
        $url=$fileManager->GetDownloadLink($this->Entry->Value->FileId,$this->Entry->Value->FileReference);

        $img=$column->CreateAndAppendChild('img');
        $img->AddStyle('max-width','100%');
        $img->SetAttribute('src',$url);

        return $container;
    }


    public function GetLineItems(){
        $lineItems=parent::GetLineItems();
        if($lineItems==null)
            return null;

        $item=$lineItems[0];

        $item->Value=$this->ToText();
        $item->ExValue1=$this->GetAddress1();
        $item->ExValue2=$this->GetAddress2();
        $item->ExValue3=$this->GetCity();
        $item->ExValue4=$this->GetState();
        $item->ExValue5=$this->GetZip();
        $item->ExValue6=$this->GetCountry();
        $item->NumericValue=$this->Entry->Value->Longitude;
        $item->NumericValue2=$this->Entry->Value->Latitude;



        return array($item);

    }

}