<?php

class NewPostForm extends CFormModel
{

	public $id;
	public $title;
	public $slug;
	public $description;
	public $user_id;
	public $image;
	public $cat_id;
	public $source;
	public $source_title;
	public $status;
	public $created_dt;
	public $updated_dt;
	
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
			 array('title, slug, status, cat_id, description', 'required'),
			 array('id, title, slug, description, user_id, image, cat_id, source, source_title, status, created_dt, updated_dt ', 'safe'),
			 array('image', 'file',
			 	'types'=>'jpg, png, jpeg, gif','allowEmpty'=>true,
				'maxSize'=>1024 * 1024 * 1, 
			 	'tooLarge'=>'File has to be smaller than 1MB'
			),		 			 
		);
			
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
}
// JavaScript Document