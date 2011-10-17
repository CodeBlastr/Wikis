<?php
App::import(array(
	'type' => 'File', 
	'name' => 'Wikis.WikisConfig', 
	'file' =>  '..' . DS . 'plugins'  . DS  . 'wikis'  . DS  . 'config'. DS .'core.php'
));

class WikisAppController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();		
		$Config = WikisConfig::getInstance();
		#sets display values
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View'])) {
			$this->set('settings', $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View']);
		}
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'])) {
			$this->settings = $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'];
		}
	}
	
}
?>