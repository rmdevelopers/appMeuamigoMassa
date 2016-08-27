<div class="row">
  <div class="col-lg-12">
    <h3>New post</h3>
  </div>
</div><!-- /.row -->
<hr />
<?php
$form = $this->beginWidget('CActiveForm', array(
   'id' => 'post-form',
   'htmlOptions'=>array('enctype' => 'multipart/form-data','autocomplete'=>"off",'class'=>'form-horizontal')
  ));
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="col-md-8 col-lg-8">
            <div class="form-group">
              <div class="col-md-12 col-lg-12">
                <?php echo $form->textField($model, 'title',array('class'=>'form-control','placeholder'=>'Heading *')); ?> 
                <?php echo $form->error($model, 'title');?> 
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-lg-12">
                <?php echo $form->textField($model, 'slug',array('class'=>'form-control','placeholder'=>'Permalink *','id'=>'slug')); ?> 
                <?php echo $form->error($model, 'slug');?>
                <a style="margin-top:10px;" href="javascript:void(0);" id="geturl" class="help btn btn-xs btn-default">create permalink</a> 
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-lg-12">
                <?php echo $form->textArea($model, 'description',array('id'=>'postedit')); ?> 
                <?php echo $form->error($model, 'description');?> 
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-lg-12">
                <?php echo $form->textField($model, 'source',array('class'=>'form-control','placeholder'=>'Source eg :http://wwww.google.com/news/')); ?> 
                <?php echo $form->error($model, 'source');?> 
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-lg-12">
                <?php echo $form->textField($model, 'source_title',array('class'=>'form-control','placeholder'=>'Source name eg:CNN')); ?> 
                <?php echo $form->error($model, 'source_title');?> 
              </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
          	<div class="form-group">
              <label class="col-md-4 col-lg-4 control-label" for="created_dt">Added date</label>
              <div class="col-md-8 col-lg-8">
                  <?php echo $form->textField($model, 'created_dt',array('class'=>'form-control','placeholder'=>'Date','id'=>'added_dt')); ?> 
                  <?php echo $form->error($model, 'created_dt');?> 
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-4 control-label" for="cat_id">Category</label>  
              <div class="col-md-8 col-lg-8">
               <?php echo $form->dropDownList($model, 'cat_id',$categories,array('class'=>'form-control input-md')
            ); ?>
                <?php echo $form->error($model, 'cat_id');?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-4 control-label" for="is_active">Status</label>  
              <div class="col-md-8 col-lg-8">
               <?php echo $form->dropDownList($model, 'status',
                array('draft'=>'Draft','published' => 'Published'),array('class'=>'form-control input-md')
            ); ?>
                <?php echo $form->error($model, 'status');?>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">Featured image</div>
              <div class="panel-body">
                  <?php echo $form->fileField($model, 'image',array('class'=>'form-control')); ?>
              </div>
              <?php if(isset($postDetails->image) && $postDetails->image != '') { ?>
             <div class="panel-body">
                  <img class="img-responsive" src="<?php echo Yii::app()->params->static_path.$postDetails->image ?>" />
                  <a class="btn btn-info" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpost/delete_image/'.$postDetails->id)); ?>"> Delete Image </a>
              </div>
            <?php }?>
            </div>
            
            <div class="form-group">
            	<div class="col-md-12 col-lg-12">
               		<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary btn-block')); ?>
               </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script>
$( document ).ready(function() {
    $('#geturl').click(function(){
		$.post( currentUrl+"ajaxurlcreate/", $( "#post-form" ).serialize())
	  	.done(function( data ) {
			datare = $.parseJSON(data);
			if(datare.status == 'success'){
				$('#slug').val(datare.url);
			} else {
				alert('Please enter title or permalink');
			}
	  });
	})
	
});
</script>