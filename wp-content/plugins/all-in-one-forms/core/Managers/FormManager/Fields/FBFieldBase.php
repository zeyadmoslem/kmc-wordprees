<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;

use rednaoeasycalculationforms\core\Loader;
use rednaoeasycalculationforms\core\Managers\ConditionManager\Comparator\ComparisonSource;
use rednaoeasycalculationforms\core\Managers\FormManager\Calculator\CalculatorBase;
use rednaoeasycalculationforms\core\Managers\FormManager\Calculator\CalculatorFactory;
use rednaoeasycalculationforms\core\Managers\FormManager\Calculator\NoneCalculator;
use rednaoeasycalculationforms\core\Managers\FormManager\FBColumn;
use rednaoeasycalculationforms\core\Managers\FormManager\Fields\LineItems\Core\LineItem;
use rednaoeasycalculationforms\core\Utils\ArrayUtils;
use rednaoeasycalculationforms\DTO\FieldBaseOptionsDTO;
use Twig\Markup;

abstract class FBFieldBase implements ComparisonSource
{
    static $LINE_ITEMS_UNIQ_ID=0;

    /** @var FieldBaseOptionsDTO */
    public $Options;
    /** @var FBColumn */
    public $Column;
    public $Entry;
    /** @var CalculatorBase */
    public $Calculator;
    /** @var Loader */
    public $Loader;
    public $LineItemsUniqId=0;
    public function __construct($loader, $fbColumn, $options,$entry=null)
    {
        $this->Loader=$loader;
        $this->Column=$fbColumn;
        $this->Options=$options;

        $this->Entry=null;
        if($entry==null&&$this->Column!=null&&$this->Column->Row->Form->GetFieldsEntryData()!=null)
            foreach ($this->Column->Row->Form->GetFieldsEntryData() as $currentEntry )
            {
                if(!\is_array($currentEntry)&&$currentEntry->Id==$this->Options->Id)
                    $this->Entry=$currentEntry;
            }
        else
            $this->Entry=$entry;

        if(isset($this->Options->PriceType))
        {
            $this->Calculator=CalculatorFactory::GetCalculator($this);
        }else
            $this->Calculator=new NoneCalculator($this);

    }



    public function Initialize(){
        $this->SanitizeEntry();
    }

    public function SanitizeEntry(){

    }

    public function CommitFiles(){

    }

    public function PrepareForSerialization(){

    }

    public function GetOptionValue($optionName,$defaultValue)
    {
        if(!isset($this->Options->$optionName))
            return $defaultValue;
        return $this->Options->$optionName;
    }

    public function GetConditionByType($conditionType)
    {
        if(!isset($this->Options->Conditions))
            return array();

        return ArrayUtils::Filter($this->Options->Conditions,function ($item)use($conditionType){return $item->Type==$conditionType;});
    }

    public function GetEntryValue($path,$default='',$entryObject=null){
        if($entryObject!==null)
            $entry=$entryObject;
        else
            $entry=$this->Entry;
        if($entry==null||!isset($entry->$path))
            return $default;

        return $entry->$path;
    }

    /**
     * @return \rednaoeasycalculationforms\core\Managers\FormManager\FormBuilder
     */
    public function GetForm(){
        if(isset($this->Column))
            if(isset($this->Column->Row))
                if(isset($this->Column->Row->Form))
                {
                    return $this->Column->Row->Form;
                }

        return null;
    }

    public function GetPrice(){

        if(isset($this->Options->PriceType)&& $this->Options->PriceType=='none')
        {
            return \floatval($this->ToText());
        }
        return $this->Calculator->GetPrice();

    }

    public function GetRootForm(){
        if($this->GetForm()==null)
            return null;
        return $this->GetForm()->GetRootForm();

    }

    public function GetRegularPrice(){
        return 0;
    }

    public function GetId(){
        return $this->Options->Id;
    }
    public function GetValue(){
        return $this->GetEntryValue('Value');
    }

    /**
     * @return LineItem[]
     */
    public function GetLineItems(){

        if($this->Entry==null||!isset($this->Entry->Id))
            return null;

        if($this->LineItemsUniqId==0)
            $this->LineItemsUniqId=++self::$LINE_ITEMS_UNIQ_ID;

        $lineItem=new LineItem();
        $lineItem->UniqId=$this->LineItemsUniqId;
        $lineItem->FieldId=$this->Entry->Id;
        if(isset($this->Entry->Value))
            $lineItem->Value=$this->Entry->Value;
        $lineItem->TotalFieldPrice=$this->GetEntryValue('Price',0);
        $lineItem->UnitPrice=$this->GetEntryValue('Price',0);
        $lineItem->Type=$this->Options->Type;
        return array($lineItem);
    }

    public function GetStoresInformation(){
        return true;
    }

    public function IsUsed(){

        if($this->GetRootForm()!=null&&$this->GetRootForm()->IsTest&&$this->GetStoresInformation())
            return true;

        return $this->InternalIsUsed();
    }

    public function InternalIsUsed(){
        $value=$this->GetValue();
        if(\is_array($value))
            return count($value)>0;
        return $this->GetValue()!==null&&$this->GetValue()!=='';
    }
    public function GetIndex(){
        return 0;
    }

    public function ToText()
    {
        if($this->GetRootForm()->IsTest)
            return '[Test Value]';
        if(!$this->IsUsed())
            return '';
        return $this->InternalToText();
    }

    protected function InternalToText(){
        return $this->GetEntryValue('Value');

    }
    public function ToNumber(){
        $text=$this->ToText();
        if(!\is_numeric($text))
            return 0;

        return \floatval($text);
    }


    public function GetHTMLTemplate($context=null){
        return 'core/Managers/FormManager/Fields/FBFieldBase.twig';
    }

    /**
     * @return string
     */
    public function GetHtml($context=null){
        return new Markup($this->GetRootForm()->Loader->GetTwigManager()->Render($this->GetHTMLTemplate($context),$this,array('Context'=>$context)),"UTF-8");
    }



    public function CommitCreation()
    {
    }

    public function GetLabel(){
        if(isset($this->Options->Label)&& trim($this->Options->Label) != '')
            return $this->Options->Label;
        return '';


    }

    public function GetSubSections(){
        return [];
    }

    public function GetColumnById($pathId)
    {
        foreach($this->GetSubSections() as $currentSection)
        {
            if($currentSection->PathId==$pathId)
                return $currentSection->Column;
        }

        return '';
    }


}
