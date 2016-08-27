<?php

class PasswordResetForm extends CFormModel
{
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
			 array('user_password', 'required'),
			 array('user_password', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(		
		'user_password' => 'Password',	
		);
	}
	
}
// JavaScript Document