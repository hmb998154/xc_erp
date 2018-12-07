<?php 
namespace App\Libs\Images;
include("config.php");
/**
 * 文件上传类
 */
 class ResDemo {
    public $max_size = '1000000';//设置上传文件大小
    public $file_name = 'date';//
    public $allow_types;//允许上传的文件扩展名，不同文件类型用“|”隔开
    public $errmsg = '';//错误信息
    public $uploaded = '';//上传后的文件名(包括文件路径)
    public $save_path;//上传文件保存路径
    private $files;//提交的等待上传文件
    private $file_type = array();//文件类型
    private $ext = '';//上传文件扩展名


    /**
     * 构造函数，初始化类
     * @access public
     * @param string $save_path 上传的目标文件夹
     * @param string $file_name 上传后的文件名
     */
    public function __construct($save_path = './uploads',$file_name = 'date',$allow_types = '') {
      // $this->save_path   = (preg_match('//$/',$save_path)) ? $save_path : $save_path . '/';
      $this->save_path   = trim($save_path,"")."/";
      $this->file_name   = $file_name;//重命名方式代表以时间命名，其他则使用给予的名称
      $this->allow_types = $allow_types == '' ? 'JPG|GIF|PNG|jpg|gif|png|zip|rar' : $allow_types;
    }

    /**
     * 上传文件
     * @access public
     * @param $files 等待上传的文件(表单传来的$_FILES[])
     * @return boolean 返回布尔值
     */
   public function upload_file($files) {

    $name = $files['name'];
    $type = $files['type'];
    $size = $files['size'];

    $tmp_name = $files['tmp_name'];
    $error = $files['error'];
    switch ($error) {
       case 0 : $this->errmsg = '';
        break;
       case 1 : $this->errmsg = '超过了php.ini中文件大小';
        break;
       case 2 : $this->errmsg = '超过了MAX_FILE_SIZE 选项指定的文件大小';
        break;
           case 3 : $this->errmsg = '文件只有部分被上传';
        break;
       case 4 : $this->errmsg = '没有文件被上传';
        break;
       case 5 : $this->errmsg = '上传文件大小为0';
        break;
          default : $this->errmsg = '上传文件失败！';
      break;
     }
      if($error == 0 && is_uploaded_file($tmp_name)) {
       if($this->check_file_type($name) == FALSE){
        // return FALSE;
        return toRes(2000,"");
       }
      
       $this->set_save_path();//设置文件存放路径
       // $inOrderId=$_POST['orderId'];
       $inOrderId= 1;
       $new_name = $this->file_name != 'date' ? $this->file_name.'.'.$this->ext : $inOrderId."_".md5(time().mt_rand(10, 99)).'.'.$this->ext;//设置新文件名
       $this->uploaded = $this->save_path.$new_name;//上传后的文件名
       if(move_uploaded_file($tmp_name,$this->uploaded)){
       
       $arr_min_img = pathinfo($this->uploaded);
       $filename = $arr_min_img['filename'];
       $extension = $arr_min_img['extension'];
       $dirname = $arr_min_img['dirname'];
       $new_img = $dirname.'/'.$filename.'_'.IMG_NAME_TYPE.'.'.$extension;

       self::compressed_image($this->uploaded,$new_img); //压缩图片
        // $pallPath=$_SERVER['HTTP_HOST']."/".$this->save_path.$new_name;
        $pallPath = $this->save_path.$new_name;
        return toRes(200,$pallPath);
       }else{
        $this->errmsg = '文件'.$this->uploaded.'上传失败！';
        return toRes(2000,$this->errmsg );
        // return $this->errmsg;
       }
      }
   }

   /**
   * desription 压缩图片
   * @param sting $imgsrc 图片路径
   * @param string $imgdst 压缩后保存路径
   */
   public static function compressed_image($imgsrc,$imgdst){
     list($width,$height,$type)=getimagesize($imgsrc);
     $new_width = ($width>600?IMG_WIDTH:$width)*IMG_PROPORTION;
     $new_height =($height>600?IMG_HEIGHT:$height)*IMG_PROPORTION;
     switch($type){
       case 1:
         $giftype=check_gifcartoon($imgsrc);
         if($giftype){
           // header('Content-Type:image/gif');
           $image_wp=imagecreatetruecolor($new_width, $new_height);
           $image = imagecreatefromgif($imgsrc);
           imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
           //75代表的是质量、压缩图片容量大小
           imagejpeg($image_wp, $imgdst,IMG_PRECISION);
           imagedestroy($image_wp);
         }
         break;
       case 2:
         $image_wp=imagecreatetruecolor($new_width, $new_height);
         $image = imagecreatefromjpeg($imgsrc);
         imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
         //75代表的是质量、压缩图片容量大小
         imagejpeg($image_wp, $imgdst,IMG_PRECISION);
         imagedestroy($image_wp);
         break;
       case 3:
         // header('Content-Type:image/png');
         $image_wp=imagecreatetruecolor($new_width, $new_height);
         $image = imagecreatefrompng($imgsrc);
         imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
         //75代表的是质量、压缩图片容量大小
         imagejpeg($image_wp, $imgdst,IMG_PRECISION);
         imagedestroy($image_wp);
         break;
     }
   }

   /**
   * 检查上传文件类型
   * @access public
   * @param string $filename 等待检查的文件名
   * @return 如果检查通过返回TRUE 未通过则返回FALSE和错误消息
   */
    public function check_file_type($filename){
      $ext = $this->get_file_type($filename);
      $this->ext = $ext;
        $allow_types = explode('|',$this->allow_types);//分割允许上传的文件扩展名为数组
        //检查上传文件扩展名是否在请允许上传的文件扩展名中
        if(in_array($ext,$allow_types)){
         return TRUE;
        }else{
         $this->errmsg = '上传文件'.$filename.'类型错误，只支持上传'.str_replace('|',',',$this->allow_types).'等文件类型!';
         return FALSE;
        }
    }

    /**
     * 取得文件类型
     * @access public
     * @param string $filename 要取得文件类型的目标文件名
     * @return string 文件类型
     */
    public function get_file_type($filename){
     $info = pathinfo($filename);
     $ext = $info['extension'];
     return $ext;
    }


   /**
    * 设置文件上传后的保存路径
    */
   public  function set_save_path(){
    if(!is_dir($this->save_path)){
     $this->set_dir();
    }
   }

     /**
      * 创建目录
      * @access public
      * @param string $dir 要创建目录的路径
      * @return boolean 失败时返回错误消息和FALSE
      */
     public  function set_dir($dir = null){
      //检查路径是否存在
      if(!$dir){
       $dir = $this->save_path;
      }
      if(is_dir($dir)){
       $this->errmsg = '需要创建的文件夹已经存在！';
      }
      $dir = explode('/', $dir);
      $d="";
      foreach($dir as $v){
         if($v){
          $d .= $v . '/';
          if(!is_dir($d)){
           $state = mkdir($d, 0777);
           if(!$state)
            $this->errmsg = '创建目录' . $d . '出错！';
          }
         }
      }
      return true;
     }

  /**
   * 手机检测
   * @return
   */
  public static function isMobile()
  {
      // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
      if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
      {
          return true;
      }
      // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
      if (isset ($_SERVER['HTTP_VIA']))
      {
          // 找不到为flase,否则为true
          return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
      }
      if (isset ($_SERVER['HTTP_USER_AGENT']))
      {
          $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
          // 从HTTP_USER_AGENT中查找手机浏览器的关键字
          if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
          {
              return true;
          }
      }
      // 协议法，因为有可能不准确
      if (isset ($_SERVER['HTTP_ACCEPT']))
      {
          // 如果只支持wml并且不支持html那一定是移动设备
          // 如果支持wml和html但是wml在html之前则是移动设备
          if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
          {
              return true;
          }
      }
      return false;
  }
}
 ?>