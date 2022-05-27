<?php
/**
 * Plugin Name: All in one forms
 * Plugin URI: http://allinoneforms.rednao.com/getit
 * Description: Everything that you need in one place
 * Author: RedNao
 * Author URI: http://rednao.com
 * Version: 1.2.21
 * Text Domain: Easy Calculation Forms
 * Domain Path: /languages/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 * Slug: all-in-one-forms
 */


use rednaoeasycalculationforms\core\Loader;

spl_autoload_register('rednaoeasycalculationforms');
function rednaoeasycalculationforms($className)
{
    if(strpos($className,'rednaoeasycalculationforms\\')!==false)
    {
        $NAME=basename(\dirname(__FILE__));
        $DIR=dirname(__FILE__);
        $path=substr($className,26);
        $path=str_replace('\\','/', $path);
        require_once realpath($DIR.$path.'.php');
    }
}


$loader=new Loader(__FILE__,'rednaoeasycalculationforms',79,22);

function AllInOneForms(){
    return new rednaoeasycalculationforms\PublicApi\PublicApi();
}