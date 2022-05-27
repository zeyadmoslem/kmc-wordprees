<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Calculator;


use rednaoeasycalculationforms\Managers\FormulaManager\FormulaManager;
use rednaoeasycalculationforms\Parser\Elements\ParseMain;

class FormulaCalculator extends CalculatorBase
{

    public function GetDependsOnOtherFields(){
        return true;
    }


    public function ExecutedCalculation($value)
    {
        $formula=FormulaManager::GetFormula($this->Field,'Price');
        if($formula==null)
            return $this->CreateCalculationObject('','',0);

        $fields=$this->Field->GetForm()->ContainerManager->Getfields(false,true,true);
        $formula=FormulaManager::GetFormula($this->Field,'Price');

        $parser=new ParseMain($fields,$formula->Compiled,$this->Field);

        return $this->CreateCalculationObject($parser->Parse(),'',0);


    }
}