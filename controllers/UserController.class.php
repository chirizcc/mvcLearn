<?php

class UserController extends Controller
{

    private $model = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model('student');
    }

	public function index()
	{
		// 实例化Modle类
		$data = $this->model->select();
        $this->assign('title','User');
        $this->assign('data',$data);
        $this->display('User/index.html');
	}

}