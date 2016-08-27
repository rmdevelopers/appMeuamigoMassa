<?php 
	$postUrl = Yii::app()->params->site_url.'/news/'.$post->id.'/'.$post->slug.'/';
	$postUrlEncode = urlencode($postUrl);
	$shareTitle = urlencode($post->title); 
?>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main-post-col">
		<div class="post-p-heading">
        	<h1 class="main-heading-post"><?php echo CHtml::encode($post->title); ?></h1>
			<div class="clearfix"></div>
        </div>
        <div class="post-meta-post">
        			<span class="pull-left">
                  	<?php if( $post->Cat ) : ?>
                    	<span>
                      	<a  class="btn btn-info btn-sm" href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/category/'.$post->Cat->slug)); ?>"><?php echo $post->Cat->title;  ?></a>
                     </span>
                   	<?php endif; ?>
                  </span>
              	</div>
               <div class="page-post">
               	<img  class="clearfix img-responsive" alt="<?php echo CHtml::encode($post->title); ?>" title="<?php echo CHtml::encode($post->title); ?>" src="<?php echo CHtml::encode( Yii::app()->params->static_path.$post->image); ?>"/>
               </div>
					<?php if($post->description) : ?>
                   <div class="page-post page-description">
                      <?php echo $post->description; ?>
                   </div>
               <?php endif ; ?>
               <?php if( $post->source ) : ?>
               <hr>
               <span>
                  <a  class="btn btn-info btn-sm" href="<?php echo CHtml::encode($post->source); ?>"><?php echo $post->source_title;  ?></a>
               </span>
               <hr>
               <?php endif; ?>
        	</div>
            
      	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        	<?php $this->renderPartial('/layouts/listsidebar'); ?>
    	</div>
	</div>
<?php 
	$this->pageOgType = "article";
	$this->pageOgTitle = $post->title;
	if($post->image) {
		$this->pageOgImage = CHtml::encode(Yii::app()->params->static_path.$post->image);
	}
	$this->pageTitle = $post->title;	
	$this->pageDesc = substr(strip_tags($post->description),"0","150");
	$this->pageOgDesc = $this->pageDesc;
	$this->pageCanonial = CHtml::encode(Yii::app()->createAbsoluteUrl('/news/'.$post->id.'/'.$post->slug));
	
?>