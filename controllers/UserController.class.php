<?php

class UserController
{

	public function index()
	{
		// 实例化Modle类
		$model = new Model('student');
		$data = $model->select();
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}

}