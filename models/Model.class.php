<?php

class Model{

	private $link = null;
	private $tabName = null;
	private $fieldList = array();
	private $pKey = null;
	private $field = null;
	private $where = null;
	private $order = null;
	private $limit = null;

	/**
	* 构造函数，打开数据库资源
	* @param string $tabName 要链接的数据表
	*/
	public function __construct($tabName){
		$this->link = mysqli_connect(HOST,USER,PWD) or die('数据库连接失败');
		mysqli_select_db($this->link,DBNAME);
		mysqli_set_charset($this->link,'utf8');
		$this->tabName = $tabName;
		$this->getFieldList();
	}

	/**
	* 析构函数，关闭数据库资源
	*/
	public function __destruct(){
		mysqli_close($this->link);
	}

	/**
	* 魔术方法，用于连贯操作及友好提示
	*/
	public function __call($funName,$params){
		switch ($funName) {
			case 'field':
				$this->field = $params[0];
			break;

			case 'where':
				$this->where = $params[0];
			break;

			case 'order':
				$this->order = $params[0];
			break;

			case 'limit':
				$this->limit = $params[0];
			break;
			
			default:
				echo '该方法不存在';
				return false;
			break;
		}
		return $this;
	}

	/**
    * 获取主键及所有字段名
    * @return array $list 返回二位数组
    */
	private function getFieldList(){
		$sql = "desc {$this->tabName}";

		$result = mysqli_query($this->link,$sql);
		if(!$result){
			return false;
		}

		$list = array();
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row['Field'];
			if($row['Key'] == 'PRI'){
				$this->pKey = $row['Field'];
			}
		}

		mysqli_free_result($result);
		$this->fieldList = $list;
	}

	/**
    * SQL语句执行
    * @param string $sql SQL语句
    * @return array $data 返回二位数组
    */
	private function query($sql){
		$result = mysqli_query($this->link,$sql);
		if(!$result){
			return false;
		}

		$data = array();
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row;
		}

		mysqli_free_result($result);
		return $data;
	}

    /**
	* 根据条件查询所有数据
	* @return array $data 返回二维数组
	*/
	public function select(){
		$field = '*';
		if(!empty($this->field)){
			$field = $this->field;
			$this->field = null;
		}

		$where  = '';
		if(!empty($this->where)){
			$where = ' where '.$this->where;
			$this->where = null;
		}

		$order  = '';
		if(!empty($this->order)){
			$order = ' order by '.$this->order;
			$this->order = null;
		}

		$limit  = '';
		if(!empty($this->limit)){
			$limit = ' limit '.$this->limit;
			$this->limit = null;
		}

		$sql = "select {$field} from {$this->tabName} {$where} {$order} {$limit}";
		// echo $sql;
		// die;

		return $this->query($sql);
	}

	/**
	* 根据条件查询单条数据
	* @param string $value 要查询的字段名
	* @return array $data 返回一维数组
	*/
	public function find($value,$field = 'id'){
		$sql = "select * from {$this->tabName} where {$field} = '{$value}'";

		$data = $this->query($sql);
		if(!$data){
			return false;
		}

		return $data[0];
	}

    /**
    * 添加数据
    * @param array $data 要添加的数据 从$_POST获取
    * @return 自增id
    */
	public function insert($data = array()){
		if(empty($data)){
			$data = $_POST;
		}

		$fields = array();
		$values = array();
		foreach($data as $k => $v){
			if(in_array($k, $this->fieldList) && $k != $this->pKey){
				$fields[] = $k;
				$values[] = "'".$v."'";
			}
		}

		$sql = "insert into {$this->tabName} (".implode(',',$fields).") values (".implode(',',$values).")";
		
		$result = mysqli_query($this->link,$sql);
		if(!$result){
			return false;
		}

		return mysqli_insert_id($this->link);
	}

    /**
    * 删除数据
    * @param $value 要删除的数据的主键值
    * @return 影响的数据条数
    */
	public function del($value){
		$sql = "delete from {$this->tabName} where {$this->pKey} = {$value}";

		mysqli_query($this->link,$sql);

		return mysqli_affected_rows($this->link);
	}

    /**
    * 更新数据
    * @param array $data 要更新的数据 从$_POST获取
    * @return 影响的数据条数
    */
	public function updata($data = array()){
		if(empty($data)){
			$data = $_POST;
		}

		$values = array();
		foreach ($data as $k => $v) {
			if(in_array($k, $this->fieldList) && $k != $this->pKey){
				$values[] = $k."='".$v."'";
			}
		}

		$sql = "update {$this->tabName} set ".implode(',', $values)." where {$this->pKey} = {$data[$this->pKey]}";
		
		mysqli_query($this->link,$sql);

		return mysqli_affected_rows($this->link);
	}

    /**
    * 获取数据条数
    * @param string serach 搜索条件
    * @return 返回表中的数据条数
    */
	public function getRows($search){
		$where = '';
		if(!empty($search)){
			$where = "where name like '%{$search}%'";
		}
		$sql = "select count(*) as count from student {$where}";
		// echo $sql;
		// die;
		return $this->query($sql)[0]['count'];
	}

}