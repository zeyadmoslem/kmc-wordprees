<?php


namespace rednaoeasycalculationforms\core\Managers\FormManager\Fields;


class FBImagePicker extends FBMultipleOptionsField
{
    public function GetHTMLTemplate($context = null)
    {
        return 'core/Managers/FormManager/Fields/FBImagePicker.twig';
    }

    public function GetIconData($iconName)
    {
        return $this->GetForm()->GetIcon($iconName);

    }

}