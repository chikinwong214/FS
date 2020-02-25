<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Admin.php';

class ModifyuserrightController extends BaseController
{

	public function updateitemAction()
	{
		
		//获取表格修改的内容
		$id = $this->getRequest()->getParam("id","");
	
		if ("" == $id)
		{
			echo "数据错误！";
			exit();
		}
	
		//这里，后面可能要加上空的话的处理情况
		$userRight = $this->getRequest()->getParam("userRight","");
	
		//echo $userRight;
		//exit();
		//表模型，准备插入数据库
		$itemModel = new Admin();
	
		//防注入适配器
		$db = $itemModel->getAdapter();
			
	
		$set = array (
				'userRight'    => $userRight
		);
	
		// where语句
		$where =$db->quoteInto('id = ?', $id);
	
		// 更新表数据,返回更新的行数
		$rows_affected = $itemModel->update($set, $where);
		
		//echo $rows;
		//exit();
	
		if ($rows_affected > 0)
		{
			echo "<script> alert('修改成功');</script>";
		}
		else
		{
			echo "<script> alert('修改失败');</script>";
		}
			
		$this->forward("index","admin");
	}
	
	public function deleteitemAction()
	{
		//获取表格修改的内容
		$id = $this->getRequest()->getParam("id","");
	
		if ("" == $id)
		{
			echo "数据错误！";
			exit();
		}
	//echo "nimei";
	//exit();
		//表模型，准备插入数据库
		$itemModel = new Admin();
	
		//防注入适配器
		$db = $itemModel->getAdapter();
	
		$where = $db->quoteInto('id = ?', $id);
	
		$rows_affected = $itemModel->delete($where);
			
		if ($rows_affected > 0)
		{
			echo "<script> alert('删除成功');</script>";
		}
		else
		{
			echo "<script> alert('删除失败');</script>";
		}
	
		$this->forward("index","admin");
	}
	
	public function resetpwdAction()
	{
		$id = $this->getRequest()->getParam("id","");
		
		if ("" == $id)
		{
			echo "数据错误！";
			exit();
		}
		
		//表模型，准备插入数据库
		$itemModel = new Admin();
		
		//防注入适配器
		$db = $itemModel->getAdapter();
			
		$password = md5("123456");
		$set = array (
				'password'    => $password
		);
		
		// where语句
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
			
		$this->forward("index","admin");
	}
	
}