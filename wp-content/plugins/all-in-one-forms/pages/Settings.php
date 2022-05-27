<?php


namespace rednaoeasycalculationforms\pages;


use rednaoeasycalculationforms\core\db\SettingsRepository;
use rednaoeasycalculationforms\core\Integration\IntegrationURL;
use rednaoeasycalculationforms\core\LibraryManager;
use rednaoeasycalculationforms\core\PageBase;

class Settings extends PageBase
{

    public function Render()
    {
        $this->Loader->CheckIfPDFAdmin();
        $settingsRepository=new SettingsRepository($this->Loader);

        $libraryManager = new LibraryManager($this->Loader);
        $libraryManager->AddLit();
        $libraryManager->AddCore();
        $libraryManager->AddCoreUI();
        $libraryManager->AddTabs();
        $libraryManager->AddSpinner();
        $libraryManager->AddInputs();
        $libraryManager->AddSwitchContainer();

        $this->Loader->AddRNTranslator('Settings');
        $this->Loader->AddScript('settings','js/dist/RNMainSettings_bundle.js',$libraryManager->dependencies);
        $this->Loader->AddStyle('settings','js/dist/RNMainSettings_bundle.css');
            $this->Loader->LocalizeScript('RNSettingsVar','settings','Settings',array(
            'Currency'=>$settingsRepository->GetCurrency(),
            'LogOptions'=>$settingsRepository->GetLog(),
            'ajaxurl'=>IntegrationURL::AjaxURL(),
            'GoogleMapsApiKey'=>$settingsRepository->GetGoogleMapsApiKey(),
            'Recaptcha'=>$settingsRepository->GetRecaptchaSettings()
        ));


        echo "<div id='App'></div>";
    }
}