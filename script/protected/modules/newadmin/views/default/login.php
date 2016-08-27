<div class="panel-heading">
   <div class="panel-title">
   Sign In
   </div>
</div>
<div style="padding-top:30px" class="panel-body">
<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
</div>
<?php if(Yii::app()->user->hasFlash('success')):?>
  <div class="alert alert-success alert-default fade in">
    <button type="button" class="closebtn close">×</button>
    <?php echo Yii::app()->user->getFlash('success'); ?>
  </div>
<?php endif; ?>
<?php
$form = $this->beginWidget('CActiveForm', array( 'id' => 'loginform', 'htmlOptions'=>array('enctype' => 'multipart/form-data','autocomplete'=>"off",'class'=>'form-horizontal') )); ?>
<?php echo $form->error($model, 'user_name');?>
<div style="margin-bottom: 25px" class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	<?php echo $form->textField($model, 'user_name',array('class'=>'form-control','placeholder'=>'username')); ?> 
</div>

<?php echo $form->error($model, 'user_password');?>
<div style="margin-bottom: 25px" class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	<?php echo $form->passwordField($model, 'user_password',array('class'=>'form-control','placeholder'=>'password')); ?>
</div>

<div style="margin-top:10px" class="form-group">
	<!-- Button -->
	<div class="col-sm-6 controls">
		<?php echo CHtml::submitButton('Login', array('class'=>'btn btn-primary') ) ; ?>
	</div>
    <div class="col-md-6 controls">
    	<a class="btn btn-info pull-right" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/forgotpassword/')); ?>"> Forgot password </a>
    </div>
</div>
<?php $this->endWidget(); ?>