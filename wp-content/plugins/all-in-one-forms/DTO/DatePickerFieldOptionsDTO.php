<?php 

namespace rednaoeasycalculationforms\DTO;

class DatePickerFieldOptionsDTO extends FieldWithPriceOptionsDTO{
	/** @var string */
	public $DefaultDate;
	/** @var string */
	public $Placeholder;
	/** @var Boolean */
	public $EnableTime;
	/** @var Boolean */
	public $ShowQuantitySelector;
	/** @var string */
	public $Format;
	/** @var Numeric */
	public $WeekStartOn;
	public $Icon;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=FieldTypeEnumDTO::$Datepicker;
		$this->EnableTime=false;
		$this->Label='Datepicker';
		$this->DefaultDate='';
		$this->Placeholder='';
		$this->Format='d/m/Y';
		$this->WeekStartOn=0;
		$this->Icon=(new IconOptionsDTO())->Merge();
		$this->AddType("Icon","Object");
	}
}

