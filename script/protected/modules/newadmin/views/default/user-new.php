<div class="row">
  <div class="col-lg-12">
    <h3>New Author</h3>
  </div>
</div><!-- /.row -->
<div class="row">
<div class="col-lg-12">
<?php
$form = $this->beginWidget('CActiveForm', array(
   'id' => 'registration-form',
   'htmlOptions'=>array('enctype' => 'multipart/form-data','autocomplete'=>"off",'class'=>'form-horizontal')
  ));
?>
<hr />
<fieldset>
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email <span class="errorMessage">*</span></label>  
  <div class="col-md-4">
 	<?php echo $form->textField($model, 'user_email',array('class'=>'form-control input-md','placeholder'=>'Email')); ?> 
	<?php echo $form->error($model, 'user_email');?> 
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="username">Username <span class="errorMessage">*</span></label>  
  <div class="col-md-4">
   <?php echo $form->textField($model, 'user_name',array('class'=>'form-control input-md','placeholder'=>'Username')); ?> 
	<?php echo $form->error($model, 'user_name');?>  
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password <span class="errorMessage">*</span><?php if($user_id) {echo "( Create new password )";} ?> </label>
  <div class="col-md-4">
    <?php echo $form->passwordField($model, 'user_password',array('class'=>'form-control input-md','placeholder'=>'Password')); ?> 
	<?php echo $form->error($model, 'user_password');?>
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
   <?php echo $form->textField($model, 'user_full_name',array('class'=>'form-control input-md','placeholder'=>'Name')); ?> 
	<?php echo $form->error($model, 'user_full_name');?>  
  </div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" for="username"></label> 
  <div class="col-md-4">
   <?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary btn-large')); ?>
  </div>
</div>
</fieldset>
<?php $this->endWidget(); ?>
</div>
</div>