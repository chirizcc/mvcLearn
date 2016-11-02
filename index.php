<?php

// 自动导入类
function __autoload($classname)
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

// 接收参数
$c = empty($_GET['c']) ? 'Index' : $_GET['c'];
$a = empty($_GET['a']) ? 'index' : $_GET['a'];

// 实例化
$classname = $c.'Controller';
$controller = new $classname();

$controller->$a();