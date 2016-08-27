<?php

class NewsController extends Controller {
   
   public function beforeAction($action) {
      return true;
   }
   
   public function init() {
      //date_default_timezone_set('GMT');
   }
   //function to get posts
   public function actionPosts( $offset, $category = NULL) {
		// posts per page
		$limit = Yii::app()->params->post_count;
		// data array return
      $data = array();
		// creating postAPI object
      $postAPI = new PostAPI;
		if($offset != ""){
			$news = $postAPI->getPosts( $offset, $limit, $category );
			$newsList = array();
			
			if ($news) {
				foreach ($news as $story) {
					$newsDetails = $postAPI->parsePost($story);
					array_push($newsList, $newsDetails);
				}
				$data['status'] = '200';
				$data['message'] = 'Stories found';
				$data['news'] = $newsList;
				$this->apiReturn($data);
			} else {
				$data['status'] = '202';
				$data['message'] = 'Stories not found';
				$data['news'] = array();
				$this->apiReturn($data);
			}
		} else {
			$data['status'] = '202';
			$data['message'] = 'Stories not found';
			$data['news'] = array();
			$this->apiReturn($data);
		}
   }
	//function to get posts
   public function actionSearch( $offset, $query = NULL) {
		// posts per page
		$limit = Yii::app()->params->post_count;
		// data array return
      $data = array();
		// creating postAPI object
      $postAPI = new PostAPI;
		if($offset != "" && $query){
			$news = $postAPI->getSearchPosts( $offset, $limit, $query );
			$newsList = array();
			
			if ($news) {
				foreach ($news as $story) {
					$newsDetails = $postAPI->parsePost($story);
					array_push($newsList, $newsDetails);
				}
				$data['status'] = '200';
				$data['message'] = 'Stories found';
				$data['news'] = $newsList;
				$this->apiReturn($data);
			} else {
				$data['status'] = '202';
				$data['message'] = 'Stories not found';
				$data['news'] = array();
				$this->apiReturn($data);
			}
		} else {
			$data['status'] = '202';
			$data['message'] = 'Stories not found';
			$data['news'] = array();
			$this->apiReturn($data);
		}
   }
	//get all categories
	public function actionCategory(){
		$data = array();
		// creating postAPI object
      $postAPI = new PostAPI;
      $cats = $postAPI->getCategories();
		if($cats){
			$data['status'] = '200';
         $data['message'] = 'Succes';
         $data['categories'] = $cats;
         $this->apiReturn($data);
		} else {
			$data['status'] = '202';
         $data['message'] = 'Not found';
         $data['categories'] = array();
         $this->apiReturn($data);
		}
	}
	public function actionPost($id){
		$data = array();
		// creating postAPI object
      $postAPI = new PostAPI;
		if($id){
			$post = $postAPI->getPostDetailsById($id);
			if($post){
				$newsDetails = $postAPI->parsePost($post);
				$data['status'] = '200';
				$data['message'] = 'Succes';
				$data['post'] = $newsDetails;
				$this->apiReturn($data);
			} else {
				$data['status'] = '202';
				$data['message'] = 'Not found';
				$data['post'] = array();
				$this->apiReturn($data);
			}
		} else {
			$data['status'] = '202';
			$data['message'] = 'Not found';
			$data['post'] = array();
			$this->apiReturn($data);
		}
	}
}
