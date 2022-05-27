<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;

use rednaoeasycalculationforms\DTO\FieldWithPriceOptionsDTO;

abstract class FBFieldWithPrice extends FBFieldBase
{
    /** @var FieldWithPriceOptionsDTO */
    public $Options;
    public function GetPriceWithoutFormula(){

    }


    public function GetRegularPrice(){
        return trim($this->Options->Price);
    }

}
