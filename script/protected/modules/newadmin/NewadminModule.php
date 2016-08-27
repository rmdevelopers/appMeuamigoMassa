<?php

class NewadminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'newadmin.forms.*',
		));
		 Yii::app()->setComponents(array(
            'errorHandler'=>array(
            'errorAction'=>'newadmin/default/error',
        ),

		));
		$this->layout='mainadmin';
		return true;
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$controller->layout = 'mainadmin';
			if((!isset(Yii::app()->user->admin_id) || Yii::app()->user->admin_id=="") && $action->id!="login" && $action->id!="forgotpassword" && $action->id!="passwordreset"){
				 Yii::app()->request->redirect(Yii::app()->createUrl('newadmin/default/login'));
			}
			return true;
		}
		else
			return false;
	}
}
