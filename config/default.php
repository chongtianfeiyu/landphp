<?php
return $config = array(
	'moduleFilename' => '',   //控制器的二级后缀名
	//初始路由
	'route' => array(
		'm' => 'home',
		'c' => 'index',
	),
	//mongodb的数据库连接
	'mongo' => array(
		'server' => '',
	),
	//mysql数据库连接
	'mysql' => array(
	),
	//memcache的连接
	'memcache' => array(
	),
);