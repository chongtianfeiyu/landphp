<?php
/**
* 图片类
* 处理图片的保存，水印，裁剪,移动
* @author 彭城岛主
*/
class image {
    /**
    * 文件信息
    */
    private $file = array();
    /**
    * 存放目录
    */
    private $dir = 'public';
    /**
    * 错误代码
    */
    private $code = 0;
    /**
    * 最大上传限制
    */
    private $max_size = 8192;

    //使用单列模式
    private static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
    * 处理上传文件
    * @param array $file 上传文件数组
    * @param string $dir 上传文件存放目录
    * @param string $forcename 文件名
    */
    public function init($file,$dir='tmp',$forcename='') {
        if(!is_array($file) || empty($file)) {
            $this->file = array();
            $this->code = -1;
            return false;
        } else {
            $files['size'] = intval($file['size']);
            $files['name'] = trim($file['name']);
            $files['thumb'] = '';
            $files['ext'] = '';
            $files['file_dir'] = ;
            $files['perfix'] = ;
            $this->file = $files;
            $this->code = 0;
            return true;
        }
    }

    /**
    * 返回错误标识
    */
    public function error() {
        return $this->code;
    }

    /**
    * 获取文件的后缀名
    */
    private function fileExt($file_name) {
        return addslashes(strtolower(substr(strrchr($file_name, '.'), 1, 10)));
    }

    /**
    * 获取保存路径
    */
    private function getTargetDir($dir,$forcename='') {
        if($dir == 'tmp') {
            $dirname = '../public/temp/'.date('Y/m/d/H');
        } elseif($forcename != '') {
            $forcedir = $this->formatforcename($forcename);
            $dirname = '../public/'.$dir.'/'.$forcedir;
        } else {
            $dirname = '../public/'.$dir.'/'.date('Y/m/d');
        }
        if(!is_dir($dirname)) {
            mkdir($dirname,0755,true);
        }
        return $dirname;
    }

    /**
    * 获取保存路径或者文件名
    */
    private function formatforcename($forcename,$type='path') {
        $result = '';
        $tmp = explode('/', $forcename);
        if(count($tmp) < 2) {
            $tmp = array(
                substr(md5($forcename), 0, 1),
                substr(md5($forcename), 1, 1),
                substr(md5($forcename), 2, 1),
                $forcename
            );
        }
        if($type == 'path') {
            unset($tmp[count($tmp)-1]);
            $result = implode($tmp, '/');
        } else {
            $result = $tmp[count($tmp)-1];
        }
        return $result;
    }

    /**
    * 获取文件名
    */
    private function get_target_filename($dir, $forcename) {
        if($forcename != '') {
            $filename = $this->formatforcename($forcename,'name');
        } else {
            $filename = md5(microtime(true)).rand(100000,999999);
        }
        return $filename;
    }

    /**
    * 判断是否是上传文件
    * @param $source  文件路径
    */
    private function isUploadFile($source) {
        return $source && ($source != 'none') && (is_uploaded_file($source) || is_uploaded_file(str_replace('\\\\', '\\', $source)));
    }

    /**
    * 判断是否是图像
    * @param string $ext
    */
    private function isImageExt($ext) {
        $img_ext  = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'giff');
        return in_array($ext, $img_ext) ? 1 : 0;
    }
}