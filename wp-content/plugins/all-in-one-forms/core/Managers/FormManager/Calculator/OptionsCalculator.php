<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Calculator;


use Exception;
use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBMultipleOptionsField;
use rednaoeasycalculationforms\core\Managers\FormManager\Utilities\NumericUtilities;

class OptionsCalculator extends CalculatorBase
{
    /** @var FBMultipleOptionsField */
    public $Field;
    public $IsValid;
    public function ExecutedCalculation($value)
    {
        $this->IsValid=true;
        $selectedOptions=$this->Field->GetSelectedOptions();
        if(count($selectedOptions)==0)
            return $this->CreateCalculationObject('','',0);

        $this->OptionsTotal=array();

        foreach($selectedOptions as $currentOption)
        {
            $result=null;

            $optionsTotal=array(
              'Id'=>$currentOption->Id,
              'SalePrice'=>$result['SalePrice'],
              'RegularPrice'=>$result['RegularPrice'],
              'UnitPrice'=>$result['SalePrice']==''?$result['RegularPrice']:$result['SalePrice'],
              'Quantity'=>0
            );

            if($optionsTotal['UnitPrice']=='')
                $optionsTotal['UnitPrice']=0;
            else
                $optionsTotal['UnitPrice']=\floatval($optionsTotal['UnitPrice']);

            $optionsTotal['Price']=$optionsTotal['UnitPrice'];

            $this->OptionsTotal[]=$optionsTotal;
            if( \floatval($currentOption->UnitPrice)!=\floatval($optionsTotal['UnitPrice'])||
                \floatval($currentOption->Price)!=\floatval($optionsTotal['Price'])

            )
                $this->IsValid=false;


            $currentOption->total->Price=$optionsTotal['UnitPrice'];
            $currentOption->total->Quantity=0;
            $currentOption->total->RegularPrice=NumericUtilities::ParseNumber($result['RegularPrice'],0);
            $currentOption->total->SalePrice=NumericUtilities::ParseNumber($result['SalePrice'],0);

        }



        $priceToReturn=$this->CreateCalculationObject(0,0,0);
        $hasSalePrice=false;
        foreach($this->OptionsTotal as $total)
        {
            if($total['SalePrice']!='')
                $hasSalePrice=true;
        }


        foreach($this->OptionsTotal as $total)
        {
            if($hasSalePrice)
            {
                $priceToReturn['SalePrice']+=\floatval($total['Price']);
                $priceToReturn['RegularPrice']+=\floatval($total['RegularPrice']);
            }else{
                $priceToReturn['SalePrice']=0;
                $priceToReturn['RegularPrice']+=\floatval($total['Price']);
            }
        }




        return $priceToReturn;

    }

    public function GetIsValid()
    {
        return $this->IsValid;
    }


    public function GetDependsOnOtherFields(){
        return false;
    }


    private function AddOption($original, $ammountToAdd)
    {
        if($ammountToAdd['RegularPrice']!='')
        {
            $original['RegularPrice']=NumericUtilities::ParseNumber($original['RegularPrice'],0)+NumericUtilities::ParseNumber($ammountToAdd['RegularPrice'],0);
        }

        if($ammountToAdd['SalePrice']!='')
        {
            $original['SalePrice']=NumericUtilities::ParseNumber($original['SalePrice'],0)+NumericUtilities::ParseNumber($ammountToAdd['SalePrice'],0);
        }

        return $original;
    }


}