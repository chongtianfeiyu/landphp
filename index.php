<?php
/**
* landphp的入口文件
* @author 彭城岛主
*/
define('LAND_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include LAND_PATH.'common.php';

common::application();

