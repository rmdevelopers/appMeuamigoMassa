<?php
class PostAPI extends BaseAPI {
	
	public function __construct(){
   	//$criteria = new CDbCriteria;
   }
	// get posts
	public function getPosts( $offset, $limit, $cat_id = NULL ){
		// get posts only published
		$offset = $offset * $limit;
		$criteria = new CDbCriteria;
		$criteria->condition = " t.status = 'published' ";
		if($cat_id){
			$criteria->condition .= ' AND t.cat_id = :cat_id';
			$criteria->params = array(
				':cat_id' => $cat_id
			);
		}
		$criteria->offset = (int)$offset;
      $criteria->limit = (int)$limit;
      $criteria->order = ' t.created_dt DESC ';
		$posts = NePosts::model()->with('Cat','User')->findAll($criteria);
      return $posts;
	}
	// get posts
	public function getSearchPosts( $offset, $limit, $search ){
		
		$s = addcslashes($search, '%_');
		// get posts only published
		$offset = $offset * $limit;
		$criteria = new CDbCriteria;
		$criteria->condition = " ( t.status = :status ) AND ((t.title LIKE :title) or (t.description LIKE :description))";
		$criteria->params=array(':status'=>'published',':title'=> "%$s%",':description'=> "%$s%");
		$criteria->offset = (int)$offset;
      $criteria->limit = (int)$limit;
      $criteria->order = ' t.created_dt DESC ';
		$posts = NePosts::model()->with('Cat','User')->findAll($criteria);
      return $posts;
	}
	// parse post function to parse posts and converting as simple arrays
	public function parsePost($post){
		
		$postData = array();
		$postData['id'] = $post->id;
		$postData['title'] = $post->title;
		$postData['slug'] = $post->slug;
		$postData['url'] =  Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug);
		$postData['description'] = $post->description;
		$postData['source'] = $post->source;
		$postData['source_title'] = $post->source_title;
		$postData['created_dt'] = $this->time2StringFormatted($post->created_dt);
		$postData['updated_dt'] = $this->time2StringFormatted($post->updated_dt);
		$postData['image'] = $post->image != '' ? Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/static/' . $post->image : Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/static/default_image.png';
		$postData['category'] = array();
		if($post->cat_id){
			$postData['category']['cat_id'] = $post->cat_id;
			$postData['category']['title'] = $post->Cat->title;
		}
		$postData['author'] = array();
		if($post->user_id){
			$postData['author']['user_id'] = $post->user_id;
			$postData['author']['user_full_name'] = $post->User->user_full_name;
		}
		return $postData;
		
	}
	//getting all categories
	public function getCategories(){
		$cats = NeCategory::model()->findAll();
		$dataReturn = array();
		if($cats){
			foreach($cats as $cat){
				$singleCat = array();
				$singleCat['cat_id'] = $cat->cat_id;
				$singleCat['title'] = $cat->title;
				$singleCat['slug'] = $cat->slug;
				$singleCat['image'] = $cat->image != '' ? Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/static/' . $cat->image : Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . '/static/default_image.png';;
				array_push($dataReturn, $singleCat);
				
			}
			return $dataReturn;
		} else {
			return false;
		}
	}
	// time 2 string
	protected function time2string($timeline){
		if($timeline/86400 > 1)
		{
		  $num = ceil($timeline/86400);
		  $num .= ' days ago';
		}
		elseif($timeline/3600 > 1)
		{
		  $num = ceil($timeline/3600);
		  $num .= ' hours ago';
		}
		elseif($timeline/60 > 1)
		{
		  $num = ceil($timeline/60);
		  $num .= ' minutes ago';
		}
		else
		 $num = 'just now';
		
		return trim($num);
   }
	// more accurate time 2 string
	protected function time2StringFormatted($timeline) {
    	
		$activitydate = "";
      $timediff = time() - strtotime($timeline);

		if ($timediff < 86400 && $timediff > 59)
			$activitydate = $this->time2string($timediff);
		elseif ($timediff < 60)
			$activitydate = 'just now';
		else
			$activitydate = date('F j, Y', strtotime($timeline));
		
		return $activitydate;
    }
	 /*
	get post details with id
	*/
	public function getPostDetailsById($id){
		$criteria = new CDbCriteria;
		$criteria->select = '*';
		$criteria->condition = " id  = :id ";	
		$criteria->params = array(':id'=>(int)$id);		
		return $post = NePosts::model()->find($criteria);
	}
}