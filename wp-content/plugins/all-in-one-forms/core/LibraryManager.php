<?php


namespace rednaoeasycalculationforms\core;


use rednaoeasycalculationforms\core\FieldsDictionary\FieldsDictionary;
use rednaoeasycalculationforms\core\Integration\UserIntegration;

class LibraryManager
{
    /** @var Loader */
    public $Loader;

    public $dependencies = [];

    public function __construct($loader)
    {
        $this->Loader = $loader;
    }

    public static function GetInstance(){
        return new LibraryManager(apply_filters('allinoneforms_get_loader',null));
    }

    public function GetDependencyHooks(){
        $hooks=[];
        foreach($this->dependencies as $currentDependency)
        {
            $hooks[]=\str_replace('@',$this->Loader->Prefix.'_',$currentDependency);
        }
        return $hooks;
    }

    public function AddConditionDesigner()
    {

        self::AddLit();
        self::AddFormBuilderCore();
        $this->Loader->AddScript('conditiondesigner','js/dist/RNMainConditionDesigner_bundle.js',array('@lit','@FormBuilderCore'));
        $this->Loader->AddStyle('conditiondesigner','js/dist/RNMainConditionDesigner_bundle.css');
        $this->AddDependency('@conditiondesigner');

        $userIntegration=new UserIntegration($this->Loader);
        $this->Loader->LocalizeScript('rnConditionDesignerVar','conditiondesigner','alloinoneforms_list_users',[
            "Roles"=>$userIntegration->GetRoles()
        ]);
    }

    private function AddDependency($dependency)
    {
        if (!in_array($dependency, $this->dependencies))
            $this->dependencies[] = $dependency;
    }

    public function AddConditionalFieldSet(){
        self::AddSwitchContainer();
        $this->Loader->AddScript('conditionalfieldset','js/dist/RNMainConditionalFieldSet_bundle.js',array('@switchcontainer'));
        $this->AddDependency('@conditionalfieldset');
    }

    public function AddSingleLineGenerator()
    {
        $this->Loader->AddScript('singlelinegenerator','js/dist/RNMainSingleLineGenerator_bundle.js');
        $this->AddDependency('@singlelinegenerator');

    }

    public function AddHTMLGenerator(){
        self::AddLit();
        $this->Loader->AddScript('htmlgenerator','js/dist/RNMainHTMLGenerator_bundle.js',array('@FormBuilderCore','@lit'));

    }

    public function AddSwitchContainer(){
        self::AddLit();
        $this->Loader->AddScript('switchcontainer','js/dist/RNMainSwitchContainer_bundle.js',array('@lit'));
        $this->AddDependency('@switchcontainer');

    }


    public function AddInputs(){
        self::AddLit();
        self::AddCore();
        self::AddSelect();
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->Loader->AddScript('inputs','js/dist/RNMainInputs_bundle.js',array('@lit','@select','@date'));
        $this->Loader->AddStyle('inputs','js/dist/RNMainInputs_bundle.css');

        $this->AddDependency('@inputs');

    }

    public function AddAlertDialog(){
        self::AddLit();
        self::AddCore();
        self::AddDialog();
        $this->Loader->AddScript('AlertDialog','js/dist/RNMainAlertDialog_bundle.js',array('@lit','@Dialog','@Core'));
        $this->Loader->AddStyle('AlertDialog','js/dist/RNMainAlertDialog_bundle.css');
        $this->AddDependency('@AlertDialog');

    }

    public function AddTextEditor(){
        self::AddLit();
        self::AddDialog();
        self::AddInputs();
        self::AddAccordion();
        $this->Loader->AddScript('texteditor','js/dist/RNMainTextEditor_bundle.js',array('@lit','@Dialog','@inputs'));
        $this->Loader->AddStyle('texteditor','js/dist/RNMainTextEditor_bundle.css');
        $this->AddDependency('@texteditor');

    }
    public function AddCore(){
        self::AddLoader();
        self::AddLit();
        $this->Loader->AddScript('Core', 'js/dist/RNMainCore_bundle.js', array('@loader', '@lit'));
        $this->AddDependency('@Core');
    }

    public function AddFormulas(){
        self::AddFormBuilderCore();
        $this->Loader->AddScript('Formula','js/dist/RNMainFormulaCore_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@Formula');
    }

    public function AddFormBuilderDesigner(){
        self::AddLit();
        self::AddCore();
        self::AddCoreUI();
        self::AddWPTable();
        self::AddDialog();
        self::AddPreMadeDialog();
        self::AddTabs();
        self::AddSpinner();
        self::AddConditionDesigner();

        $this->Loader->AddRNTranslator(array('InternalShared'));

        self::AddConditionalFieldSet();
        self::AddSingleLineGenerator();
        self::AddSwitchContainer();
        self::AddAccordion();
        self::AddSelect();
        self::AddHTMLGenerator();
        self::AddTextEditor();
        self::AddDate();
        self::AddInputs();
        self::AddFormBuilderCore();
        self::AddMultipleSteps();
        self::AddFormulas();

        $fields=FieldsDictionary::GetFields();
        foreach($fields as $currentField)
        {

            $this->Loader->AddScript($currentField->Name,'js/dist/RNMain'.$currentField->Name.'_bundle.js',array('@FormBuilderCore'));
            $this->AddDependency('@'.$currentField->Name);

            if($currentField->HasStyles)
            {
                $this->Loader->AddStyle($currentField->Name, 'js/dist/RNMain' . $currentField->Name . '_bundle.css');
            }
        }

        $this->Loader->AddScript('CurrentValueCalculator','js/dist/RNMainCurrentValueCalculator_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@CurrentValueCalculator');
        $this->Loader->AddScript('QuantityCalculator','js/dist/RNMainQuantityCalculator_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@QuantityCalculator');
        $this->Loader->AddScript('PricePerItemCalculator','js/dist/RNMainPricePerItemCalculator_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@PricePerItemCalculator');

        $this->Loader->AddScript('ShowHideCondition','js/dist/RNMainShowHideCondition_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@ShowHideCondition');
        $this->Loader->AddScript('ValidationCondition','js/dist/RNMainValidationCondition_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@ValidationCondition');
        $this->Loader->AddScript('ChangeOptionsCondition','js/dist/RNMainChangeOptionsCondition_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@ChangeOptionsCondition');
        $this->Loader->AddScript('ChangeOptionsPriceCondition','js/dist/RNMainChangeOptionsPriceCondition_bundle.js',array('@FormBuilderCore'));
        $this->AddDependency('@ChangeOptionsPriceCondition');


        $this->Loader->AddScript('FormBuilderDesigner', 'js/dist/RNMainBuilder_bundle.js',array_merge( array('@FormBuilderCore'),$this->dependencies));
        $this->Loader->AddStyle('FormBuilderDesigner', 'js/dist/RNMainBuilder_bundle.css');
        $this->dependencies=[];
        $this->AddDependency('@FormBuilderDesigner');


    }

    public function AddFormBuilderCore(){
        self::AddCore();
        self::AddDialog();
        $this->Loader->AddScript('FormBuilderCore', 'js/dist/RNMainFormBuilderCore_bundle.js', array('@Core','@Dialog'));
        $this->Loader->AddStyle('FormBuilderCore', 'js/dist/RNMainFormBuilderCore_bundle.css');
        $this->AddDependency('@FormBuilderCore');
    }

    public function AddLoader()
    {
        $this->Loader->AddScript('loader', 'js/lib/loader.js');
        $this->AddDependency('@loader');
    }

    public function AddSelect(){
        $this->Loader->AddScript('select','js/lib/tomselect/js/tom-select.complete.js');
        $this->Loader->AddStyle('select','js/lib/tomselect/css/tom-select.bootstrap5.css');
        $this->AddDependency('@select');
    }


    public function AddLit()
    {
        self::AddLoader();
        $this->Loader->AddScript('lit', 'js/dist/RNMainLit_bundle.js', array('@loader'));
        $this->AddDependency('@lit');
    }

    public function AddCoreUI()
    {
        self::AddCore();
        $this->Loader->AddScript('CoreUI', 'js/dist/RNMainCoreUI_bundle.js', array('@Core'));
        $this->Loader->AddStyle('CoreUI', 'js/dist/RNMainCoreUI_bundle.css');

        $this->AddDependency('@CoreUI');
    }

    public function AddTranslator($fileList)
    {
        $this->Loader->AddRNTranslator($fileList);
        $this->AddDependency('@RNTranslator');
    }

    public function AddDialog()
    {
        self::AddLit();
        $this->Loader->AddScript('Dialog', 'js/dist/RNMainDialog_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Dialog', 'js/dist/RNMainDialog_bundle.css');
        $this->AddDependency('@Dialog');
    }

    public function AddContext(){
        self::AddLit();
        $this->Loader->AddScript('Context','js/dist/RNMainContext_bundle.js');
        $this->Loader->AddStyle('Context','js/dist/RNMainContext_bundle.css');
    }

    public function AddPreMadeDialog(){
        self::AddDialog();
        self::AddSpinner();
        $this->Loader->AddScript('PreMadeDialog', 'js/dist/RNMainPreMadeDialogs_bundle.js', array('@Dialog'));

    }

    public function AddDate(){
        self::AddLit();;
        $this->Loader->AddScript('date','js/lib/date/flatpickr.js',array('@lit'));
        $this->Loader->AddStyle('date','js/lib/date/flatpickr.min.css');
        $this->AddDependency('@date');
    }

    public function AddAccordion()
    {
        self::AddLit();
        $this->Loader->AddScript('Accordion', 'js/dist/RNMainAccordion_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Accordion', 'js/dist/RNMainAccordion_bundle.css');
        $this->AddDependency('@Accordion');
    }


    public function AddTabs()
    {
        $this->AddLit();
        $this->Loader->AddScript('Tabs', 'js/dist/RNMainTabs_bundle.js', array('@lit'));
        $this->Loader->AddStyle('Tabs', 'js/dist/RNMainTabs_bundle.css');

        $this->AddDependency('@Tabs');
    }

    public function AddSpinner(){
        self::AddLit();
        self::AddCore();
        $this->Loader->AddScript('Spinner', 'js/dist/RNMainSpinnerButton_bundle.js', array('@lit','@Core'));
        $this->Loader->AddStyle('Spinner', 'js/dist/RNMainSpinnerButton_bundle.css');
    }

    public function AddWPTable()
    {
        self::AddCore();
        $this->Loader->AddScript('WPTable', 'js/dist/RNMainWPTable_bundle.js', array('@Core'));
        $this->Loader->AddStyle('WPTable', 'js/dist/RNMainWPTable_bundle.css');
        $this->AddDependency('@WPTable');
    }

    public function AddMultipleSteps(){
        self::AddCore();
        self::AddFormBuilderCore();
        $this->Loader->AddScript('MultipleSteps','js/dist/RNMainRunnableMultipleSteps_bundle.js',array('@Core','@FormBuilderCore'));
        $this->Loader->AddStyle('MultipleSteps','js/dist/RNMainRunnableMultipleSteps_bundle.css');
        $this->AddDependency('@MultipleSteps');
    }
}