<?php

/**
 * This is the model class for table "ne_posts".
 *
 * The followings are the available columns in table 'ne_posts':
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property integer $cat_id
 * @property string $source
 * @property string $created_dt
 * @property string $updated_dt
 */
class NePosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ne_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, cat_id', 'numerical', 'integerOnly'=>true),
			array('title, slug, image, source', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, slug, description, image, cat_id, source, created_dt, updated_dt', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Cat'=> array(self::BELONGS_TO, 'NeCategory', 'cat_id'),
         'User'=> array(self::BELONGS_TO,'NeUser','user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'slug' => 'Slug',
			'description' => 'Description',
			'image' => 'Image',
			'cat_id' => 'Category',
			'source' => 'Source Url',
			'created_dt' => 'Created Date',
			'updated_dt' => 'Updated Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('created_dt',$this->created_dt,true);
		$criteria->compare('updated_dt',$this->updated_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'created_dt DESC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NePosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
