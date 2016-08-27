<?php

class UsernewForm extends CFormModel
{
	public $user_email;
	public $user_password;
	public $user_name;
	public $user_full_name;
	public $user_id;
	
    public function init()
    {
	
    }
	

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			 array('user_email, user_name', 'required'),
			 array('user_email, user_password, user_name, user_full_name, user_id', 'safe'),
			 array(
				'user_name',
				'match', 'not' => true, 'pattern' => '/[^a-z0-9_-]/',
				'message' => 'Invalid characters in username. Numbers, alphabets, _ and -',
			 ),
			 array('user_email', 'isUserEmailExists'),
			 array('user_name', 'isUserNameExists'),
			 array('user_password', 'isUserpassAdmin'),
			 array('user_email','email'),		 			 
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		'user_email' => 'Email',
		'user_password' => 'Password',
		'user_name' => 'User name',
		);
	}
	//USEREMAIL EXISTS
	public function isUserEmailExists($attribute, $params)
    {	
  		$adminAPI = new AdminAPI;
        if($adminAPI->UserEmailExists($this->user_email,$this->user_id)) {
   			$this->addError("user_email", "This email already exists.");
  		} 
 	}
	public function isUserNameExists($attribute, $params)
    {	
  		$adminAPI = new AdminAPI;
        if($adminAPI->UserNameExists($this->user_name,$this->user_id)) {
   			$this->addError("user_name", "This username already exists.");
  		} 
 	}
	public function isUserpassAdmin($attribute, $params)
    {	if(!$this->user_id)
		{
			if(!$this->user_password){
			$this->addError("user_password", "Please enter a password.");
			}
		}
 	}
}
// JavaScript Document