<?php

if(!defined('_PS_VERSION_'))
	exit;

class Tarea3 extends Module
{
	private $_html = '';
	
	public function __construct()
	{
		$this->name = 'tarea3';
		$this->tab = 'front_offices_features';
		$this->version = '1.0.0';
		$this->author = 'ana';
		$this->ps_version_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
		
		$this->need_instance = 0;
		$this->bootstrap = true;
		
		parent::__construct();
		
		$this->displayName = $this->l('Tarea 3');
		$this->description = $this->l('Modulo que llama a API del tiempo según localización del usuario');
		
	}
	 public function install()
    	{
		if(
		!parent::install() OR
		!$this->registerHook('displayHeader') OR
		!$this->registerHook('displayNav')
		)
		return false;
		return true;
    	}
	
	public function uninstall()
	{
		if(
		!parent::uninstall() OR
		!$this->unregisterHook('displayHeader') OR
		!$this->unregisterHook('displayNav')
		)
		return false;
		return true;
	}
	
	public function getContent()
	{
		$this->_postProcess();
		$this->_displayForm();
        return $this->_html;		
	}
	
	private function _postProcess()
	{
		if(Tools::isSubmit('submitUpdate'))
		{
			Configuration::updateValue('MODULEDEMO_TEST_TEXT', Tools::getValue('ourtext'), true);
		    $html .=$this->displayConfirmation($this->l('Settings Updated'));
		}
	}
	

	
    //public function hookDisplayHeader($params)
    //{
	  //  $this->context->controller->addCSS($this->_path. 'views/css/moduledemo.css');
	    //$this->context->controller->addJS($this->_path. 'views/js/moduledemo.js');
	//}

    public function hookDisplayNav($params)
    {
        //$this->context->smarty->assing('my_special_text', Configuration::get('MODULEDEMO_TEST_TEXT'));
        return $this->display(__FILE__, 'displayNav.tpl');
    }
}
