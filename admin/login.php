<?php
define('NO_CHECK_LOGIN', true);

require './init.php';

//接收操作参数
$action = I('a', 'get', 'string');

//退出登录
if($action=='logout'){
	//清除Session
	unset($_SESSION['cms']['admin']); //清除Session
	display([true, '您已经成功退出。']);
}

if($_POST){
	
    
        $name = I('name', 'post', 'html');
	$password = I('password', 'post', 'string');
        
	$captcha = I('captcha', 'post', 'string');
	//判断验证码
	if(!checkCode($captcha)){
		display([false, '登录失败：验证码输入有误。'], $name);
	}
        
	$data = db_fetch(DB_ROW, 'SELECT `id`,`name`,`password` FROM `cms_admin` WHERE `name`=?', 's', $name);
	//判断用户名和密码
	if($data && ($password == $data['password'])){
		//保存1到首页
		$_SESSION['cms']['admin'] = ['id'=>$data['id'], 'name'=>$data['name']];
		//跳转到首页
		redirect('./index.php');
        }
        //E('登录失败：用户名和密码错误');         
        display([false,'登陆失败：用户名或密码错误。']);
}else{
        display();  
}
require './view/login.html';


function display($msg=null){
    require './view/login.html';
    exit;   
}

//对验证码进行验证
function checkCode($code){
	$captcha = $_SESSION['cms']['captcha'];
	if(!empty($captcha)){
		unset($_SESSION['cms']['captcha']); //清除验证码，防止重复验证
		return strtoupper($captcha) == strtoupper($code); //不区分大小写
	}
	return false;
}