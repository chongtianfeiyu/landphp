<?php
/**
* landphp的入口文件
* @author 彭城岛主
*/
define('landphp',true);
define('LAND_PATH', dirname(__FILE__).'/');

require_once './common.php';

common::application();

