<?php

class LoginForm extends CFormModel
{
	public $user_name;
	public $user_password;
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
			 array('user_name, user_password', 'required'),
			 array('user_name', 'authenticate'),
			 array('user_name, user_password', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(		
		'user_name' => 'User name',
		'user_password' => 'Password',		
		);
	}
	public function authenticate($attribute, $params)
    {
		$adminAPI = new AdminAPI;
		$error = $adminAPI->loginAdmin($this->user_name,$this->user_password);
		if($error){
			$this->addError("user_password", $error);
		}
    }
	
}
// JavaScript Document