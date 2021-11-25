<?php


namespace App\Libraries;

require_once APPPATH . 'ThirdParty/Smarty/libs/Autoloader.php';

use \Smarty_Autoloader;

Smarty_Autoloader::register();

use \Smarty;

class CI4Smarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        // change Smarty's delimiters
        //parent::setLiterals(array('{{','}}'));

        parent::setTemplateDir(APPPATH . 'Views/templates');
        parent::setConfigDir(APPPATH . 'Views/configs');
        parent::setCompileDir(WRITEPATH . 'smarty/templates_c/')->setCacheDir(WRITEPATH . 'smarty/cache/');
    }

    public function view($tpl_name)
    {
        if (substr($tpl_name, -4) != '.tpl') {
            $tpl_name .= '.tpl';
        }

        parent::display($tpl_name);
    }
}
