<?php 
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Designmoney.php';
require_once APPLICATION_PATH.'/models/Item.php';
require_once APPLICATION_PATH.'/models/Totalcontract.php';

require_once APPLICATION_PATH.'/models/Classes/PHPExcel.php';
require_once APPLICATION_PATH.'/models/Myexcel.php';

class DesignmoneyController extends BaseController
{   
	public function inputuiAction()
	{
		
	}
	
	public function insertitemAction()
	{
		//获取表单内容
		//必填项内容
		$date = $this->getRequest()->getParam("date","");
		$serviceId = $this->getRequest()->getParam("serviceId","");
		$projectName = $this->getRequest()->getParam("projectName","");
		$money = $this->getRequest()->getParam("money","");
	
		date_default_timezone_set('PRC');
        $editDate=date("Y-m-d H:i:s");
        
        $loginuser = $_SESSION['loginuer'][0];        
        $editor = $loginuser['user'];
        
        // 调用表模型
        $itemModel = new Designmoney();
        
        //防注入适配器
        $db = $itemModel->getAdapter();
        
        // 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
        $row = array (
        		'date'    => $date,
        		'serviceId'     => $serviceId,
        		'projectName'=>$projectName,
        		'money'     => $money,
        		'editDate' => $editDate,
        		'editor' => $editor
        );                
        
        // 插入数据的数据表
        $table = 'designmoney';
        
        // 插入数据行并返回行数
        $rows_affected = $db->insert($table,$row);
        
        
        if ($rows_affected)
        {
        	$this->view->insertState = "提交成功！";
        }
        else
        {
        	$this->view->insertState = "提交失败！";
        }
        
        $this->view->url = '/designmoney/inputui';
        
        $this->forward("afterinsert","threshold");
	}
	
	
	
	
	//合同总额输入界面
	public function totalcontractuiAction()
	{
		
	}
	
	public function inserttotalcontractAction()
	{
		//获取表单内容
		//必填项内容
		$date = $this->getRequest()->getParam("date","");
		$serviceId = $this->getRequest()->getParam("serviceId","");
		$projectName = $this->getRequest()->getParam("projectName","");
		$money = $this->getRequest()->getParam("totalmoney","");
		
		date_default_timezone_set('PRC');
		$editDate=date("Y-m-d H:i:s");
		
		$loginuser = $_SESSION['loginuer'][0];
		$editor = $loginuser['user'];
		
		// 调用表模型
		$itemModel = new Totalcontract();
		
		//防注入适配器
		$db = $itemModel->getAdapter();
		
		
		// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
		$row = array (
				'serviceId'     => $serviceId,
				'projectName' =>$projectName,
				'signDate'    => $date,
				'totalContract'     => $money,
				'editDate' => $editDate,
				'editor' => $editor
		);
		
		// 插入数据的数据表
		$table = 'totalcontract';

		$where= "serviceId =  \"$serviceId\" ";
		$sql = "SELECT * FROM $table WHERE $where";
		$result = $db->query($sql);
		$item = $result->fetchAll();
		if($item[0]['id'] > 0)
		{
			echo "<script> alert('该项目的合同总额已经输入，若需修改请到查看页面');</script>";
			$this->render('totalcontractui');
		}
		else 
		{
			// 插入数据行并返回行数
			$rows_affected = $db->insert($table,$row);
		
			if ($rows_affected)
			{
				$this->view->insertState = "提交成功！";
			}
			else
			{
				$this->view->insertState = "提交失败！";
			}
		
			$this->view->url = '/designmoney/totalcontractui';
		
			$this->forward("afterinsert","threshold");
		}
	}
	
}