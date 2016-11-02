<?php

// 导入模板引擎
require './libs/Smarty.class.php';
require './configs/config.php';

// 自动导入类
function mvc_Autoload($classname)
{
	if(file_exists('./controllers/'.$classname.'.class.php')) {
		require './controllers/'.$classname.'.class.php';
	}elseif(file_exists('./models/'.$classname.'.class.php')) {
		require './models/'.$classname.'.class.php';
	}else {
		header('HTTP/1.0 404 not fount');
		echo '<h1>404 NOT FOUNT</h1>';
		die;
	}
}

//将自定义的自动加载函数注册为 系统的加载函数
spl_autoload_register('mvc_Autoload');

// 接收参数
//获取控制器名   类名
$c = empty($_GET['c']) ? 'Index' : $_GET['c'];
//获取操作名  方法名
$a = empty($_GET['a']) ? 'index' : $_GET['a'];

// 实例化
$classname = $c.'Controller';
$controller = new $classname();

//调用控制器中的方法
$controller->$a();