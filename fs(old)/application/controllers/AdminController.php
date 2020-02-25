<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Admin.php';

class AdminController extends BaseController
{
	public function indexAction()
	{
		//实例化模型
		$itemModel = new Admin();
		
		//防注入适配器
		$db = $itemModel->getAdapter();	
		
		//选择语句//由于不需要最前面的序号，所以这里要将选择的字段列出来
		//$select = $db->select();
		//$select->from('admin',array('user','password','userRight'));
		//$select->from('admin',array('user','userRight'));
		
		
		$loginuser = $_SESSION['loginuer'][0];
		$where = $db->quoteInto("user != ?", $loginuser['user']);
		
		$sql = $db->quoteInto(
				'SELECT id,user,userRight FROM admin WHERE user != ?',
				$loginuser['user']
		);
		
		$result = $db->query($sql);
		
		// 使用PDOStatement对象$result将所有结果数据放到一个数组中
		$item = $result->fetchAll();
		
		//print_r($rows);
		//exit();
		
		//取出数据
		//$item = $db->
					
		//session_start();
		//$_SESSION['exportdata'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);		
		
		$this->view->item = $itemOutput;
		

		$this->render("index");
	}
	public function modifypasswordAction()
	{
		
		$this->render("modifypassword");
	}
	public function acceptpasswordAction()
	{
		$pwd = $this->getRequest()->getParam("conPwd","");
		if ("" == $pwd)
		{
			echo "数据错误！";
			exit();
		}
		

		//print_r($_SESSION['loginuer'][0]);
		$id = $_SESSION['loginuer'][0]['id'];
		
		//实例化模型
		$itemModel = new Admin();
		
		//防注入适配器
		$db = $itemModel->getAdapter();
		
		$set = array (
				'password'    => md5($pwd)
		);

		$where =$db->quoteInto('id = ?', $id);

		// 更新表数据,返回更新的行数
		$rows_affected = $itemModel->update($set, $where);
		
		if ($rows_affected > 0)
		{
			echo "<script> alert('修改成功');</script>";
		}
		else
		{
			echo "<script> alert('修改失败');</script>";
		}
		$this->forward("modifypassword");
		
	}
	
	public function addmemberAction()
	{
	
		$this->render("addmember");
	}
	public function acceptmemberAction()
	{
		
		
		$user = $this->getRequest()->getParam("userName","");
		$pwd = $this->getRequest()->getParam("conPwd","");
		$userRight =  $this->getRequest()->getParam("userRight","");
		if ("" == $pwd || "" == $user || "" == $userRight)
		{
			echo "数据错误！";
			exit();
		}
		

		//实例化模型
		$itemModel = new Admin();
		
		//防注入适配器
		$db = $itemModel->getAdapter();
		

		$sql = $db->quoteInto('SELECT id,user FROM admin WHERE user = ?',$user);
		$result = $db->query($sql);
		$item = $result->fetchAll();

		
		if(sizeof($item) > 0)
		{
			echo "<script> alert('用户名已经存在，请使用其他的用户名');</script>";
			$this->forward("addmember");
		}
		else 
		{
			$table = 'admin';
			$data = array (
					'user'        => $user,
					'password'    => md5($pwd),
					'userRight'   => $userRight
			);
				
			// 插入数据行并返回行数
			$rows_affected = $db->insert($table,$data);
			if ($rows_affected > 0)
			{
				echo "<script> alert('添加成功');</script>";
			}
			else
			{
				echo "<script> alert('添加失败');</script>";
			}
			$this->forward("index");
		}
		
		
	}
	
}