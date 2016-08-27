<?php

class AdminAPI extends BaseAPI {
	public function __construct()
    {
        $criteria = new CDbCriteria;
    }
	/*
	Admin login function
	Checking user name exisits then verifying password
	*/
	public function loginAdmin($username, $password)
    {
		$user = NeUser::model()->find(
			array(
				'condition' => 'user_name = :username ',
				'params' => array(
					':username' => $username,
					)
				)
			);
        if( $user === null ){
			  return 'invalid';
		} else {
			//echo $this->bcrypt_hash($password); die;
			if(!($this->bcrypt_check($password,$user->user_password))){
				return 'invalid';
			}
			Yii::app()->user->setState('user_id', $user->user_id);
			Yii::app()->user->setState('admin_id', $user->user_id);
			Yii::app()->user->setState('admin_username', $user->user_name);
			$this->errorCode = NULL;
        }
    }
	function bcrypt_hash($password, $work_factor = 8){
    	if (version_compare(PHP_VERSION, '5.3') < 0) throw new Exception('Bcrypt requires PHP 5.3 or above');
 
    	if (! function_exists('openssl_random_pseudo_bytes')) {
        	throw new Exception('Bcrypt requires openssl PHP extension');
    	}
 		if ($work_factor < 4 || $work_factor > 31) $work_factor = 8;
    	$salt = '$2a$' . str_pad($work_factor, 2, '0', STR_PAD_LEFT) . '$' .
        substr(
            strtr(base64_encode(openssl_random_pseudo_bytes(16)), '+', '.'), 
            0, 22
        )
    ;
    return crypt($password, $salt);
	}
 
	function bcrypt_check($password, $stored_hash, $legacy_handler = NULL){
    	if (version_compare(PHP_VERSION, '5.3') < 0) throw new Exception('Bcrypt requires PHP 5.3 or above');
    	if ($this->bcrypt_is_legacy_hash($stored_hash)) {
       	if ($legacy_handler) return call_user_func($legacy_handler, $password, $stored_hash);
        	else throw new Exception('Unsupported hash format');
    	}
    	return crypt($password, $stored_hash) == $stored_hash;
	}
	
 	function bcrypt_is_legacy_hash($hash) {
		return substr($hash, 0, 4) != '$2a$'; 
	}
	
	public function emailAdminPass($email){
		$criteria = new CDbCriteria;
	   $criteria->addInCondition('user_email', array($email));
		$User = NeUser::model()->find($criteria);
		if(count($User) > 0){
			$mainRand = mt_rand();
			$mainRand = md5($mainRand);
			$User->token = $mainRand;
			if($User->save()){
				$this->sendPassWordResetEmail($User);
			}
		} else {
			return 'Email not registered';
		}
		
	}
	public function saveNewPassword($attributes,$User){
		$Model = NeUser::model()->findByPk((int)$User->user_id);
		$Model->user_password = $this->bcrypt_hash($attributes['user_password']);
		$Model->token = "";
		if($Model->save()){
			return TRUE;
		}
	}
	/*
	User email exisits function -- clean
	*/
	public function UserEmailExists($email, $id=NULL){
		$criteria = new CDbCriteria;
		$criteria->addInCondition('user_email', array($email));
		if($id){
			$criteria->condition .= " AND user_id != '".(int)$id."' ";
		}
		$User = NeUser::model()->count($criteria);
		if($User>0){
			return true;
		} else {
			return false;
		}
	}
	/*
	User name exisits function -- clean
	*/
	public function UserNameExists($username, $id=NULL){
		$criteria = new CDbCriteria;
		$criteria->addInCondition('user_name', array($username));
		if($id){
			$criteria->condition .= " AND user_id != '".(int)$id."' ";
		}
		$User = NeUser::model()->count($criteria);
		if($User>0){
			return true;
		} else{
			return false;
		}
	}
	/*
	user details / used
	*/
	public function getUserDetailsById($userId){
	
		$UserDetails=NeUser::model()->find(array(
			'select'=>'*',
			'condition'=>'user_id=:id',
			'params'=>array(
				':id'=>(int)$userId
			),
		));
		if($UserDetails)
		{
			return $UserDetails;
		}
	}
	/*
	User insert details -- clean
	*/
	public function insertUserNewAdmin($attributes) {
	
		$Model = new NeUser;
		$Model->user_email = $attributes['user_email'];
		$Model->user_password = $this->bcrypt_hash($attributes['user_password']);
		$Model->user_name = $attributes['user_name'];
		$Model->user_full_name = $attributes['user_full_name'];
		$status = $Model->save();
		if ($status)
		{
			return $Model->user_id ;
		}
		else
			return FALSE;
	}
	/*
	User update details -- clean
	*/
	public function updateUserNewAdmin($id,$attributes) {
	
		$Model = NeUser::model()->findByPk((int)$id);
		$Model->user_email = $attributes['user_email'];
		if($attributes['user_password']){ 
			$Model->user_password = $this->bcrypt_hash($attributes['user_password']);
		}
		$Model->user_name = $attributes['user_name'];
		$Model->user_full_name = $attributes['user_full_name'];
		$status = $Model->save();
		if ($status){
			return $Model->user_id ;
		}
		else
			return FALSE;
	}
	/*
	Delete user details -- clean
	*/
	public function deleteUser($deleteId){
		$UserDetails = NeUser::model()->deleteByPk((int)$deleteId);
		return $UserDetails;
	}
	/*
	category exists function to check whether exists -- clean
	*/
	public function termExists($slug,$id=NULL){
		$criteria = new CDbCriteria;
		$criteria->addInCondition('slug', array($this->post_slug($slug)));
		if($id){
			$criteria->condition .= " AND cat_id != '".(int)$id."' ";
		}
		$cat = NeCategory::model()->count($criteria);
		if($cat>0){
			return true;
		} else {
			return false;
		}
	}
	/*
	category details with id -- clean
	*/
	public function getCategoryDetailsById($cat_id){
	
		$termDetails=NeCategory::model()->find(array(
			'select'=>'*',
			'condition'=>'cat_id=:id',
			'params'=>array(':id'=>$cat_id),
		));
		if($termDetails) {
			return $termDetails;
		} else {
			return false;
		}
	}
	/*
	insert category details details -- clean
	*/
	public function insertNewTerm( $attributes, $FILES ) {
	
		$Model = new NeCategory;
		$Model->title = $attributes['title'];
		$Model->slug = $this->post_slug($attributes['slug']);
		if($FILES['name']['image']!=""){
			$imagefolder = $this->createImgFolder();
			$mainfolder = 'static/'.$imagefolder;
			$ext = pathinfo($FILES['name']['image'], PATHINFO_EXTENSION);
			$imageNameWithoutExt = $this->getFileName(pathinfo($FILES['name']['image'], PATHINFO_FILENAME),$mainfolder,$ext);
			$imageName = $imageNameWithoutExt.'.'.$ext;
			$tempName = $FILES['tmp_name']['image'];
			move_uploaded_file($tempName,$mainfolder.'/'.$imageName);
			$Model->image = $imagefolder.'/'.$imageName;
		}
		$status = $Model->save();
		if ($status) {
			return $Model->cat_id ;
		} else {
			return FALSE;
		}
	}
	/*
	update category details -- clean
	*/
	public function updateTerm($id, $attributes, $FILES) {
		
		$Model = NeCategory::model()->findByPk((int)$id);
		$Model->title = $attributes['title'];
		$Model->slug = $this->post_slug($attributes['slug']);
		if($FILES['name']['image']!=""){
			$imagefolder = $this->createImgFolder();
			$mainfolder = 'static/'.$imagefolder;
			$ext = pathinfo($FILES['name']['image'], PATHINFO_EXTENSION);
			$imageNameWithoutExt = $this->getFileName(pathinfo($FILES['name']['image'], PATHINFO_FILENAME),$mainfolder,$ext);
			$imageName = $imageNameWithoutExt.'.'.$ext;
			$tempName = $FILES['tmp_name']['image'];
			move_uploaded_file($tempName,$mainfolder.'/'.$imageName);
			$Model->image = $imagefolder.'/'.$imageName;
		}
		$status = $Model->save();
		if ($status) {
			return $Model->cat_id ;
		} else {
			return FALSE;
		}
	}
	/*
	delete term  -- clean
	*/
	public function deleteTerm($deleteId){
		$term = NeCategory::model()->deleteByPk((int)$deleteId);
		return $term;
	}
	/*
	get all categories -- clean
	*/
	public function getallCategories(){
		$criteria = new CDbCriteria;
		$criteria->select = '*';
	 	return $terms = NeCategory::model()->findAll($criteria);
	}
	/*
	some folder stuff here 
	*/
	public function createImgFolder(){
		
		$tdDate = date('Y-m-d');
		$dateArray = explode("-",$tdDate);
		if (!file_exists("static/images/".$dateArray['0'])){
			mkdir("static/images/".$dateArray['0'], 0777);
			}
		if (!file_exists("static/images/".$dateArray['0']."/".$dateArray['1'])){
				mkdir("static/images/".$dateArray['0']."/".$dateArray['1'], 0777);
			}
		if (file_exists("static/images/".$dateArray['0']."/".$dateArray['1'])){
					return "images/".$dateArray['0']."/".$dateArray['1'];
			}
		
	}
	/*
	create a new post -- clean
	*/
	public function insertNewAdminPost($attributes, $FILES=NULL) {
      $Model = new NePosts;
		$Model->user_id = Yii::app()->user->user_id;
		$Model->title = $attributes['title'];
      $Model->slug = $this->post_slug($attributes['slug']);
		$Model->description = $attributes['description'];
		$Model->cat_id = $attributes['cat_id'];
		$Model->source = $attributes['source'];
		$Model->source_title = $attributes['source_title'];
		if($attributes['created_dt']){
			$Model->created_dt = date('Y-m-d H:i:s',strtotime($attributes['created_dt']));
		} else {
			$Model->created_dt = date('Y-m-d H:i:s');	
		}
		$Model->updated_dt = date('Y-m-d H:i:s');
		$Model->status = $attributes['status'];
		if($FILES['name']['image']!=""){
			$imagefolder = $this->createImgFolder();
			$mainfolder = 'static/'.$imagefolder;
			$ext = pathinfo($FILES['name']['image'], PATHINFO_EXTENSION);
			$imageNameWithoutExt = $this->getFileName(pathinfo($FILES['name']['image'], PATHINFO_FILENAME),$mainfolder,$ext);
			$imageName = $imageNameWithoutExt.'.'.$ext;
			$tempName = $FILES['tmp_name']['image'];
			move_uploaded_file($tempName,$mainfolder.'/'.$imageName);
			$Model->image = $imagefolder.'/'.$imageName;
		}
	 	$status = $Model->save();
		if ($status){
			return $Model->id;
		}
        
    }
	/*
	update post details -- clean
	*/
	public function updateAdminPost($attributes, $id, $FILES=NULL) {
		$Model = NePosts::model()->findByPk($id);
		$Model->title = $attributes['title'];
      $Model->slug = $this->post_slug($attributes['slug']);
		$Model->description = $attributes['description'];
		$Model->cat_id = $attributes['cat_id'];
		$Model->source = $attributes['source'];
		$Model->source_title = $attributes['source_title'];
		if($attributes['created_dt']){
			$Model->created_dt = date('Y-m-d H:i:s',strtotime($attributes['created_dt']));
		}
		$Model->updated_dt = date('Y-m-d H:i:s');
		$Model->status = $attributes['status'];
		if($FILES['name']['image']!=""){
			$imagefolder = $this->createImgFolder();
			$mainfolder = 'static/'.$imagefolder;
			$ext = pathinfo($FILES['name']['image'], PATHINFO_EXTENSION);
			$imageNameWithoutExt = $this->getFileName(pathinfo($FILES['name']['image'], PATHINFO_FILENAME),$mainfolder,$ext);
			$imageName = $imageNameWithoutExt.'.'.$ext;
			$tempName = $FILES['tmp_name']['image'];
			move_uploaded_file($tempName,$mainfolder.'/'.$imageName);
			$Model->image = $imagefolder.'/'.$imageName;
		}
	 	$status = $Model->save();
		if ($status){
			return $Model->id;
		}
	
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
	/*
	library stuff some trimiing
	*/
	public function getFileName( $file_name,$main_folder,$file_ext ){
		$file_name = $this->post_slug($file_name);
		if(!file_exists($main_folder.'/'.$file_name.'.'.$file_ext)){
			return $file_name;
		} else {
			for($i=1;$i>=1;$i++){
				//echo $i; die;
				if(!file_exists($main_folder.'/'.$file_name.'_'.$i.'.'.$file_ext)){
					return $file_name.'_'.$i;
				}
				
			}
		}
		
	}
	public function sendPassWordResetEmail($user){
		$host = $_SERVER['SERVER_NAME'];
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
		$adminEmail = 'admin@'.$matches[0];
		$url = CHtml::encode(Yii::app()->createAbsoluteUrl('/newadmin/default/passwordreset/id/'.$user->token));
		$steName = Yii::app()->params->site_title;
		$email = "";
		$email .= '<table align="center" style="font-size:inherit;line-height:inherit;text-align:center;border-spacing:0;border-collapse:collapse;padding:0;border:0" cellpadding="0" cellspacing="0">';
		$email .= '<tr><td style="font-family:Helvetica,Arial,sans-serif;font-weight:300;min-height:16px" height="16"></td></tr><tr><td style="width:685px" width="685">';
		$email .= '<table style="font-family:Helvetica,Arial,sans-serif;font-weight:300;font-size:inherit;line-height:20px;padding:0px;border:0px">';
		$email .= '<tr><td style="font-family:Helvetica,Arial,sans-serif;font-weight:300;line-height:20px;text-align:left;font-size:14px;color:#333">Hey '.$user->user_email.' ,<br>';
		$email .= '<br>You have received this email because a password recovery for the user account with email '.$user->user_email.'. If you did not request this password change, please IGNORE and DELETE this email immediately. Only continue if you wish your password to be reset!<br>';
		$email .= '<br>Simply click on the link below to complete the rest of the Password Reset form: <br>';
		$email .= '<br><a href="'.$url.'" target="_blank">'.$url.'</a><br>';
		$email .= '</td></tr></table></td></tr></table>';
		$headers  = "From: $adminEmail \r\n"; 
   	$headers .= "Content-type: text/html\r\n";
		$this->sendUserEmail($user->user_email,'Password reset request from '.$steName,$email,$headers);
	}
	public function sendUserEmail($useremail,$subject,$message,$headers){
		//echo $message; die;
		if(mail($useremail,$subject,$message,$headers)){
			return TRUE;	
		}
	}
	public function remove_accent($str){ 
  		$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  		$strval = str_replace($a, $b, $str);
  		return strtolower($strval); 
	} 

	public function post_slug($str){ 
  		return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), 
  		array('', '-', ''), $this->remove_accent($str))); 
	}
	/*
	get all devices -- clean
	*/
	public function getallDevices($offset, $limit){
		
		$offset = $offset * $limit;
		$criteria = new CDbCriteria;
		$criteria->select = '*';
		$criteria->condition = " enable  = :enable ";	
		$criteria->params = array(':enable'=>'yes');
		$criteria->offset = (int)$offset;
      $criteria->limit = (int)$limit;	
	 	return $devices = NeDevice::model()->findAll($criteria);
	}
	// getting device ids and android push notification
	public function sendNotificationAndroid($id){
		$postDetais = $this->getPostDetailsById($id);
		//echo $postDetais->title; die;
		for($i = 0; $i >= 0; $i++){
			
			$devices = $this->getallDevices($i, 500);
			$device_ids = array();
			if($devices){
				foreach($devices as $device){
					if($device->device_type == 'android'){
						$device_ids[] = $device->device_token;
						$this->sendAndroidNotification($postDetais, $device_ids);
					}
				}
			} else {
				return true;
			}
		}
	}
	// android push notification function
	public function sendAndroidNotification($postDetais, $device_ids){
		//print_r($device_ids); die;
		$title = "New Post";
		$message = $postDetais->title;
		$sound = 1;
		$vibration = 1;
		// API access key from Google API's Console
		//define( 'API_KEY', Yii::app()->params->API_KEY );
		// prep the bundle
		$msg = array(
			'message' 	=> $message,
			'title'		=> $title,
			'subtitle'	=> '',
			'tickerText'	=> $message,
			'vibrate'	=> $sound,
			'sound'		=> $vibration,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon',
		);
		
		$fields = array(
			'registration_ids' 	=> $device_ids,
			'data'			=> $msg
		);
		 
		$headers = array(
			'Authorization: key=' . Yii::app()->params->API_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		return true;
		//echo $result;
	
	}
}