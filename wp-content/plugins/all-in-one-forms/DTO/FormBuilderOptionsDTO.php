<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class FormBuilderOptionsDTO extends StoreBase{
	/** @var FBRowOptionsDTO[] */
	public $Rows;
	/** @var ClientOptionsDTO */
	public $ClientOptions;
	/** @var String[] */
	public $Dependencies;
	/** @var string */
	public $RequiredMessage;


	public function LoadDefaultValues(){
		$this->Rows=[];
		$this->ClientOptions=(new ClientOptionsDTO())->Merge();
		$this->Dependencies=[];
		$this->RequiredMessage='Required';
		$this->AddType("Rows","FBRowOptionsDTO");
		$this->AddType("Dependencies","String");
	}
}

