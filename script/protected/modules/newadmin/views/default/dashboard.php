<div class="row">
  <div class="col-lg-12">
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success alert-default fade in">
          <button type="button" class="closebtn close">×</button>
          <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
  </div>
</div><!-- /.row -->
<hr>
<div class="row">
    <div class="col-md-12 col-lg-12">
    	<div class="col-md-4 col-lg-4">
    		<div class="panel panel-default">
           	<div class="panel-heading">Articles</div>
           	<div class="panel-body">
            	<a class="btn btn-primary btn-block" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpost')); ?>"> New Post </a>
           	</div>
          	<div class="panel-body">
            	<a class="btn btn-primary btn-block" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/posts')); ?>"> Posts </a>
         	</div>
    		</div>
    	</div>
      <div class="col-md-4 col-lg-4">
    		<div class="panel panel-default">
           	<div class="panel-heading">Categories</div>
           	<div class="panel-body">
            	<a class="btn btn-primary btn-block" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/categorynew')); ?>">New Category </a>
           	</div>
          	<div class="panel-body">
            	<a class="btn btn-primary btn-block" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/category')); ?>">Categories </a>
         	</div>
    		</div>
    	</div>
    </div>
</div>