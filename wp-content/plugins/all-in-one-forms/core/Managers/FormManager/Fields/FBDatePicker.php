<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;


class FBDatePicker extends FBFieldWithPrice
{
    public function GetLineItems()
    {
        $lineItems= parent::GetLineItems()[0];
        $lineItems->DateValue=date('c',$this->Entry->Unix);
        $lineItems->Value=$this->Entry->Value;

        return array($lineItems);
    }


}