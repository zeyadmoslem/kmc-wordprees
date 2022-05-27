<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class FieldBaseOptionsDTO extends StoreBase{
	/** @var string */
	public $Label;
	/** @var Numeric */
	public $Id;
	public $Type;
	public $Description;
	/** @var Boolean */
	public $Required;
	public $Tooltip;
	/** @var Boolean */
	public $IsFieldContainer;
	/** @var FormulaOptionsDTO[] */
	public $Formulas;
	/** @var ConditionBaseOptionsDTO[] */
	public $Conditions;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Label='';
		$this->Description=null;
		$this->Required=false;
		$this->Tooltip=null;
		$this->IsFieldContainer=false;
		$this->Formulas=[];
		$this->Conditions=[];
		$this->AddType("Description","Object");
		$this->AddType("Tooltip","Object");
		$this->AddType("Formulas","FormulaOptionsDTO");
		$this->AddType("Conditions","ConditionBaseOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Conditions":
				return \rednaoeasycalculationforms\DTO\core\Factories\ConditionFactory::GetConditions($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

