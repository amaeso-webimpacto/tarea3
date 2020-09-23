<?php

if(!defined('_PS_VERSION_'))
	exit;

class ModuleDemo extends Module
{
	private $_html = '';
	
	public function __construct()
	{
		$this->name = 'moduledemo';
		$this->tab = 'front_offices_features';
		$this->version = '1.0';
		$this->author = 'ana';
		$this->ps_version_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
		
		$this->need_instance = 0;
		$this->bootstrap = true;
		
		parent::__construct();
		
		$this->displayName = $this->l('Module Demo');
		$this->description = $this->l('Just a demo');
		
	}
	public function install()
	{
		if(
		!parent::install() OR
		!$this->registerHook('displayHeader') OR
		!$this->registerHook('displayLeftColumn')
		)
		return false;
		return true;
	}
	
	public function uninstall()
	{
		if(
		!parent::uninstall() OR
		!Configuration::get('MODULEDEMO_TEST_TEXT')
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
	
	public function displayForm()
	{
		$this->_html .= $this->_generateForm();
		//$this->contex->smarty->assign(array(
		//    'ourtext' => Configuration::get('MODULEDEMO_TEST_TEXT')
		//	));
		//$this->_html .= $this->display(__FILE__, 'views/templates/admin/congif.tpl');
		
		//if(Tools::isSubmit('submitUpdate'))
		//{
		//	Configuration::updateValue('MODULEDEMO_TEST_TEXT', Tools::getValue('ourtext'), true);
		//	$html .=$this->displayConfirmation($this->l('Settings Updated'));
		//}
		
		//$this->_html .= '
		//<form action="'.$SERVER['REQUEST_URI'].'" method="post" class=!"defaultForm form-horizontal">
		//<div class="panel">
		//    <div class="panel-heading">'.$this->l('Settings').'</div>';
		
		//$this->_html .= '
		//<div class="form-group">
		//<label class="control-label col-lg-3">'.$this->l('My Field').'</label>
		// <div class="col-lg-6">
		//   <textarea name="ourtext">'.Configuration::get('MODULEDEMO_TEST_TEXT').'</textarea>
	    //  </div>
		//</div>
        //';
		
        //$this->_html .= '
        //<input type="submit" name="submitUpdate" value="'.$this->l('Save').'" class-"btn btn-default">
        //';
  
        //$this->_html .= '
        //</div>
        //</form>
        //';
        //return $html;		
	}
	
	public function _generateForm()
	{
		$inputs = array();
		$inputs[] = array(
		'type' => 'textarea',
		'label' => $this->1('Test Me'),
		'name' => 'ourtext',
		'desc' => 'Description'
		);
		
		$fieldes_form = array(
		'form' => array(
		 'legend' => arrray(
		   'title' => $this->1('Settings'),
		   'icon' => 'icon-cogs'
		   ),
		 'input' => $inputs, 
		 'submit' => array(
		    'title' => $this->1('Save'),
			'class' => 'btn btn-default pull-right'
			)
	     )
		);
	}
	
    public function hookDisplayHeader($params)
    {
	    $this->context->controller->addCSS($this->_path. 'views/css/moduledemo.css');
	    $this->context->controller->addJS($this->_path. 'views/js/moduledemo.js');
	}

    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assing('my_special_text', Configuration::get('MODULEDEMO_TEST_TEXT'));
        return $this->display(__FILE__, 'leftColumn.tpl');
    }
}
