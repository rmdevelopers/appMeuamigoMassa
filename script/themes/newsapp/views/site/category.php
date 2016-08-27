<div class="row main-index">
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main-post-col">
	<div class="thumbnails">
		<?php $this->renderPartial('/site/post-posts',array('posts'=>$posts,'typepage'=>'category')); ?>
	</div>
</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<?php $this->renderPartial('/layouts/listsidebar'); ?>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
		<?php if($pages!=""){?>
        <?php $this->widget('CLinkPager', array('pages' => $pages,
                                    'header'=>'',
									'firstPageCssClass'=>'test',
									'cssFile'=>FALSE,
                                    'selectedPageCssClass'=>'active',
									'hiddenPageCssClass'=>'active',
									'prevPageLabel' => 'prev',
        							'nextPageLabel' => 'next',
        							'firstPageLabel'=>'first',
        							'lastPageLabel'=>'last',
									'htmlOptions'=>array(
										'class'=>'pagination',
									),
             	)) ?>
       
        <?php }?>
	</div>
</div>
<?php
	if($pageval!="1"){
		$this->pageTitle = $catDetails->title.' - page '.$pageval;		
		$this->pageOgTitle = $this->pageTitle;	
		$this->pageRobotsIndex = 'false';
		$this->pageCanonial = Yii::app()->params->site_url.'/category/'.$catDetails->slug.'/page/'.$pageval.'/';
	} else {
		$this->pageTitle = $catDetails->title;		
		$this->pageOgTitle = $this->pageTitle;	
		$this->pageCanonial = Yii::app()->params->site_url.'/category/'.$catDetails->slug.'/';
	}
?>
	