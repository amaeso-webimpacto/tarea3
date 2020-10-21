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
		!$this->registerHook('displayNav2')
		)
		return false;
		return true;
    	}
	
	public function uninstall()
	{
		if(
		!parent::uninstall() OR
		!$this->unregisterHook('displayHeader') OR
		!$this->unregisterHook('displayNav2')
		)
		return false;
		return true;
	}
	
    public function hookDisplayNav2($params)
    {
		/*
		//método file_get_contents:
		$variable = file_get_contents('http://api.weatherapi.com/v1/current.json?key=14f8ce7c6fc14acaaa480826202109&q=Chapineria');
		$resultado = json_decode($variable);

		echo "Temperatura: ", $resultado->current->temp_c, "ºC,    Presión: " , $resultado->current->pressure_mb, "mb,    Humedad: ", $resultado->current->humidity, "%"; 
		*/

		//método cURL
		$handle = curl_init();
		$url = ('http://api.weatherapi.com/v1/current.json?key=14f8ce7c6fc14acaaa480826202109&q=Chapineria');

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($handle);

		curl_close($handle);
		$data = json_decode($output);

		$this->smarty->assign(array(
			'temp_c' => $data->current->temp_c,
			'humidity' => $data->current->humidity,
			'pressure_mb' => $data->current->pressure_mb
			)
		);

		
		//return $data->current->humidity;
		return $this->display(__FILE__, 'tiempo.tpl');
    }
}
