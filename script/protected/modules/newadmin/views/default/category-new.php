<div class="row">
	<div class="col-lg-12">
	<h3>New/Update Category</h3>
	<?php if(Yii::app()->user->hasFlash('success')):?>
      <div class="alert alert-success alert-default fade in">
         <button type="button" class="closebtn close">×</button>
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div>
   <?php endif; ?>
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
  <label class="col-lg-3 col-md-4 control-label" for="title">Title *</label>  
  <div class="col-lg-7 col-md-4">
 	<?php echo $form->textField($model, 'title',array('class'=>'form-control input-md','placeholder'=>'Title')); ?> 
	<?php echo $form->error($model, 'title');?> 
  </div>
</div>
<div class="form-group">
<label class="col-lg-3  col-md-4 control-label" for="link">Link(Automatic) *</label>  
  <div class="col-lg-7 col-md-4">
 	<?php echo $form->textField($model, 'slug',array('class'=>'form-control input-md','placeholder'=>'Link')); ?> 
	<?php echo $form->error($model, 'slug');?> 
  </div>
</div>
<div class="form-group">
<label class="col-lg-3  col-md-4 control-label" for="link">Category Icon(Recomended size 100x100px)</label>  
  <div class="col-lg-7 col-md-4">
 	<?php echo $form->fileField($model, 'image',array('class'=>'form-control')); ?>
	<?php echo $form->error($model, 'image');?> 
  <br>
  <?php if(isset($termDetails->image) && $termDetails->image != '') { ?>
 		<div class="panel-body">
         <img class="img-responsive" src="<?php echo Yii::app()->params->static_path.$termDetails->image ?>" />
         <a class="btn btn-info" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/categorynew/delete_image/'.$termDetails->cat_id)); ?>"> Delete Image </a>
  		</div>
	<?php }?>
  </div>
  
</div>
<div class="form-group">
<label class="col-lg-3 col-md-4 control-label" for="username"></label> 
  <div class="col-lg-7 col-md-4">
   <?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary btn-large')); ?>
  </div>
</div>
</fieldset>
 <?php $this->endWidget(); ?>
 </div>
</div>