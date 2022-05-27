<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class MultipleStepOptionsDTO extends StoreBase{
	/** @var string */
	public $NextButtonText;
	/** @var string */
	public $PreviousButtonText;
	/** @var string */
	public $SubmitButtonText;
	/** @var MultipleStepItemDTO[] */
	public $Steps;


	public function LoadDefaultValues(){
		$this->NextButtonText='Next';
		$this->PreviousButtonText='Previous';
		$this->SubmitButtonText='Submit';
		$this->Steps=[];
		$this->AddType("Steps","MultipleStepItemDTO");
	}
}

