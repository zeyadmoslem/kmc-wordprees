<?php 

namespace rednaoeasycalculationforms\DTO;

use rednaoeasycalculationforms\DTO\core\StoreBase;

class SettingOptionsDTO extends StoreBase{
	/** @var CurrencyOptionsDTO */
	public $Currency;
	/** @var LogOptionsDTO */
	public $LogOptions;
	/** @var Boolean */
	public $EnableDebugMode;
	/** @var string */
	public $GoogleMapsApiKey;
	/** @var RecaptchaOptionsDTO */
	public $Recaptcha;
	/** @var Numeric */
	public $MinimumScore;


	public function LoadDefaultValues(){
		$this->Currency=(new CurrencyOptionsDTO())->Merge();
		$this->LogOptions=(new LogOptionsDTO())->Merge();
		$this->Recaptcha=(new RecaptchaOptionsDTO())->Merge();
		$this->EnableDebugMode=false;
		$this->GoogleMapsApiKey='';
		$this->MinimumScore=0.4;
	}
}

