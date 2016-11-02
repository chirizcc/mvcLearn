<?php

// 导入类
require './configs/config.php';
require './controllers/IndexController.class.php';
require './controllers/UserController.class.php';
require './controllers/GoodsController.class.php';

// 接收参数
$c = empty($_GET['c']) ? 'Index' : $_GET['c'];
$a = empty($_GET['a']) ? 'index' : $_GET['a'];

// 实例化
$clasname = $c.'Controller';
$controller = new $clasname();

$controller->$a();