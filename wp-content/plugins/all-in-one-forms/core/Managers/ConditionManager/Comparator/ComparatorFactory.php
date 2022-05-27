<?php


namespace rednaoeasycalculationforms\core\Managers\ConditionManager\Comparator;


use rednaoeasycalculationforms\core\Managers\FormManager\Fields\FBFieldBase;
use rednaoeasycalculationforms\core\Managers\FormManager\FormBuilder;

class ComparatorFactory
{
    /**
     * @param $model FormBuilder
     * @param $field ComparisonSource
     * @return ComparatorBase
     */
    public static function GetComparator($model,$field)
    {
        switch ($field->Options->Type)
        {
            case 'text':
            case "textarea":
            case 'hidden':
            case 'masked':
                return new SingleValueComparator($model,$field);

            case 'radio':
            case 'checkbox':
            case "dropdown":
            case 'imagepicker':
            case 'buttonselection':
                return new MultipleValueComparator($model,$field);
            case 'datepicker':
            case 'slider':
                return new NumericalValueComparator($model,$field);
            case 'switch':
                return new CheckboxValueComparator($model,$field);
        }

        return new NoneValueComparator($model,$field);
    }

}