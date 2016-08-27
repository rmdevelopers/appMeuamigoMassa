<div class="entry row">
   <div class="post-content">
   	<?php if($post->image) { ?>
      <div class="col-lg-4 col-md-4">
         <a class="thumbnail ajax_link" title="<?php echo CHtml::encode($post->title); ?>" href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug)); ?>">
             <img  class="clearfix img-responsive" alt="<?php echo CHtml::encode($post->title); ?>" title="<?php echo CHtml::encode($post->title); ?>" src="<?php echo CHtml::encode( Yii::app()->params->static_path.$post->image); ?>"/>
         </a>
      </div>
      <div class="col-lg-8 col-md-8">
         <div class="content-row caption">
             <h2 class="post-title-h2"><a href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug)); ?>" title="<?php echo $post->title; ?>"><?php echo $post->title; ?></a></h2>
         </div>
         <div>
             <?php echo substr(strip_tags($post->description),"0","200").'...'; ?>
         </div>
      </div>
      <?php } else { ?>
      <div class="col-lg-12 col-md-12">
         <div class="content-row caption">
             <a href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug)); ?>"><?php echo $post->title; ?></a>
         </div>
         <div>
             <?php echo substr(strip_tags($post->description),"0","200").'...'; ?>
         </div>
      </div>
   	<?php } ?>
   	<div class="col-lg-12 col-md-12">
        	<div class="post-meta-home">
            <span class="pull-left">
                <span class="date-meta meta-elements">
                    <?php if( $post->created_dt ) echo date("F jS Y", strtotime($post->created_dt)); ?>
                </span>
                <?php if( $post->Cat ) : ?>
                  <span class="tag-meta meta-elements">
                      <a class="btn btn-success" href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/category/'.$post->Cat->slug)); ?>"><?php echo $post->Cat->title;  ?></a>
                  </span>
               <?php endif; ?>
            </span>
            <span class="pull-right">
                <a class="btn btn-primary" href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug)); ?>">Read More</a>
            </span>
        </div>
    	</div>
   </div>
</div>