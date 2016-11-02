<?php

class UserController extends Controller
{

    private $model = null;

    public function __construct()
    {
        // 实例化Modle类
        parent::__construct();
        $this->model = new Model('student');
    }

	public function index()
	{	
		$data = $this->model->order('id desc')->select();
        $this->assign('title','用户列表');
        $this->assign('data',$data);
        $this->display('User/index.html');
	}

    public function del()
    {
        if($this->model->del($_GET['id']) == 1){
            $this->redirect('删除成功!','./index.php?c=User');
        }else{
            $this->redirect('删除失败!','./index.php?c=User');
        }
    }

    public function adel(){
        $this->model->del($_GET['id']);
        $data = $this->model->order('id desc')->select();
        echo json_encode($data);
    }

    public function add()
    {
        $this->assign('title','添加用户');
        $this->display('User/add.html');
    }

    public function insert()
    {
        if($this->model->insert()){
            $this->redirect('添加成功!','./index.php?c=User');
        }else{
            $this->redirect('添加失败!');
        }
    }

    public function edit()
    {
        $this->assign('title','修改信息');
        $this->assign('data',$this->model->find($_GET['id']));
        $this->display('User/edit.html');
    }

    public function updata()
    {
        if($this->model->updata() == 1){
            $this->redirect('修改成功!','./index.php?c=User');
        }else{
            $this->redirect('添加失败!');
        }
    }

}