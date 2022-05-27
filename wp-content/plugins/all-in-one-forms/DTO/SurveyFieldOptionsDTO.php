<?php 

namespace rednaoeasycalculationforms\DTO;

class SurveyFieldOptionsDTO extends FieldWithPriceOptionsDTO{
	/** @var ItemOptionsDTO[] */
	public $Columns;
	/** @var ItemOptionsDTO[] */
	public $Rows;
	/** @var AdditionalColumnOptionsDTO[] */
	public $AdditionalOptionColumn;
	/** @var Boolean */
	public $AllowMultiple;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=FieldTypeEnumDTO::$Survey;
		$this->Label='Survey';
		$this->Columns=[];
		$this->Rows=[];
		$this->AdditionalOptionColumn=[];
		$this->Columns=[];
		$this->AllowMultiple=false;
		$this->AddType("Columns","ItemOptionsDTO");
		$this->AddType("Rows","ItemOptionsDTO");
		$this->AddType("AdditionalOptionColumn","AdditionalColumnOptionsDTO");
	}
}

