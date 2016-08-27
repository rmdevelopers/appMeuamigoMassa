<div class="main-list-row">
<div class="row">
  <div class="col-lg-12">
    <h3>Users <a class="btn btn-primary" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/usernew')); ?>"><i class="fa fa-user"></i> Add New Author </a></h3>
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
      'user_name',
	   'user_email', 
		'user_full_name',
		array(            // display a column with "view", "update" and "delete" buttons
        	'class'=>'CButtonColumn',
			'template'=>'{view}{update}',
			'buttons'=>array
    		(
				'update' => array
				(
    				'label' => '<i class="fa fa-edit"></i>',
               'imageUrl' => false,
    				'url'=>'Yii::app()->createUrl("newadmin/default/usernew", array("id"=>$data->user_id))',
					'options' => array(
						'title'=>'Update'
					)
				),
				'view' => array
				(
    				'label' => '<i class="fa fa-trash-o"></i>',
               'imageUrl' => false,
    				'url'=>'Yii::app()->createUrl("newadmin/default/deleteuser", array("delete_id"=>$data->user_id))',
					'options' => array(
						'title'=>'Delete',
						'class'=>'btn-delete'
						
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
});
/*]]>*/
</script>