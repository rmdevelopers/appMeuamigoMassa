<?php

class DefaultController extends Controller {
    
    public function init() {
        date_default_timezone_set('GMT');
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->getClientScript();
            $cs->registerScript('currentUrl', 'var currentUrl = "' . Yii::app()->createAbsoluteUrl("newadmin/default") . '";', CClientScript::POS_HEAD);
            $cs->registerScript('currentImageUrl', 'var currentImageUrl = "' . Yii::app()->request->baseUrl . '/media/admin/";', CClientScript::POS_HEAD);
        } else {
            $this->layout = "ajax";
        }
    }
    /*
    error action
    */
    public function actionError() {
        $this->layout = 'errormain';
        if ($error = Yii::app()->errorHandler->error) {
            $this->render('error', array(
                'error' => $error
            ));
        }
    }
    /*
    permission denied action
    */
    public function actionPermission() {
        $this->render('permission');
    }
    
    /*
    Admin and contributer login
    */
    public function actionLogin() {
        if (!isset(Yii::app()->user->admin_id) || Yii::app()->user->admin_id == "") {
            $model = new LoginForm;
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate()) {
                    $this->redirect(array(
                        'default/dashboard'
                    ));
                }
            }
            $this->layout = "loginmain";
            $this->render('login', array(
                'model' => $model
            ));
        } else {
            $this->redirect(array(
                'default/dashboard'
            ));
        }
    }
    /*
    Password reset function
    */
    public function actionForgotpassword($success = NULL) {
        $model = new ForgotForm;
        if (isset($_POST['ForgotForm'])) {
            $model->attributes = $_POST['ForgotForm'];
            if ($model->validate()) {
                $this->redirect(array(
                    'default/forgotpassword/success/1'
                ));
            }
        }
        $this->layout = "loginmain";
        $this->render('admin-forgot-pass', array(
            'model' => $model,
            'success' => $success
        ));
    }
    /*
    Password reset action
    */
    public function actionPasswordreset($success = NULL) {
        $adminAPI = new AdminAPI;
        $token = isset($_GET['id']) ? $_GET['id'] : '';
        $error = '0';
        if ($token) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('token', array(
                $token
            ));
            $User = NeUser::model()->find($criteria);
            if (empty($User)) {
                $error = '1';
            }
        }
        $model = new PasswordResetForm;
        if (isset($_POST['PasswordResetForm'])) {
            $model->attributes = $_POST['PasswordResetForm'];
            if ($model->validate() && $error == '0') {
                $ststus = $adminAPI->saveNewPassword($model->attributes, $User);
                if ($ststus)
					 	Yii::app()->user->setFlash('success', "Changed sucessfully!");
                 	$this->redirect(array(
                  	'default/login/'
                	));
            }
        }
        $this->layout = "loginmain";
        $this->render('password-reset', array(
            'model' => $model,
            'success' => $success,
            'error' => $error
        ));
    }
    /*
    Dashboard action
    */
    public function actionDashboard() {
        $this->render('dashboard');
    }
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array(
            'default/login'
        ));
    }
	/* user functions here */
	// user Registration
	public function actionUsernew() {
		// object new user form
		$model = new UsernewForm;
		$adminAPI = new AdminAPI;
		$UserDetails = array();
		$user_id = isset($_GET['id']) ? $_GET['id'] : '';
		if ($user_id) {
			$UserDetails = $adminAPI->getUserDetailsById($user_id);
			$model->attributes = $UserDetails->attributes;
			$model->user_password = "";
		}
		if (isset($_POST['UsernewForm'])) {
			$model->attributes = $_POST['UsernewForm'];
			if ($model->validate()) {
				 if (!isset($_GET['id'])) {
					  $adminAPI->insertUserNewAdmin($model->attributes);
					  Yii::app()->user->setFlash('success', "Saved sucessfully!");
					  $this->redirect(array(
							'default/users'
					  ));
				 } else {
					  $adminAPI->updateUserNewAdmin($user_id, $model->attributes);
					  Yii::app()->user->setFlash('success', "Updated sucessfully!");
					  $this->redirect(array(
							'default/users'
					  ));
				 }
			}
		}
		$this->render('user-new', array(
			'model' => $model,
			'user_id' => $user_id,
			'UserDetails'=>$UserDetails
		));
	}
   // users
	public function actionUsers() {
	  $adminAPI = new AdminAPI;
	  $model = new NeUser('search');
	  if (isset($_GET['NeUser'])) {
			$model->attributes = $_GET['NeUser'];
	  }
	  $this->render('users', array(
			'model' => $model
	  ));
	}
	//delete user used
   public function actionDeleteuser() {
        
		$adminAPI = new AdminAPI;
		$deleteId = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
		if ($deleteId) {
			$user = NeUser::model()->findByPk((int) $deleteId);
			if($user){
				$adminAPI->deleteUser($deleteId);
				$this->redirect(array(
				'default/users'
				));
			} 
		}
 	}
	/* user functions end here */
	/* category functions */
	//categories
	public function actionCategory() {
		$model = new NeCategory('search');
		if (isset($_GET['NeCategory'])) {
			$model->attributes = $_GET['NeCategory'];
		}
		$this->render('categories', array(
			'model' => $model,
		));
    }
	//Add new term
	public function actionCategorynew() {
		$model = new NewCatForm;
		$adminAPI = new AdminAPI;
		$termDetails = array();
		
		$term_id = isset($_GET['id']) ? $_GET['id'] : '';
		
		if ($term_id) {
			$termDetails = $adminAPI->getCategoryDetailsById($term_id);
			$model->attributes = $termDetails->attributes;
		}
		$delete_image = isset($_GET['delete_image']) ? $_GET['delete_image'] : '';
		if($delete_image){
			$catDetails = $adminAPI->getCategoryDetailsById($delete_image);
			$catDetails->image = "";
			$catDetails->save();
			$this->redirect(array(
				'default/categorynew/id/'.$delete_image
			));
		}
		if (isset($_POST['NewCatForm'])) {
			$model->attributes = $_POST['NewCatForm'];
			if ($model->validate()) {
				if (!isset($_GET['id'])) {
					$id = $adminAPI->insertNewTerm( $model->attributes, $_FILES['NewCatForm'] );
					Yii::app()->user->setFlash('success', "Saved sucessfully!");
					$this->redirect(array(
						'default/categorynew/id/'.$id
					));
				} else {
					$id = $adminAPI->updateTerm( $term_id, $model->attributes, $_FILES['NewCatForm'] );
					Yii::app()->user->setFlash('success', "Saved sucessfully!");
					$this->redirect(array(
						'default/categorynew/id/'.$id
					));
				}
			}
		}
		$this->render('category-new', array(
			'model' => $model,
			'term_id' => $term_id,
			'termDetails' => $termDetails
		));
		
	}
	/*
	delete category
	*/
	public function actionDeletecategory() {
	
		$adminAPI = new AdminAPI;
		$deleteId = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
		if ($deleteId) {
			$termDetails = NeCategory::model()->findByPk((int) $deleteId);
			if($termDetails){
				$adminAPI->deleteTerm($deleteId);
				$this->redirect(array(
					'default/category/'
				));
			} 
		}
	}
	/*
	reviews aka posts
	*/
	public function actionPosts() {
		$adminAPI = new AdminAPI;
		$activate_id = isset($_GET['activate_id']) ? $_GET['activate_id'] : '';
		if ($activate_id) {
			$adminAPI->PostActivate($activate_id);
			$this->redirect(array(
				'default/posts'
			));
		}
		$model = new NePosts('search');
		if (isset($_GET['NePosts'])) {
			$model->attributes = $_GET['NePosts'];
		}
		$this->render('posts', array(
			'model' => $model
		));
	  
	}
	// send push notification
	public function actionSendpush(){
		$post_id = isset($_GET['id']) ? $_GET['id'] : '';
		$adminAPI = new AdminAPI;
		if($post_id){
			$adminAPI->sendNotificationAndroid($post_id);
			Yii::app()->user->setFlash('success', "Sent sucessfully!");
			  $this->redirect(array(
					'default/posts/'
			  ));
		}
	}
	//url create action
	public function actionAjaxurlcreate(){
		$adminAPI = new AdminAPI;
		$setPost = "1";
		 if(isset($_POST)){
			 if(isset($_POST['NewPostForm'])){
				 $data = $_POST['NewPostForm'];
				 $setPost = "2";
			 }
			 if($setPost == "2"){
				 if( $data['slug'] ){
					$GotUrl = $adminAPI->post_slug($data['slug']);
					echo json_encode(array('status'=>'success','url'=>$GotUrl));
					die;
				 } else {
					if($data['title']){
						$GotUrl = $adminAPI->post_slug($data['title']);
						echo json_encode(array('status'=>'success','url'=>$GotUrl));
						die;
					} else {
						echo json_encode(array('status'=>'error'));
						die;
					}
				 }
			 }
		 }
	}
    //Add a new post or update exisitng
	public function actionNewpost() {
	
		$postDetails = array();
		$model = new NewPostForm;
		$adminAPI = new AdminAPI;
		
		$cats = $adminAPI->getallCategories();
		$categories = $this->keyValuePair($cats,'cat_id','title');
		$post_id = isset($_GET['id']) ? $_GET['id'] : '';
		$delete_image = isset($_GET['delete_image']) ? $_GET['delete_image'] : '';
		if ($post_id) {
			$postDetails = $adminAPI->getPostDetailsById($post_id);
			$model->attributes = $postDetails->attributes;
		}
		if($delete_image){
			$postDetails = $adminAPI->getPostDetailsById($delete_image);
			$postDetails->image = "";
			$postDetails->save();
			$this->redirect(array(
				'default/newpost/id/'.$delete_image
			));
		}
		if (isset($_POST['NewPostForm'])) {
			$model->attributes = $_POST['NewPostForm'];
			if ($model->validate()) {
				 if (!isset($_GET['id'])) {
					  $idpost = $adminAPI->insertNewAdminPost($model->attributes, $_FILES['NewPostForm']);
					  Yii::app()->user->setFlash('success', "Saved sucessfully!");
					  $this->redirect(array(
							'default/posts/'
					  ));
				 } else {
					  $idpost = $adminAPI->updateAdminPost($model->attributes, $post_id, $_FILES['NewPostForm']);
					  Yii::app()->user->setFlash('success', "Saved sucessfully!");
					  $this->redirect(array(
							'default/posts/'
					  ));
				 }
			}
		}
		$this->render('new-post', array(
			'model' => $model,
			'postDetails' => $postDetails,
			'categories'=>$categories
		));
	}
	/*
	delete post action -- clean
	*/
	public function actionDeletepost() {
	
		$deleteId = isset($_GET['delete_id']) ? $_GET['delete_id'] : '';
		if ($deleteId) {
			NePosts::model()->deleteByPk((int)$deleteId);
			$this->redirect(array(
				'default/posts'
			)); 
		}
	}
	public function keyValuePair($array,$key,$val){
		$data = array();
        foreach ($array as $arr) {
            $data[$arr->$key] = $arr->$val;
        }
		return $data;
	}
}
	