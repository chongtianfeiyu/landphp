<?php
/**
* 全站的统一的入口文件,方便其他的文件调用
*/
class common {
	//下面是一些不能被继承的属性
	public static $class;
	public static $config;
	/*
	* 初始化应用程序
	* 加载配置文件
	* 导出类
	*/
	public function application() {
		self::load('default',LAND_PATH.'config/');
		$this->config = $config;
		self::route();
	}
	/**
	* 自动加载类库
	*/
	public function autoload() {
		if(is_array($class)) {
			foreach ($class as $key => $value) {
				if(file_exists($value)) {
					require_once $value;
				} else {
					$this->log();
				}
			}
		} else {
			if(file_exists($class)) {
				require_once $class;
			} else {
				$this->log();
			}
		}


	}

	/**
	* 加载文件
	* @param $classname   文件名
	* @param $path        文件路径
	*/
	public function load($classname,$path='') {
		if(empty($path)) {
			$file = 'libs/'.$classname.'.class.php';
		} else {
			$file = $path.$classname.'.php';
		}
		//判断文件是否存在
		if(file_exists(LAND_PATH.$file)) {
			require_once LAND_PATH.$file;
		} else {
			$this->log();
		}

	}

	/**
	* 简单的路由
	* 暂时只支持一种规则
	*/
	public function route() {
		$module = isset($_GET['m'])?$_GET['m']:$this->$config['route']['m'];
		$action = isset($_GET['c'])?$_GET['c']:$this->$config['route']['c'];
		//加载不同的路由，
		if(!empty($this->config['moduleFilename'])) {
			$path = LAND_PATH.'modules/'.$module.$this->config['moduleFilename'].'.php';
		} else {
			$path = LAND_PATH.'modules/'.$module.'.php';
		}
		if(file_exists($path)) {
			require_once $path;
		} else {
			$this->log();
		}
	}

	/**
	* 错误日志
	*/
	public function log() {
		
	}
}