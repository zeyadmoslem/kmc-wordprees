<?php


namespace rednaoeasycalculationforms\pages;


use rednaoeasycalculationforms\core\db\core\DBManager;
use rednaoeasycalculationforms\core\db\core\OptionsManager;
use rednaoeasycalculationforms\core\db\FormRepository;
use rednaoeasycalculationforms\core\db\SettingsRepository;
use rednaoeasycalculationforms\core\FieldsDictionary\FieldsDictionary;
use rednaoeasycalculationforms\core\Integration\FilterManager;
use rednaoeasycalculationforms\core\Integration\IntegrationURL;
use rednaoeasycalculationforms\core\Integration\Media\MediaIntegration;
use rednaoeasycalculationforms\core\Integration\PageIntegration;
use rednaoeasycalculationforms\core\Integration\UserIntegration;
use rednaoeasycalculationforms\core\LibraryManager;
use rednaoeasycalculationforms\core\PageBase;

class Entries extends PageBase
{

    public function Render()
    {
        $this->Loader->CheckIfPDFAdmin();
        $mediaIntegration = new MediaIntegration($this->Loader);
        $mediaIntegration->EnqueueMedia();
        $libraryManager = new LibraryManager($this->Loader);

        $libraryManager->AddAlertDialog();
        $libraryManager->AddFormBuilderDesigner();
        $builderOptions=null;



        $additionalFields = array();
        $additionalFields = FilterManager::ApplyFilters('rednao-calculated-fields-get-additional-fields', $additionalFields);
        $settingsRepository = new SettingsRepository($this->Loader);

        $nextNumber = 1;


        $userIntegration = new UserIntegration($this->Loader);
        $pageIntegration = new PageIntegration($this->Loader);


        $this->Loader->AddScript('entries', 'js/dist/RNMainEntry_bundle.js', array_merge($libraryManager->GetDependencyHooks()));
        $this->Loader->AddStyle('entries', 'js/dist/RNMainEntry_bundle.css');

        $this->Loader->AddScript('runnableentries', 'js/dist/RNMainRunnableEntries_bundle.js', array('@entries'));
        $dbManager=new DBManager();

        $forms= $dbManager->GetResults('select form_id,form_name,element_options,client_form_options,icons from '.$this->Loader->FORM_LIST_TABLE.' order by form_name');


        $this->Loader->LocalizeScript('rednaoFormDesigner', 'FormBuilderDesigner', 'Entries', array(
            "FormList"=>$forms,
            'URL' => $this->Loader->URL,
            'FormListURL' => IntegrationURL::PageURL('rednao_calculation_form'),
            'IsDesign' => true,
            'BuilderOptions'=>$builderOptions,
            'Pages' => $pageIntegration->GetPageList(),
            'IsPr' => $this->Loader->IsPR(),
            'SettingsURL' => IntegrationURL::PageURL('rednao_calculation_form_settings'),
            'GoogleMapsApiKey' => $settingsRepository->GetGoogleMapsApiKey(),
            'PurchaseURL' => 'http://google.com',
            'ajaxurl' => IntegrationURL::AjaxURL(),
            'PreviewURL' => IntegrationURL::PreviewURL(),
            'Recaptcha' => $settingsRepository->GetRecaptchaPublicSettings(),
            'Currency' => $settingsRepository->GetCurrency(),
            'StatusList' => $settingsRepository->GetFormStatusList(),
            'UserRoles' => array(),
            'NextNumber' => $nextNumber,
            'Roles' => $userIntegration->GetRoles()
        ));


        echo '
            
            <div id="App"></div>';

    }



}