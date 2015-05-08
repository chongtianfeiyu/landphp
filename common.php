<?php
/**
* 全站的统一的入口文件,方便其他的文件调用
*/
define('IN_LAND', true);
class common {
	/*
	* 初始化应用程序
	* 加载配置文件
	* 导出类
	*/
	public static function application() {
		//加载配置文件
		$GLOBALS['config'] = common::load_config();
		//使用smarty模板引擎
		include_once(LAND_PATH.'libs/smarty/Smarty.class.php');
		$smarty = new Smarty();
		$smarty->template_dir = ""; //指定模板文件的路径
		$smarty->compile_dir = ""; //指定编译的文件路径
		$smarty->cache_dir = ""; //指定缓存文件路径
		$smarty->config_dir =""; //指定smarty配置文件路径
		$smarty->left_delimiter="{{"; //指定左定界符
		$smarty->right_delimiter="}}";  //提供右定界符
		//处理参数
		self::route();
	}

	/*
	* 加载配置文件
	*/
	public static function load_config($filename = 'default') {
		$path = LAND_PATH.'config'.DIRECTORY_SEPARATOR.$filename.'.php';
		if(file_exists($path)) {
			include $path;
		}
		return $config;
	}

	/*
	* 加载类库文件
	*/
	public static function load_class($filename) {
		$path = LAND_PATH.'libs'.DIRECTORY_SEPARATOR.$filename.'.class.php';
		if(file_exists($filename)) {
			include $path;
		}
	}

	/*
	* 加载控制器
	*/
	public static function load_controller($filename) {
		$path = LAND_PATH.'modules'.DIRECTORY_SEPARATOR.$filename.'.php';
		if(file_exists($path)) {
			include $path;
		} else {
			
		}
	}

	/**
	* 加载模型文件
	*/
	public static function load_model($filename) {
		$path = LAND_PATH.'models'.DIRECTORY_SEPARATOR.$filename.'.php';
		if(file_exists($filename)) {
			include $path;
		}
	}

	/**
	* 加载视图文件
	* @param  module   文件夹名称
	* @param  action   视图文件名
	*/
	public static function render($module,$action) {
		$path = LAND_PATH.'views'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$action.'.php';
		if(file_exists($path)) {
			include $path;
		}
	}

	/**
	* 自动加载类库
	*/
	public function autoload() {
		$classes = array();
		if(!empty($classes)) {
			foreach ($classes as $key => $value) {
				if(file_exists($value)) {
					include $value;
				}
			}
		}
	}

	/**
	* 简单的路由
	* 暂时只支持一种规则
	*/
	public static function route() {
		$module = isset($_GET['m'])?$_GET['m']:$GLOBALS['config']['m'];
		$action = isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['c'];
		//加载不同的路由，
		self::load_controller($module);
		$controller = new $module;
		$controller->$action();
	}

	/**
	* 错误日志
	*/
	public static function log() {
		
	}

}