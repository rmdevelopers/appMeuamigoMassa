<?php

class NewCatForm extends CFormModel
{

	public $cat_id;
	public $title;
	public $slug;
	public $image;
	
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
			 array(' title, slug ', 'required'),
			 array(' title, slug, image, cat_id ', 'safe'),	
			 array('slug', 'validateCatSlug'),
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
			'title' => 'Title',
			'slug' => 'Slug',
			'image' => 'Icon',
		);
	}
	public function validateCatSlug($attribute, $params)
    {	
  		$adminAPI = new AdminAPI;
     	if($adminAPI->termExists($this->slug,$this->cat_id)) {
   		$this->addError("slug", "This already exists.");
  		} 
 	}
}
// JavaScript Document