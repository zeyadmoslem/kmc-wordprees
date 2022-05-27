<?php 

namespace rednaoeasycalculationforms\DTO;

class TextFieldOptionsDTO extends FieldWithPriceOptionsDTO{
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
		$this->Type=FieldTypeEnumDTO::$Text;
		$this->Label='Text box';
		$this->IgnoreSpaces=false;
		$this->Icon=(new IconOptionsDTO())->Merge();
		$this->Placeholder='';
		$this->DefaultText='';
		$this->FreeCharOrWords=0;
		$this->AddType("Icon","Object");
	}
}

