<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->display_seo(); ?>
<meta property="og:locale" content="en_US">
<meta property="og:site_name" content="<?php echo Yii::app()->params->site_name; ?>">
<?php $urlBase = Yii::app()->request->baseUrl; ?>
<link href="<?php echo $urlBase; ?>/themes/newsapp/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $urlBase; ?>/themes/newsapp/css/style.css" rel="stylesheet">
<link rel="Shortcut Icon" href="<?php echo $urlBase; ?>/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
<div class="container">
<div class="navbar-header">
<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<?php echo CHtml::link('Home',array('/site/index/'),array('class'=>'navbar-brand','title'=>'Home')); ?>
</div>
<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
<ul class="nav navbar-nav">
<li>
<?php echo CHtml::link('Top News',array('/category/top-news/'),array('title'=>'Top News')); ?>
</li>
<li>
<?php echo CHtml::link('Sports',array('/category/sports/'),array('title'=>'Sports')); ?>
</li>
<li>
<?php echo CHtml::link('Entertainment',array('/category/entertainment/'),array('title'=>'Entertainment')); ?>
</li>
</ul>
<form method="get" action="<?php echo Yii::app()->createAbsoluteUrl('/site/search') ?>" class="navbar-form navbar-left pull-right" role="search">
  <div class="form-group">
    <input name="s" type="text" class="form-control" placeholder="Search">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</nav>
</div>
</header>
<div id="header-wrapper" class="container">
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 head-col">
<div class="titlewrapper">
<?php if( 'site' == $this->currentContrFeed  && 'index' == $this->currentActionFeed ) { ?>
<h1 class="h-title">
<a href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/site/index')); ?>" title="<?php echo Yii::app()->params->site_name; ?>"><?php echo Yii::app()->params->site_name; ?></a>
</h1>
<?php } else { ?>
<div class="h-title">
<a href="<?php echo CHtml::encode(Yii::app()->createAbsoluteUrl('/site/index')); ?>" title="<?php echo Yii::app()->params->site_name; ?>"><?php echo Yii::app()->params->site_name; ?></a>
</div>
<?php } ?>
</div>
</div>
<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 header-advertisement" id="top-ad">
</div>
</div>