<?php
Yii::import('application.extensions.email.*');
require_once('mail.php');
class EmailAPI extends BaseAPI {
	public function __construct(){
       $criteria = new CDbCriteria;
   }
	public function sendEmailRegisterConfirm($model){
		$content = '';
		$subject = 'Please verify your email';
		$content .= 'Hi, '.$model->user_name.'<br>';
		$content .= 'Please verify your email address by following this link <a class="btn btn-link pull-right" href="'.CHtml::encode(Yii::app()->createAbsoluteUrl('/user/verifyemail/id/'.$model->status_key)).'"> '.CHtml::encode(Yii::app()->createAbsoluteUrl('/user/verifyemail/id/'.$model->status_key)).' </a>';
		$content .= '<br>Regards<br>Admin';
		$this->sendEmailMovie($subject,$content,$model->user_email);
		return true;
	}
	public function sendPassWordResetEmail($user){
		$host = $_SERVER['SERVER_NAME'];
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
		$adminEmail = 'admin@'.$matches[0];
		$url = CHtml::encode(Yii::app()->createAbsoluteUrl('/user/passwordreset/id/'.$user->password_key));
		$steName = Yii::app()->params['site_name'];
		$email = "";
		$email .= '<table align="center" style="font-size:inherit;line-height:inherit;text-align:center;border-spacing:0;border-collapse:collapse;padding:0;border:0" cellpadding="0" cellspacing="0">';
		$email .= '<tr><td style="font-family:Helvetica,Arial,sans-serif;font-weight:300;min-height:16px" height="16"></td></tr><tr><td style="width:685px" width="685">';
		$email .= '<table style="font-family:Helvetica,Arial,sans-serif;font-weight:300;font-size:inherit;line-height:20px;padding:0px;border:0px">';
		$email .= '<tr><td style="font-family:Helvetica,Arial,sans-serif;font-weight:300;line-height:20px;text-align:left;font-size:14px;color:#333">Hey '.$user->user_email.' ,<br>';
		$email .= '<br>You have received this email because a password recovery for the user account with email '.$user->user_email.'. If you did not request this password change, please IGNORE and DELETE this email immediately. Only continue if you wish your password to be reset!<br>';
		$email .= '<br>Simply click on the link below to complete the rest of the Password Reset form: <br>';
		$email .= '<br><a href="'.$url.'" target="_blank">'.$url.'</a><br>';
		$email .= '</td></tr></table></td></tr></table>';
		$this->sendEmailMovie('Password reset request from '.$steName,$email,$user->user_email);
		return true;
	}
//	public function sendEmailMovie($subject,$message,$toEmail){
//		$mail = new Mail();
//		$mail->protocol = 'smtp';
//		$mail->parameter = '';
//		$mail->hostname = 'smtp.mandrillapp.com';
//		$mail->username = 'ramnadh007@gmail.com';
//		$mail->password = 'Esf28ap6BMKInl7zTfpyZA';
//		$mail->port = '587';
//		$mail->timeout = '5';
//		$mail->setTo($toEmail);
//		$mail->setFrom('ramnadh007@gmail.com');
//		$mail->setSender('Codesignmag');
//		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
//		$mail->setHTML($message);
//		$mail->send();
//		return true;
//	}
	public function sendEmailMovie($subject,$message,$toEmail){
		$mail = new Mail();
		$mail->protocol = 'mail';
		$mail->timeout = '5';
		$mail->setTo($toEmail);
		$mail->setFrom('no-replay@cinigo.com');
		$mail->setSender('Cinigo');
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setHTML($message);
		$mail->send();
		return true;
	}
}