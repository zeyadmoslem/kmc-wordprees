<?php 

namespace rednaoeasycalculationforms\DTO;

class MessageConfirmationItemOptionsDTO extends ConfirmationItemBaseOptionsDTO{
	/** @var string */
	public $Title;
	public $Content;
	/** @var string */
	public $ButtonText;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->ConfirmationType=ConfirmationTypeEnumDTO::$Message;
		$this->Title='';
		$this->Content=null;
		$this->ButtonText='';
		$this->AddType("Content","Object");
	}
}

