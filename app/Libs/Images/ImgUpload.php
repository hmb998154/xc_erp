<?php
namespace App\Libs\Images;

use App\Libs\Images\ResDemo;
use Log;
use Config;
include("config.php");
define("HTTP_PRE", "http://");
// -----------类-------------
class ImgUpload{
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
    * @name thum    缩略图函数
    * @param    sting   $img_name   图片路径
    * @param    int     $max_width  略图最大宽度
    * @param    int     $max_height 略图最大高度
    * @param    sting   $suffix 略图后缀(如"min.jpg"代表小图,"img_m.jpg"代表中图,"img_l.jpg"代表大图)
    * @return   void
    */
    public static function thum($img_name,$max_width,$max_height,$suffix){
        $img_infos=getimagesize($img_name);
        $img_height=$img_infos[0];
        $img_width=$img_infos[1];
        $img_extension='';
        switch($img_infos[2]){
          case 1:
              $img_extension='gif';
              break;
          case 2:
              $img_extension='jpeg';
              break;
          case 3:
              $img_extension='png'; 
              break;
          case 4:
              $img_extension='GIF';
              break;
          case 5:
              $img_extension='JPG';
              break;
          case 6:
              $img_extension='PNG';
              break;
          case 7:
              $img_extension='JPEG';
              break;
          default:
              $img_extension='jpeg';
              break;
          }
        $new_img_size=get_thum_size($img_width,$img_height,$max_width,$max_height);//新的图片尺寸
        $img_func='';//函数名称
        $img_handle='';//图片句柄
        $thum_handle='';//略图图片句柄
        switch($img_extension){
            case 'jpg':
                $img_handle=imagecreatefromjpeg($img_name);
                $img_func='imagejpeg';
                break;
            case 'jpeg':
                $img_handle=imagecreatefromjpeg($img_name);
                $img_func='imagejpeg';
                break;
            case 'png':
                $img_handle=imagecreatefrompng($img_name);
                $img_func='imagepng';
                break;
            case 'gif':
                $img_handle=imagecreatefromgif($img_name);
                $img_func='imagegif';
                break;
            default:
                $img_handle=imagecreatefromjpeg($img_name);
                $img_func='imagejpeg';
                break;
            }
        $quality=100;//图片质量
        if($img_func==='imagepng' && (str_replace('.', '', PHP_VERSION)>= 512)){
            //针对php版本大于5.12参数变化后的处理情况
            $quality=9;
        }
        $thum_handle=imagecreatetruecolor($new_img_size['height'],$new_img_size['width']);
        if(function_exists('imagecopyresampled')){
            imagecopyresampled($thum_handle,$img_handle, 0, 0, 0, 0,$new_img_size['height'],$new_img_size['width'],$img_height,$img_width);
        }else{
           imagecopyresized($thum_handle,$img_handle, 0, 0, 0, 0,$new_img_size['height'],$new_img_size['width'],$img_height,$img_width);
        }
        call_user_func_array($img_func,array($thum_handle,get_thum_name($img_name,$suffix),$quality));
        imagedestroy($thum_handle);//清除句柄
        imagedestroy($img_handle);//清除句柄
    }

    /**
    * @name get_thum_size 获得缩略图的尺寸
    * @param    $width  图片宽
    * @param    $height 图片高
    * @param    $max_width 最大宽度
    * @param    $maxHeight 最大高度
    * @param    array $size;
    */
    public static function get_thum_size($width,$height,$max_width,$max_height){
        $now_width=$width;//现在的宽度
        $now_height=$height;//现在的高度
        $size=array();
        if($now_width>$max_width){//如果现在宽度大于最大宽度
            $now_height*=number_format($max_width/$width,4);
            $now_width= $max_width;
            }
        if($now_height>$max_height){//如果现在高度大于最大高度
            $now_width*=number_format($max_height/$now_height,4);
            $now_height=$max_height;
            }
        $size['width']=floor($now_width);
        $size['height']=floor($now_height);
        return $size;
    }

    /**
    * get_thum_name 获得略图的名称(在大图基础加_x)
    */
    public static function get_thum_name($img_name,$suffix){
        $str=explode('#',$img_name);
        $resImg=substr($str[0],0,strpos($str[0],"."));
        return ($resImg.'_'.$suffix);
    }

    public static function arrJson($status,$desc,$data=""){
      $arr =array(
        'status'=>$status,
        'msg'=>$desc,
        'data'=>$data,
        );
      die(json_encode($arr,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 压缩图片
     * @param  [type] $inOrderId  [description]
     * @param  [type] $imgDir     [description]
     * @param  string $extendType [description]
     * @return [type]             [description]
     */
    public static function imgAppCommon($inOrderId,$imgDir,$extendType="png"){
      $filename = $inOrderId."_".md5(time().mt_rand(10, 99)).$extendType;
      $newFilePath = $imgDir.$filename;
      $newFile = fopen($newFilePath,"w");
      fwrite($newFile,$newFilePath);
      fclose($newFile);
      if(empty($newFile)){
         arrJson(400,"空数据");
      }else{
         thum($newFilePath,IMG_WIDTH,IMG_HEIGHT,IMG_NAME_TYPE.$extendType);
         $newFilePath = ltrim($newFilePath,".");
         arrJson(200,"请求成功",$_SERVER['HTTP_HOST'].$newFilePath);
      }
    }

    /**
     * app上传图片
     * @return
     */
     public static function imgApp(){
        $image = $_FILES["res_name"]["tmp_name"];
        $inOrderId = $_POST["order_id"];
        $type = $_POST["file_type"];
      
        $extendType="";
        if(empty($inOrderId)){
           ImgUpload::arrJson(1001,"编号不能为空");
        }
        if(empty($image)){
           ImgUpload::arrJson(1002,"文件未上传");
        }
       $size = getimagesize($image);
       switch ($size['mime']) {
           case "image/gif":
               $extendType=".gif";
               break;
           case "image/jpeg":
                $extendType=".jpg";
               break;
           case "image/png":
               $extendType=".png";
               break;
          default :
           ImgUpload::arrJson(1003,"文件格式异常");
           break;
       }

        $arrRules=array("gps","order","check");
        $fp = fopen($image, "r");
        $file = fread($fp, $_FILES["res_name"]["size"]);
        $imgDir = './uploads/images/'.date("Ymd",time())."/".$type."/";
        if(!is_dir($imgDir)){ 
          //创建目录
           $dir = explode('/', $imgDir);
           $d="";
           foreach($dir as $v){
              if($v){
               $d .= $v. '/';
               if(!is_dir($d)){
                // Log::info($d);
                $state = mkdir($d, 0777);
                  // Log::info($state);
                  // ImgUpload::arrJson(400,$state); 
                if(!$state){
                  ImgUpload::arrJson(1004,'目录异常');
                }
               }
              }
           }
        }
        // imgAppCommon($inOrderId,$imgDir,$extendType);
        $filename = $inOrderId."_".md5(time().mt_rand(10, 99)).$extendType;
        $newFilePath = $imgDir.$filename;
        $data = $file;
        $newFile = fopen($newFilePath,"w");
        
        $a = fwrite($newFile,$data);
        fclose($newFile);
        if(empty($newFile)){
           ImgUpload::arrJson(1005,"图片异常");
        }else{
           $arr_min_img = pathinfo($newFilePath);
           $filename = $arr_min_img['filename'];
           $extension = $arr_min_img['extension'];
           $dirname = $arr_min_img['dirname'];
           $new_img = $dirname.'/'.$filename.'_'.IMG_NAME_TYPE.'.'.$extension;
           ImgUpload::compressed_image($newFilePath,$new_img); //压缩图片
           $newFilePath = ltrim($newFilePath,".");
           ImgUpload::arrJson(200,"图片上传成功" ,HTTP_PRE.$_SERVER['HTTP_HOST'].$newFilePath);
        }
        exit;
    }

    /**
     * app上传视频
     * @return
     */
     public static function videoApp(){
      $type=$_POST['file_type'];
      if($type !="videos"){
         ImgUpload::arrJson(1000,"视频分类不规范");exit;
      }

      $inOrderId=$_POST['order_id'];
      $filename=$_FILES['res_name']['name'];
      $fileType=strrchr($filename,".");
      $extend=array(".flv",".mp4",".avi",".MP4");
      if(!in_array($fileType, $extend)){
         ImgUpload::arrJson(1001,"只支持.flv .avi .mp4格式");
      }
      $exname=strtolower(substr($_FILES['res_name']['name'],(strrpos($_FILES['res_name']['name'],'.')+1)));
      $uploadfile = ImgUpload::getname($exname,$type,$inOrderId);
    
      $res = ltrim($uploadfile,"..");
      if (move_uploaded_file($_FILES['res_name']['tmp_name'], $uploadfile)) {
           ImgUpload::arrJson(200,"视频上传成功",  HTTP_PRE.$_SERVER['HTTP_HOST'].$res);
      }else {
           ImgUpload::arrJson(1002,"视频文件错误");
      }
    }

    /**
     * 创建目录
     * @param  [type] $imgDir [description]
     * @return [type]         [description]
     */
    public static function create_file_dir($imgDir){
      if(!is_dir($imgDir)){ 
        //创建目录
         $dir = explode('/', $imgDir);
         $d="";
         foreach($dir as $v){
            if($v){
             $d .= $v. '/';
             if(!is_dir($d)){
              $state = mkdir($d, 0777);
              if(!$state){
                arrJson(400,'目录异常');
              }
             }
            }
         }
      }
      return $imgDir;
    }

    /**
     * pc端公共
     * @return
     */
    public static function common($fileDir){
      $strMethod = $_POST['method'];
      $strMethod = isset($strMethod) ? $strMethod : "add";
      switch ($strMethod) {
        case 'add':
          $strFile=$_FILES['res_name'];
          DD($strFile);
          $ufile=new ResDemo(APP_PATH.$fileDir);
          $strRes=$ufile->upload_file($strFile);
          dd($strRes);
          if (!empty($strRes)) {
             ImgUpload::arrJson(200,"PC上传图片成功",$strRes);
          }else{
             ImgUpload::arrJson(400,"PC上传图片失败",$strRes);
          }
          break;
        case 'del':
          break;
      }
    }

    /**
     * PC端上传图片
     * @return string json
     */
    public static function imgWeb(){
      $dirFileTime=date("Ymd",time())."/";
      $inOrderId=$_POST['order_id'];
      $imgType=$_POST['file_type'];
      $arrRules=array("gps","customer","check");

      if(!in_array($imgType, $arrRules)){
           ImgUpload::arrJson(401,"文件分类错误");
      }
      if(empty($imgType)){
         ImgUpload::arrJson(402,"文件分类参数不能为空");
      }

      try {
        switch ($imgType) {
          case "shop":  //
            ImgUpload::common($dirFileTime.$imgType);
            break;
          default:
          die( arrJson(403,"图片分类异常"));
            break;
        }
      } catch (Exception $e) {
         die( arrJson(404,$e.getMessage()));
      }
    }

    // 创建文件
    public static function getname($exname,$type,$inOrderId){
       $dir ="./uploads/videos/";
       $i=$inOrderId."_".date("Ymd")."_".md5(time().mt_rand(10, 99));
       if(!is_dir($dir)){
         $dir = explode('/', $dir);
         $d="";
         foreach($dir as $v){
            if($v){
             $d .= $v . '/';
             if(!is_dir($d)){
              $state = mkdir($d, 0777);
              if(!$state)
                 ImgUpload::arrJson(406,'创建目录'.$d.'时出错');
             }
            }
         }
         $dir=join($dir,"/");
         if(is_array($dir)){
            if (move_uploaded_file($_FILES['resourceName']['tmp_name'], $dir.$i.".".$exname)) {
                 ImgUpload::arrJson(200,"文件上传成功",$uploadfile);
            }else {
                 ImgUpload::arrJson(401,"文件上传失败！");
            }
         }
       }

       while(true){
         if(!is_file($dir.$i.".".$exname)){
            $name=$i.".".$exname;
            break;
          }
         $i++;
       }
       return $dir.$name;
    }

    /**
     * 上传视频
     */
    public static function WebVideo(){
       $type = $_POST['filetype'];
       if($type !="videos"){
          arrJson(401,"视频分类格式不规范");exit;
       }

       $inOrderId=$_POST['orderId'];
       $filename=$_FILES['resourceName']['name'];
       $fileType=strrchr($filename,".");
       $extend=array(".flv",".mp4",".avi",".MP4");
       if(!in_array($fileType, $extend)){
          arrJson(400,"只支持.flv .avi .mp4格式");
       }
       $exname=strtolower(substr($_FILES['resourceName']['name'],(strrpos($_FILES['resourceName']['name'],'.')+1)));
       $uploadfile = getname($exname,$type,$inOrderId);
       // $this->create_file_dir($uploadfile);
      
       if(!is_dir($imgDir)){ 
         //创建目录
          $dir = explode('/', $imgDir);
          $d="";
          foreach($dir as $v){
             if($v){
              $d .= $v. '/';
              if(!is_dir($d)){
               $state = mkdir($d, 0777);
               if(!$state){
                 arrJson(400,'目录异常');
               }
              }
             }
          }
       }

       if (move_uploaded_file($_FILES['resourceName']['tmp_name'], ".".$uploadfile)) {
            arrJson(200,"视频上传成功",  HTTP_PRE.$_SERVER['HTTP_HOST'].$uploadfile);
       }else {
            arrJson(401,"视频文件错误");
       }
    }


    /**
     * 检测资源类型大小（）图片最大不能超过8M,视频不能超过100M
     * @param  int $max_size 最大值
     * @return bool
     */
    public static function resourceSize($max_size){
      $size=$_FILES['resourceName']['size'];
      if($size>$max_size){
        return true;
      }
    }

    /**  
     * 转换格式
     * @param  [type] $strFile [description]
     * @return [type]          [description]
     */
    public static function changeFile($strFile){
      $res = strpos($strFile, "/uploads");
      $res = __DIR__.substr($strFile, $res);
      return $res;
    }

    /**
     * 删除缩略图
     * @param  [type] $strFile [description]
     * @return [type]          [description]
     */
    public static function changeMinDel($strFile){
      if(empty($strFile)){
        return false;
      }else{
        $res = pathinfo($strFile);
        $dirname  = $res['dirname'];
        $filename  = $res['filename'];
        $extension  = $res['extension'];
        return  $dirname."/".$filename."_min".".".$extension;
      }
    }
}
?>
