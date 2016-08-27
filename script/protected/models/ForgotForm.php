<?php

class ForgotForm extends CFormModel
{
	public $user_email;
	public $errorCode;
	
    public function init()
    {
	
    }
	

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			 // username and password are required
			 array('user_email', 'required'),
			 array('user_email', 'authenticate'),
			 array('user_email', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(		
		'user_email' => 'Email',	
		);
	}
	public function authenticate($attribute, $params)
    {
		$adminAPI = new AdminAPI;
		$error = $adminAPI->emailAdminPass($this->user_email);
		if($error){
			$this->addError("user_email", $error);
		}
    }
	
}
// JavaScript Document