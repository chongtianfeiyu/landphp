<?php
/**
* 图片操作类
*/
class picture {
	private $picture; //目标图片
	private $back_picture; //生成的图片
	private $water;  //水印图片
	private $width; //图片的宽度
	private $height; //图片的高度
	private $font;   //水印文字字体
	private $font_color; //水印文字颜色

	public function __construct($picture) {
		$this->picture = $picture
		$this->getImageinfo();
	}

	//等比缩放图片
	public function thumb($width,$height) {
		$imageinfo = $this->getImageinfo();

	}

	//裁剪图片
	public function cut() {

	}

	//增加水印文字
	public function font_water() {

	}

	//增加水印图片
	public function image_water() {

	}

	//图片旋转
	public function trun() {

	}

	//图片锐化
	public function sharp() {

	}

	//获取图片信息
	public function getImageinfo() {
		$info = getimagesize($this->picture);
		if($info !== false) {
			$imagesize = filesize($this->picture);
			$imagetype = strtolower(substr(image_type_to_extension($info[2]),1));
			$this->width = $info[0];
			$this->height = $info[1],
			$this->type => $imagetype,
			$this->size => $imagesize,
			switch ($info[2]) {
				case 1:
					
					break;
				case 2:
					break;
				case 3:
					break;
				
				default:
					
					break;
			}
		} else {
			$this->set_error('1000','图片不存在');
		}
	}

	private function set_error($code,$message) {
		return json_decode(array('error_code' => $code,'message' => $message));
	}

	public function __destruct() {

	}
}