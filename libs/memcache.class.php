<?php
/**
* memcache 操作类
* 原理阐述：通过php的扩展,封装memcache的操作
* php.ini中memcache的配置：
* bool memcache.allow_failover 是否在发生错误时，透明的转移到其他服务器
* int  memcache.max_failover_attempts 故障转移的最大尝试数
* int  memcache.chunk_size 数据传输块的大小，值越小I/O越多，如果发现速度莫名降低，尝试将此值调成32768
* string memcache.default_port TCP端口号，如果没有就使用默认的11211
* string memcache.hash_strategy 控制key到服务器的映射策略(分布式) consistend 允许服务器增减而不会导致键的重新映射，standard则使用余数方式进行key的映射
* string memcache.hash_function 控制映射使用哪个hash函数，crc32，fnv
* string session.save_handler   值为memcache标记使用memcache作为session处理器
* string session.save_path      session存储的服务器url列表，类似于addServer()   tcp://host1:11211, tcp://host2:11211
*/
class memcache {
	private $memcache;
	private $common_key; //定义一个key的开头
	private $server;     //memcache服务器
	public function __construct() {
		$this->memcache = new Memcache();
		foreach ($this->server as $key => $value) {
			$this->memcache->addServer($value['host'],$value['port']);
			$this->memcache->connect($value['host'],$value['port']);
		}
		$this->memcache->connect();
	}

	//set值
	public function set($key,$value,$expire=0) {
		$key = $this->common_key."_".substr(md5($key), 8, 16);
		$this->memcache->set($key,$value,$expire);
	}

	//get值
	public function get($key) {
		$key = $this->common_key."_".substr(md5($key), 8,16);
		$this->memcache->get($key);
	}

	//replace值
	public function replace($key,$value,$expire) {
		$key = $this->common_key."_".substr(md5($key), 8, 16);
		$this->memcache->replace($key,$value,$expire);
	}

	//delete值
	public function delete($key) {
		$key = $this->common_key."_".substr(md5($key), 8, 16);
		$this->memcache->delete($key);
	}

	//flush值
	public function flush() {
		$this->memcache->flush();
	}
}