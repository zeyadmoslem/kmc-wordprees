<?php

namespace rednaoeasycalculationforms\PublicApi;

use rednaoeasycalculationforms\core\Loader;

class PublicApi
{
    /** @var Loader */
    private $loader;
    public function __construct()
    {
        $val='';
        $this->loader=apply_filters('allinoneforms_get_loader',$val);
    }

    public function GetLoader(){
        return $this->loader;
    }

    public function GetTwigManager($paths=[]){
        return $this->loader->GetTwigManager($paths);
    }

}