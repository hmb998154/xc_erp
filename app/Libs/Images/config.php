<?php 
error_reporting (0);
 
define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "root");

define('SYS_ROOT', str_replace("\\", '/', dirname(__FILE__)));
define('SYS_DOWNLOAD', SYS_ROOT.'./uploads/compress');
define('SYS_WIN', strpos(strtoupper(PHP_OS), 'WIN') !== false ? true: false);
define('SYS_CHMOD', ('0777' && !SYS_WIN) ? '0777' : 0);

define("API_NUM", 174);

define("APP_PATH", "uploads/images/");
define("IMG_HEIGHT", 600);//缩略图高度
define("IMG_WIDTH", 800); //缩略图宽度

define("IMG_PROPORTION", 0.8);//压缩比例
define("IMG_PRECISION", 80);//图片精度

define("IMG_NAME_TYPE", "min");//(如"min.jpg"代表小图,"mid.jpg"代表中图,"big.jpg"代表大图)

header('Access-Control-Allow-Origin:'.env('WEB_URL'));
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, Accept, X-Requested-With');



?>