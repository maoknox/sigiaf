<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$pathInfo=pathinfo($_SERVER['PHP_SELF']);
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
Yii::setPathOfAlias('booster', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../extensions/yiibooster-4.0.1');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'language'=>'es',
	'name'=>'Centro Forjar',
	'defaultController'=>'site',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'root',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		 'modIdenReg',
		 'valoracionIntegral',
		 'referenciacion',
		 'pai',
		 'psc',
		 'seguimientoAdol',
		 'asistencia',
		 'planpostegreso',
		 'administracion',
		 'gestionSeguimSJ',
	),

	// application components
	'components'=>array(
		'booster' => array(
            'class' => 'booster.components.Booster',
        ),
		'mail' => array(
			'class' => 'application.extensions.yii-mail-master.YiiMail',
			'transportType'=>'smtp',
			'transportOptions'=>array(
				'host'=>'smtp.mail.yahoo.com',
				'username'=>'hingato',
				'password'=>'$&E m35e',
				'port'=>'587',
				//'encryption'=>'openssl',
			),
				'viewPath' => 'application.views.mail',
				'logging' => true,
				'dryRun' => false
			),
			'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'input'=>array(   
            'class'         => 'CmsInput',  
            'cleanPost'     => true,  
            'cleanGet'      => true,   
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix'=>'.camar',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>/*'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
 	       'tablePrefix'=>'',
 	       'connectionString' => 'pgsql:host=localhost;port=5432;dbname=cforjarv2_4',
 	       'username'=>'postgres',
 	       'password'=>'root',
 	       'charset'=>'UTF8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'/site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page Yii::app()->params[$name])
		'adminEmail'=>'hingato@yahoo.com.ar',
		'webRoot' => dir(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'),
		'verArchivos'=>$protocol.$_SERVER['SERVER_NAME'].$pathInfo["dirname"]."/pdf/",
		'subirArchivos'=>$_SERVER['DOCUMENT_ROOT'].$pathInfo["dirname"]."/pdf/",
		'hash_key'=>'$%||45',
		'num_caracteres'=>15,
		'tiempo_verifder'=>5, //5 dias Yii::app()->params["tiempo_verifder"])
		'tiempo_planpg'=>15//15 dias
	),
);