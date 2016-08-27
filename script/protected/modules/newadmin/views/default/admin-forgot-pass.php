<div class="panel-heading">
    <div class="panel-title">
        Password reset
    </div>
</div>
<div style="padding-top:30px" class="panel-body">
    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
    </div>
    <?php if(isset($success)) { ?>
    	Password reset email sent successfully
    <?php } else { ?>
<?php
$form = $this->beginWidget('CActiveForm', array( 'id' => 'forgotpass', 'htmlOptions'=>array('enctype' => 'multipart/form-data','autocomplete'=>"off",'class'=>'form-horizontal') )); ?>
<?php echo $form->error($model, 'user_email');?>
<div style="margin-bottom: 25px" class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	<?php echo $form->textField($model, 'user_email',array('class'=>'form-control','placeholder'=>'email')); ?> 
</div>
<div style="margin-top:10px" class="form-group">
	<!-- Button -->
	<div class="col-sm-12 controls">
		<?php echo CHtml::submitButton('reset', array('class'=>'btn btn-primary') ) ; ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php } ?>