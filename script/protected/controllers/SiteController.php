<?php

class SiteController extends Controller {
   
   public function init() {
      Yii::app()->theme = 'newsapp';
      $this->layout = "main";
      parent::init();
   }
   // home page posts action
   public function actionIndex() {
      $posts = array();
      $pageval = isset($_GET['page']) ? $_GET['page'] : '1';
      $pageval = (int) $pageval;
      $criteria = new CDbCriteria();
      $criteria->select = "*";
      $criteria->addInCondition('status', array(
         'published'
      ));
      $criteria->order = " t.created_dt DESC ";
      $count = NePosts::model()->count($criteria);
      $pages = new CPagination($count);
      // results per page
      $pages->pageSize = Yii::app()->params->post_count;
      $pages->applyLimit($criteria);
      $posts = NePosts::model()->with('Cat', 'User')->findAll($criteria);
      $this->render('index', array(
         'posts' => $posts,
         'pages' => $pages,
         'pageval' => $pageval
      ));
   }



   // single post
   public function actionPost($id, $url = NULL) {
      if ($id) {
         $post = NePosts::model()->find(array(
            'select' => '*',
            'condition' => ' id = :id ',
            'params' => array(
               ':id' => (int) $id
            )
         ));
         if (!empty($post)) {
            $this->render('post', array(
               'post' => $post
            ));
         }
      }
   }
   public function actionCategory($category) {
      $catDetails = $this->getPostCatId($category);
      if ($catDetails) {
         $pageval = isset($_GET['page']) ? $_GET['page'] : '1';
         $pageval = (int) $pageval;
         $criteria = new CDbCriteria();
         $criteria->select = "*";
         $criteria->condition = " status = 'Published' ";
         $criteria->condition .= " AND t.cat_id = " . $catDetails->cat_id . "";
         $criteria->order = " t.created_dt DESC ";
         $count = NePosts::model()->count($criteria);
         $pages = new CPagination($count);
         
         // results per page
         $pages->pageSize = Yii::app()->params->post_count;
         $pages->applyLimit($criteria);
         $posts = NePosts::model()->with('Cat', 'User')->findAll($criteria);
         
         $this->render('category', array(
            'posts' => $posts,
            'pages' => $pages,
            'pageval' => $pageval,
            'catDetails' => $catDetails
         ));
      } else {
         $this->redirect(array(
            'site/index'
         ));
      }
   }
   
   public function getPostCatId($slug) {
      
      $post = NeCategory::model()->find(array(
         'select' => '*',
         'condition' => 'slug=:url',
         'params' => array(
            ':url' => $slug
         )
      ));
      if ($post) {
         return $post;
      }
   }
   public function actionSearch() {
      $pageval = isset($_GET['page']) ? $_GET['page'] : '1';
      $s = isset($_GET['s']) ? $_GET['s'] : '';
      $pageval = (int) $pageval;
      $criteria = new CDbCriteria();
      $criteria->select = "*";
      
      if ($s) {
         $s = addcslashes($s, '%_');
         $criteria->condition = " status = 'Published' ";
         $this->searchTerm = $s;
         $criteria->condition = " ( t.status = :status ) AND ((t.title LIKE :title) or (t.description LIKE :description) )";
         $criteria->params = array(
            ':status' => 'Published',
            ':title' => "%$s%",
            ':description' => "%$s%"
         );
      } else {
         $this->redirect(array(
            '/search-form'
         ));
      }
      $criteria->order = " t.created_dt DESC ";
      $count = NePosts::model()->count($criteria);
      $pages = new CPagination($count);
      // results per page
      $pages->pageSize = Yii::app()->params->post_count;
      $pages->applyLimit($criteria);
      $posts = NePosts::model()->with('Cat')->findAll($criteria);
      
      $this->render('search-results', array(
         'posts' => $posts,
         'pages' => $pages,
         'pageval' => $pageval,
         's' => $s
      ));
   }
	public function actionSearchform(){
		$this->render('search-form');
	}
   public function actionGo() {
      $url = $_SERVER['QUERY_STRING'];
      if (filter_var($url, FILTER_VALIDATE_URL)) {
         $this->redirect($url, '301');
      } else {
         $this->redirect(Yii::app()->params->site_url);
      }
      
   }
	// creating first user -- aka installation
	public function actionInstall() {
		$user = NeUser::model()->count();
		if($user == 0){
			// object new user form
			$model = new UsernewForm;
			$adminAPI = new AdminAPI;
			if (isset($_POST['UsernewForm'])) {
				$model->attributes = $_POST['UsernewForm'];
				if ($model->validate()) {
					 if (!isset($_GET['id'])) {
						  $adminAPI->insertUserNewAdmin($model->attributes);
						  Yii::app()->user->setFlash('success', "Saved sucessfully!");
						  $this->redirect(array(
								'/newadmin/default/login'
						  ));
					 }
				}
			}
			$this->render('user-new', array(
				'model' => $model
			));
		} else {
			$this->redirect(Yii::app()->params->site_url);
		}
	}
   
}