<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class FormulaOptionsDTO extends StoreBase{
	/** @var string */
	public $Code;
	/** @var string */
	public $Name;
	/** @var Numeric[] */
	public $Fields;
	public $PreferredReturnType;
	public $Compiled;


	public function LoadDefaultValues(){
		$this->Code='';
		$this->Name='';
		$this->Compiled=null;
		$this->PreferredReturnType=PreferredReturnTypeEnumDTO::$Price;
		$this->Fields=[];
		$this->AddType("Fields","Numeric");
		$this->AddType("Compiled","Object");
	}
}

