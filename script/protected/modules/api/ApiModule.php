<?php
class ApiModule extends CWebModule
{

	public function init(){
		
	}

	public function beforeControllerAction($controller, $action){
		if(parent::beforeControllerAction($controller, $action)){
			return true;
		}
        else
            return false;
   }
   // converting data to json format
	public function apiReturn($data){
		$status_header = 'HTTP/1.1 ' . $data['status'] . ' ' . $this->_getStatusCodeMessage($data['status']);
    	header($status_header);
    	header('Content-type: ' . 'application/json');
		echo  CJSON::encode($data); 
		die;
	}
	// status messages
	private function _getStatusCodeMessage($status){
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
