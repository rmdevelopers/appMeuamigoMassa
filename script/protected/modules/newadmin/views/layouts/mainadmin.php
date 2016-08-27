<!DOCTYPE html>
<html lang="en">
  	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex">
        <title>Admin</title>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <link rel="stylesheet" id="open-sans-css" href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=3.9.1" type="text/css" media="all">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/css/jquery-ui.css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/css/style-responsive.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/js/jquery-ui.js" type="text/javascript"></script>
    	<script src="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
  	</head>
	<body>
	<?php
		$currentAction = Yii::app()->controller->action->id;
	?>
    <section id="container" >
      <header class="header black-bg">
         <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/dashboard')); ?>" class="logo"><b><?php echo Yii::app()->params->site_name; ?></b></a>
            <div class="top-menu">
            <ul class="nav pull-right top-menu">
            	<li><a class="logout" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/logout')); ?>">Logout</a></li>
            </ul>
         </div>
      </header>
     	<aside>
      	<div id="sidebar" class="nav-collapse " tabindex="5000" style="overflow: hidden; outline: none;">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
               <li class="mt">
                	<a <?php if($currentAction == "dashboard") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/dashboard')); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
               </li>
               <li>
               	<a <?php if($currentAction == "users") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/users')); ?>"><i class="fa fa-users"></i> Users</a>
               </li>
               <li>
                   <a <?php if($currentAction == "usernew") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/usernew')); ?>"><i class="fa fa-user"></i> New User </a>
               </li>
            	<li>
               	<a <?php if($currentAction == "posts") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/posts')); ?>"><i class="fa fa-tasks"></i> Posts </a>
             	</li>
           		<li>
               	<a <?php if($currentAction == "newpost") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpost')); ?>"><i class="fa fa-plus"></i> New Post </a>
             	</li>
              	<li>
               	<a <?php if($currentAction == "category") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/category')); ?>"><i class="fa fa-tags"></i> Categories </a>
              	</li>
               <li>
               	<a <?php if($currentAction == "categorynew") echo 'class="active"'; ?> href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/categorynew')); ?>"><i class="fa fa-tag"></i> New Category </a>
              	</li>
        			<li>
                	<a class="" target="_blank" href="<?php echo CHtml::encode(Yii::app()->createUrl('/site/index/')); ?>"><i class="fa fa-search"></i> Visit site </a>
				  	</li>
          	</ul>
          	<!-- sidebar menu end-->
          </div>
      </aside>
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
              	<div class="col-lg-12 main-list-row">
              	<?php echo $content; ?>
                </div>
              </div><!-- --/row ---->
          </section>
      </section>
    </section>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/newadmin/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$('.closebtn').click(function(){
			  $('.alert-success').hide();
			});
			 $('.fa-bars').click(function () {
				if ($('#sidebar > ul').is(":visible") === true) {
					$('#main-content').css({
						'margin-left': '0px'
					});
					$('#sidebar').css({
						'margin-left': '-210px'
					});
					$('#sidebar > ul').hide();
					$("#container").addClass("sidebar-closed");
				} else {
					$('#main-content').css({
						'margin-left': '210px'
					});
					$('#sidebar > ul').show();
					$('#sidebar').css({
						'margin-left': '0'
					});
					$("#container").removeClass("sidebar-closed");
				}
			});
		});
		tinymce.init({
		selector: "#postedit",
		theme: "modern",
		relative_urls: false,
		convert_urls: false,
		remove_script_host : false,
		width: '100%',
		height: 300,
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons paste textcolor"
	   ],
	   content_css: "css/content.css",
	   toolbar: "insertfile undo redo | styleselect | headings | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
	   
	 }); 
	</script>
    <script>
	  $(function() {
		$('#added_dt').datetimepicker({ dateFormat: 'yy-mm-dd' });
	  });
  	</script>

  </script>
  <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
		.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
		.ui-timepicker-div dl { text-align: left; }
		.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
		.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
		.ui-timepicker-div td { font-size: 90%; }
		.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

		.ui-timepicker-rtl{ direction: rtl; }
		.ui-timepicker-rtl dl { text-align: right; }
		.ui-timepicker-rtl dl dd { margin: 0 65px 10px 10px; }
    </style>
  </body>
</html>