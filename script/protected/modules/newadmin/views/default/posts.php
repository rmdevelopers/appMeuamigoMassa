<div class="main-list-row">
<div class="row">
  <div class="col-lg-12">
    <h3>Posts <a class="btn btn-primary" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpost')); ?>"><i class="fa fa-tag"></i> New Post </a></h3>
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success alert-default fade in">
          <button type="button" class="closebtn close">×</button>
          <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
	<?php endif; ?>
  </div>
</div><!-- /.row -->
<?php  
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
	'filter' => $model,
	'pagerCssClass'=>'pagination-bottom',
	'summaryText' => '',
	'pager'=>array(
		'header'=>'',
		'selectedPageCssClass'=>'active',
		'hiddenPageCssClass'=>'active',
		'prevPageLabel' => '<',
		'nextPageLabel' => '>',
		'firstPageLabel'=>'<<',
		'lastPageLabel'=>'>>',
		'htmlOptions'=>array(
			'class'=>'pagination',
		),
	),
	'columns'=>array(
		'id',
	  	'title',
		'status', 
		'updated_dt',  
        array(            // display a column with "view", "update" and "delete" buttons
         'class'=>'CButtonColumn',
			'template'=>'{view}{update}{push}',
			'buttons'=>array
    		(
				'update' => array
				(
    				'label' => '<i class="fa fa-edit"></i>',
              	'imageUrl' => false,
    				'url'=>'Yii::app()->createUrl("newadmin/default/newpost", array("id"=>$data->id))',
					'options' => array(
						'title'=>'Update'
					)
				),
				'view' => array
				(
    				'label' => '<i class="fa fa-trash-o"></i>',
              	'imageUrl' => false,
    				'url'=>'Yii::app()->createUrl("newadmin/default/deletepost", array("delete_id"=>$data->id))',
					'options' => array(
						'title'=>'Delete',
						'class'=>'btn-delete'
						
					)
				),
				'push' => array
				(
    				'label' => '<i class="fa fa-paper-plane"></i>Push',
              	'imageUrl' => false,
    				'url'=>'Yii::app()->createUrl("newadmin/default/sendpush", array("id"=>$data->id))',
					'options' => array(
						'title'=>'Send push notification',
						'class'=>'btn-push'
						
					)
				)
      		)  
	  
	  ),
		
		),
)); ?>
</div>
<script>

/*<![CDATA[*/
jQuery(function($) {
	jQuery(document).on('click','#yw0 a.btn-delete',function() {
		if(!confirm('Are you sure you want to delete this item?')) return false;
	});
	jQuery(document).on('click','#yw0 a.btn-push',function() {
		if(!confirm('Are you sure you want to send push notifications?')) return false;
	});
});
/*]]>*/
</script>