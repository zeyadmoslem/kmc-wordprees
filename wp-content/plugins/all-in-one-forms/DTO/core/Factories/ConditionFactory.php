<?php


namespace rednaoeasycalculationforms\DTO\core\Factories;


class ConditionFactory
{
    public static function GetConditions($value)
    {
        $newValue = [];
        foreach ($value as $currentCondition) {
            if ($currentCondition->Type == 'ShowHide')
                return null;
        }

        return $value;
    }

}