<?php
/**
* 验证码类库
* 原理阐述：(1)php的GD库画图并填充文字
* 			(2)将验证码存放起来，session或者memcache等等
*			(3)完成验证码的比较
*/
class captcha {
	private $code;   //验证码
	private $codelength=4; //验证码的长度
	private $width = 300; //图片的宽度
	private $height = 100; //图片的高度
	private $imgage; //图片
	private $font; //指定的字体
	private $fontsize; //字体的大小
	private $fontcolor; //字体的颜色
	private $cache = 'session'; //存储类型，默认是session

	//验证码初始化方法
	public function __construct($width=200,$height=100,$codelength=4) {
		$this->width = $width;
		$this->height = $height;
		$this->codelength = $codelength;
		$this->font = LAND_PATH.'/config/font/elephant.ttf';
	}

	//生成随机验证码
	private function createCode() {
		$str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";
		for($i=0;$i<$this->codelength;$i++) {
			$this->code .= $str{mt_rand(0,strlen($str)-1)};
		}
	}

	//存储验证码
	private function saveCode() {
		if($this->cache == 'session') { //使用session存储
			if(isset($_SESSION['']))
				$_SESSION['code'] = $this->code;
		} elseif($this->cache == 'memcache') {
			$memcache = new Memcache();
		} 
	}

	//生成背景
	private function createBackground() {
		$this->image = imagecreatetruecolor($this->width, $this->height);
		$color = imagecolorallocate($this->image, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
		imagefilledrectangle($this->image, 0, $this->height, $this->width, 0, $color);
	}

	//生成字符在图像中
	private function imageText() {
		//$this->fontcolor = imagecolorallocate($this->image, mt_rand(150,255), mt_rand(150,255), mt_rand(150,255));
		for($i=0;$i<$this->codelength;$i++) {
			//对每个进行处理
			$this->fontsize = mt_rand(floor($this->height / 5),floor($this->height / 3));
			$x = floor($this->width/$this->codelength)*$i+10;
			$y = mt_rand(30,$this->height-20);
			imagettftext($this->image, $this->fontsize, mt_rand(-30,30), $x, $y, $this->fontcolor, $this->font, $this->code[$i]);
		}
	}

	//生成干扰元素
	private function createLine() {
		$this->fontcolor = imagecolorallocate($this->image, mt_rand(150,255), mt_rand(150,255), mt_rand(150,255));
		//画干扰线
		for($i=0;$i<3;$i++) {
			imageline($this->image, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $this->fontcolor);
		}
		//画点
		for($i=0;$i<50;$i++) {
			imagesetpixel($this->image, mt_rand(1,$this->width-2), mt_rand(1,$this->height-2), $this->fontcolor);
		}
	}

	//输出图像
	private function outputImage() {
		if(imagetypes() & IMG_JPG) {
			header('Content-type:image/jpeg');
			imagejpeg($this->image);
		} elseif (imagetypes() & IMG_GIF) {
			header('Content-type:image/gif');
			imagegif($this->imgage);
		} elseif(imagetypes() & IMG_PNG) {
			header('Content-type:image/png');
			imagepng($this->imgage);
		} else {
			die('创建图像出错啦!');
		} 
		imagedestroy($this->image);
	}

	//输出图像
	public function showImage() {
		$this->createBackground();
		$this->createCode();
		$this->createLine();
		$this->imageText();
		$this->outputImage();
	}

	//检验验证码
	public function checkCode() {

	}

}