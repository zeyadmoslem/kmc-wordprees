<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Calculator;




use Exception;
use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;

class CalculatorFactory
{
    /**
     * @param $field FBFieldBase
     * @return
     */
    public static function GetCalculator($field)
    {
        switch ($field->Options->PriceType)
        {
            case 'float':
                return new GroupCalculator($field);
            case 'total_inside_repeater':
                return new GroupOfFieldsInGroupCalculator($field);
            case 'price_per_distance':
                return new PricePerDistance($field);
            case 'fixed_amount':
                return new FixedAmountCalculator($field);
            case 'current_value':
                return new CurrentValueCalculator($field);
            case 'quantity':
                return new QuantityCalculator($field);
            case 'price_per_char':
                return new PricePerCharCalculator($field);
            case 'price_per_word':
                return new PricePerWordCalculator($field);
            case 'none':
                return new NoneCalculator($field);
            case 'options':
                return new OptionsCalculator($field);
            case 'price_per_item':
                return new PricePerItemCalculator($field);
            case 'sum_of_fields_in_group':
                return new GroupOfFieldsInGroupCalculator($field);
            case 'price_per_day':
                return new PricePerDayCalculator($field);
            case 'quantity_per_day':
                return new QuantityPerDayCalculator($field);
            case 'formula':
                $formula= \apply_filters('rednaoeasycalculationforms_get_formula_calculator',null,$field);
                if($formula==null)
                    return new NoneCalculator($field);
                return $formula;
            case 'survey_options':
                return new SurveyOptionsCalculator($field);



        }

        throw new Exception('Undefined calculator'.$field->Options->PriceType);
    }
}