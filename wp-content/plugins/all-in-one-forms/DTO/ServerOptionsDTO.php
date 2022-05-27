<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class ServerOptionsDTO extends StoreBase{
	/** @var EmailItemOptionsDTO[] */
	public $Emails;
	public $Extensions;
	/** @var string */
	public $DefaultStatus;
	/** @var EntryNumberingOptionsDTO */
	public $EntryNumbering;
	/** @var RestrictionBaseOptionsDTO[] */
	public $Restrictions;
	/** @var ConfirmationBaseOptionsDTO */
	public $ConfirmationOptions;


	public function LoadDefaultValues(){
		$this->Emails=[];
		$this->Extensions=[];
		$this->DefaultStatus='completed';
		$this->ConfirmationOptions=(new ConfirmationBaseOptionsDTO())->Merge();
		$this->EntryNumbering=(new EntryNumberingOptionsDTO())->Merge();
		$this->Restrictions=[];
		$this->AddType("Emails","EmailItemOptionsDTO");
		$this->AddType("Extensions","Object");
		$this->AddType("Restrictions","RestrictionBaseOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Restrictions":
				return \rednaoeasycalculationforms\DTO\core\Factories\RestrictionFactory::GetRestrictions($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

