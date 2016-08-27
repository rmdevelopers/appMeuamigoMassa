<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">
    <title><?php echo $this->get_option['site_name']; ?> Admin</title>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <link rel="stylesheet" id="open-sans-css" href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=3.9.1" type="text/css" media="all">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/css/jquery.tagsinput.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/js/jquery-ui.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/js/jquery.tagsinput.min.js"></script>
    <script>
	  $(function() {
		$('#created_dt').datetimepicker({ dateFormat: 'yy-mm-dd' });
	  });
  	</script>
  </head>

  <body>

    <div id="wrapper">
<?php
$currentAction = Yii::app()->controller->action->id;
?>
      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/dashboard')); ?>"><?php echo $this->get_option['site_name']; ?> ADMIN</a>
        </div>
        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Yii::app()->user->admin_username; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/settingsgeneral')); ?>"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/logout')); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        <div class="sidebar-nav">
        <a class="nav-header" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/dashboard')); ?>"><i class="fa fa-bars"></i> Dashboard</a>
        <a href="#user-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-users"></i> Admins <b class="caret"></b></a>
        <ul id="user-menu" class="nav nav-list collapse <?php if($currentAction == "users" || $currentAction == "usernew") echo 'in'; ?>">
            <li <?php if($currentAction == "users") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/users')); ?>"><i class="fa fa-users"></i> Admins</a></li>
            <li <?php if($currentAction == "usernew") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/usernew')); ?>"><i class="fa fa-user"></i> Add new admin</a></li>
        </ul>
		<a href="#Category-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-tags"></i> Category <b class="caret"></b></a>
        <ul id="Category-menu" class="nav nav-list collapse <?php if($currentAction == "categories" || $currentAction == "newcategory") echo 'in'; ?>">
            <li <?php if($currentAction == "categories") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/categories')); ?>"><i class="fa fa-tags"></i> Categories</a></li>
           	<li <?php if($currentAction == "newcategory") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newcategory')); ?>"><i class="fa fa-plus"></i> Add new category</a></li>
        </ul>
        <a href="#Posts-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-tasks"></i> Posts <b class="caret"></b></a>
        <ul id="Posts-menu" class="nav nav-list collapse <?php if($currentAction == "posts" || $currentAction == "newpost") echo 'in'; ?>">
            <li <?php if($currentAction == "posts") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/posts')); ?>"><i class="fa fa-tasks"></i> Posts</a></li>
           	<li <?php if($currentAction == "newpost") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpost')); ?>"><i class="fa fa-plus"></i> Add new post</a></li>
        </ul>
        <a href="#Media-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-camera"></i> Media <b class="caret text-right"></b></a>
        <ul id="Media-menu" class="nav nav-list collapse <?php if($currentAction == "medias" || $currentAction == "newmedia") echo 'in'; ?>">
            <li <?php if($currentAction == "medias") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/medias')); ?>"><i class="fa fa-camera"></i> Media </a></li>
            <li <?php if($currentAction == "newmedia") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newmedia')); ?>"><i class="fa fa-plus"></i> Add new media</a></li>
        </ul>
        <a href="#Pages-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-file"></i> Pages <b class="caret"></b></a>
        <ul id="Pages-menu" class="nav nav-list collapse <?php if($currentAction == "pages" || $currentAction == "newpage") echo 'in'; ?>">
           	<li <?php if($currentAction == "pages") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/pages')); ?>"><i class="fa fa-file"></i> pages</a></li>
           	<li <?php if($currentAction == "newpage") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/newpage')); ?>"><i class="fa fa-plus"></i> Add new page</a></li>
        </ul>
        <a href="#Settings-menu" class="nav-header" data-toggle="collapse"><i class="fa fa-gears"></i> Settings <b class="caret"></b></a>
        <ul id="Settings-menu" class="nav nav-list collapse <?php if($currentAction == "settingstitles" || $currentAction == "settingsgeneral" || $currentAction == "settingsposts" || $currentAction == "sitemapsettings" || $currentAction == "headerlogo") echo 'in'; ?>">
           	<li <?php if($currentAction == "settingsgeneral") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/settingsgeneral')); ?>"><i class="fa fa-gear"></i> General settings </a></li>
            <li <?php if($currentAction == "settingstitles") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/settingstitles')); ?>"><i class="fa fa-th-list"></i> Titles and meta </a></li>
            <li <?php if($currentAction == "settingsposts") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/settingsposts')); ?>"><i class="fa fa-list-alt"></i> Posts, Pages etc </a></li>
            <li <?php if($currentAction == "sitemapsettings") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/sitemapsettings')); ?>"><i class="fa fa-bookmark"></i> Sitemap </a></li>
            <li <?php if($currentAction == "headerlogo") echo 'class="active"'; ?>><a href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/headerlogo')); ?>"><i class="fa fa-camera"></i> Logo </a></li>
        </ul>
        <a class="nav-header <?php if($currentAction == "sitemenu") echo 'active'; ?>" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/sitemenu')); ?>"><i class="fa fa-bookmark"></i> Menu </a>
        <a class="nav-header <?php if($currentAction == "widgetads") echo 'active'; ?>" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/widgetads')); ?>"><i class="fa fa-money"></i> Advertisements </a>
        <a class="nav-header <?php if($currentAction == "sidebarwidgets") echo 'active'; ?>" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/sidebarwidgets')); ?>"><i class="fa fa-folder"></i> Sidebar widgets </a>
        <a class="nav-header <?php if($currentAction == "deletecache") echo 'active'; ?>" href="<?php echo CHtml::encode(Yii::app()->createUrl('/newadmin/default/deletecache')); ?>"><i class="fa fa-warning"></i> Delete options cache </a>
    	<a class="nav-header" target="_blank" href="<?php echo CHtml::encode(Yii::app()->createUrl('/site/index/')); ?>"><i class="fa fa-search"></i> Visit site </a>
    </div>
      </nav>

      <div id="page-wrapper">
		<?php echo $content; ?>
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/js/bootstrap.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/media/admin/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
		tinymce.init({
		selector: "#tagedit",
		theme: "modern",
		relative_urls: false,
		convert_urls: false,
		remove_script_host : false,
		width: 650,
		height: 300,
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons paste textcolor"
	   ],
	   content_css: "css/content.css",
	   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage", 
	   style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]
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
	   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage", 
	   style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]
	 });  
	</script>
    <script type="text/javascript">
		$(document).ready(function(){
			$('.closebtn').click(function(){
			  $('.alert-success').hide();
			});
		});
	</script>
  </body>
</html>