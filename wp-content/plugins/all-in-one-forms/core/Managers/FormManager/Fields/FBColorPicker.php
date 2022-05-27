<?php

namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;


class FBColorPicker extends FBFieldWithPrice
{
    public function GetHTMLTemplate($context = null)
    {
        return 'core/Managers/FormManager/Fields/FBColorPicker.twig';
    }


}