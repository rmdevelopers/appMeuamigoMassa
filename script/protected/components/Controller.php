<?php

class Controller extends CController
{
	
	public $layout='column1';
	
	public $menu=array();
	
	public $breadcrumbs=array();
	public $arrcache;
	public $get_option;
	public $currentActionFeed;
	public $currentContrFeed;
	
	public $pageTitle = 'Tiny News';
   public $pageDesc = '';
   public $pageRobotsIndex = "true";
	public $pageRobotsFollow = "true";
	public $pageCanonial = '';
	public $pageOrgLink = '';
   public $pageOgTitle = '';
   public $pageOgDesc = '';
   public $pageOgImage = '';
	public $pageOgType = '';
	public $searchTerm = '';
	
	public function beforeAction( $action ){
		//Yii::app()->cache->delete($this->arrcache);
		$this->currentContrFeed = Yii::app()->controller->id;
		$this->currentActionFeed = Yii::app()->controller->action->id;
		return true;
	}
	public function display_seo(){
		$robots = "";
    	echo "\t".''.PHP_EOL;
		if ( !empty($this->pageDesc) ) {
    		echo "\t".'<meta name="description" content="',CHtml::encode($this->pageDesc),'">'.PHP_EOL;
		}
		if ( !empty($this->pageCanonial) ) {
        	echo "\t".'<link rel="canonical" href="',CHtml::encode($this->pageCanonial),'">'.PHP_EOL;
    	}
		if( $this->pageRobotsIndex == "false" ){
			echo '<meta name="robots" content="noindex">'.PHP_EOL;
		}
    	if ( !empty($this->pageOgTitle) ) {
        	echo "\t".'<meta property="og:title" content="',CHtml::encode($this->pageOgTitle),'">'.PHP_EOL;
    	}
    	if ( !empty($this->pageOgDesc) ) {
        	echo "\t".'<meta property="og:description" content="',CHtml::encode($this->pageOgDesc),'">'.PHP_EOL;
    	}
    	if ( !empty($this->pageOgImage) ) {
        	echo "\t".'<meta property="og:image" content="',CHtml::encode($this->pageOgImage),'">'.PHP_EOL;
    	}
		
		if ( !empty($this->pageOrgLink) ) {
        	echo "\t".'<meta property="og:url" content="',CHtml::encode($this->pageOrgLink),'">'.PHP_EOL;
    	} elseif ( !empty($this->pageCanonial) ) {
        	echo "\t".'<meta property="og:url" content="',CHtml::encode($this->pageCanonial),'">'.PHP_EOL;
    	}
		if ( !empty($this->pageOgType) ) {
        	echo "\t".'<meta property="og:type" content="',CHtml::encode($this->pageOgType),'">'.PHP_EOL;
    	}
		
	}
	public function apiReturn($data){
		$status_header = 'HTTP/1.1 ' . $data['status'] . ' ' . $this->_getStatusCodeMessage($data['status']);
    	header($status_header);
    	header('Content-type: ' . 'application/json');
		echo  CJSON::encode($data); 
		die;
	}
	private function _getStatusCodeMessage($status){
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
			200 => 'OK',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
}