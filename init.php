<?php

define('APP_DEBUG', true);              //调试开关
define('COMMON_PATH','./common/');   //公共文件目录
define('UPLOAD_PATH', './upload/');  //上传文件目录


//载入函数库
require COMMON_PATH.'function.php';
//载入数据库函数
require COMMON_PATH.'db.php';
//载入模块文件
require COMMON_PATH.'module.php';

