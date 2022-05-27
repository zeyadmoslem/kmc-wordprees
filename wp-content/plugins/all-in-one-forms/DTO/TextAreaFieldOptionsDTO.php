<?php 

namespace rednaoeasycalculationforms\DTO;

class TextAreaFieldOptionsDTO extends FieldWithPriceOptionsDTO{
	/** @var string */
	public $DefaultText;
	/** @var string */
	public $Placeholder;
	public $FreeCharOrWords;
	/** @var Boolean */
	public $IgnoreSpaces;
	public $Icon;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->IgnoreSpaces=false;
		$this->Type=FieldTypeEnumDTO::$TextArea;
		$this->Label='Text area';
		$this->Placeholder='';
		$this->DefaultText='';
		$this->FreeCharOrWords=0;
		$this->Icon=(new IconOptionsDTO())->Merge();
		$this->AddType("Icon","Object");
	}
}

