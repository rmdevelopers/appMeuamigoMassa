<?php

class DeviceController extends Controller {
   
   public function beforeAction($action) {
      return true;
   }
   
   public function init() {
      //date_default_timezone_set('GMT');
   }
   // saving device id and token in database
   public function actionIndex() {
		$postData = CJSON::decode(file_get_contents('php://input'));
		
		if($postData['token'] && $postData['device_id']){
			$criteria = new CDbCriteria;
			$criteria->addInCondition('device_id', array($postData['device_id']));
			$device = NeDevice::model()->find($criteria);
			if($device){
				$device->device_token = $postData['token'];
				$device->device_id = $postData['device_id'];
				$device->device_type = $postData['platform'];
				
				$device->save();
			} else {
				$device = new NeDevice;
				$device->device_token = $postData['token'];
				$device->device_id = $postData['device_id'];
				$device->device_type = $postData['platform'];
				$device->enable = 'yes';
				$device->save();
			}
		}
   }
	// getting push notification status from server --
	public function actionPushstatus($device_id){
		
		if($device_id){
			$criteria = new CDbCriteria;
			$criteria->addInCondition('device_id', array($device_id));
			$device = NeDevice::model()->find($criteria);
			if($device){
				$data['status'] = '200';
				$data['message'] = 'Success';
				$data['enable'] = $device->enable;
				$this->apiReturn($data);
			} else {
				$data['status'] = '202';
				$data['message'] = 'Not found';
				$data['enable'] = "no";
				$this->apiReturn($data);
			}
		}
	}
	// changing push notification status
	public function actionPush(){
		$postData = CJSON::decode(file_get_contents('php://input'));
		if($postData['device_id'] && $postData['status']){
			$criteria = new CDbCriteria;
			$criteria->addInCondition('device_id', array($postData['device_id']));
			$device = NeDevice::model()->find($criteria);
			if($device){
				$device->enable = $postData['status'];
				$device->save();
			}
		}
	}
}
