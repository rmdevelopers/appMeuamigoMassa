<?php
require(dirname(__FILE__).'/config.php');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'News App',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.api.*',
		'application.forms.*',
	),
	'modules'=>array(
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
		'newadmin',
		'api',
	),
	'defaultController'=>'site',

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'db'=>array(
			'connectionString' => 'mysql:host='.mysql_host.';dbname='.db_name,
			'emulatePrepare' => true,
			'username' => db_user,
			'password' => db_password,
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix' => '/',
			'rules'=>array(
				'/page/<page:\d+>/*'=>'site/index',
				'/'=>'site/index',
				'/news/<id:\d+>/<slug:[\w\-.]+>/*'=>'/site/post',
				'/category/<category:[\w\-.]+>/*'=>'/site/category',
				'/search/*'=>'/site/search',
				'/search-form/'=>'/site/searchform',
				
			),
		),
		'cache' => array (
           'class' => 'system.caching.CFileCache',
       ),
	),
	'params'=>require(dirname(__FILE__).'/params.php'),
);