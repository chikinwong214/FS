<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Billthreshold.php';
require_once APPLICATION_PATH.'/models/Totalvalue.php';

class ThresholdController extends BaseController
{   
	
	public function thresholduiAction()
	{
		//实例化模型
		$thresholdModel = new Billthreshold();
		
		$db = $thresholdModel->getAdapter();
		
		$sql = "SELECT * FROM billthreshold ORDER BY id DESC LIMIT 1";
				
		$result = $db->query($sql);

		$threshold = $result->fetchAll();
		
		$this->view->threshold = $threshold[0];
		
		$this->render("thresholdui");
		
	}
		
	public function thresholdinsertAction()
	{	
		
		//选填项内容
		$cost = $this->getRequest()->getParam("cost");
		if (""==$cost)
		{
			$cost= 0;
		}
		
		$make = $this->getRequest()->getParam("make");
		if (""==$make)
		{
			$make = 0;
		}
		
		$travel = $this->getRequest()->getParam("travel");
		if (""==$travel)
		{
			$travel = 0;
		}
				
		
		$welfare = $this->getRequest()->getParam("welfare");
		if (""==$welfare)
		{
			$welfare = 0;
		}				
		
		$fund = $this->getRequest()->getParam("fund");
		if (""==$fund)
		{
			$fund = 0;
		}
		
		$meals = $this->getRequest()->getParam("meals");
		if (""==$meals)
		{
			$meals = 0;
		}
		
		$education = $this->getRequest()->getParam("education");
		if (""==$education)
		{
			$education = 0;
		}
		
		$costInitial = $this->getRequest()->getParam("costInitial");
		if (""==$costInitial)
		{
			$costInitial = 0;
		}
		$welfareInitial = $this->getRequest()->getParam("welfareInitial");
		if (""==$welfareInitial)
		{
			$welfareInitial = 0;
		}
		$fundInitial = $this->getRequest()->getParam("fundInitial");
		if (""==$fundInitial)
		{
			$fundInitial = 0;
		}
		$mealsInitial = $this->getRequest()->getParam("mealsInitial");
		if (""==$mealsInitial)
		{
			$mealsInitial = 0;
		}
		$educationInitial = $this->getRequest()->getParam("educationInitial");
		if (""==$educationInitial)
		{
			$educationInitial = 0;
		}
		
		date_default_timezone_set('PRC');
        $date=date("Y-m-d H:i:s");
        
        $loginuser = $_SESSION['loginuer'][0];        
        $editor = $loginuser['user'];
		 
		//表模型，准备插入数据库
		$thresholdModel = new Billthreshold();
		
		//防注入适配器
		$db = $thresholdModel->getAdapter();
		
		
		$row = array (
				'date'    => $date,
				'cost'	=>(float)($cost/100),
				'make'     => (float)($make/100),		
				'travel' => (float)($travel/100),				
				'welfare' => (float)($welfare/100),				
				'fund'     => (float)($fund/100),		
				'meals'     => (float)($meals/100),
				'education' => (float)($education/100),
				
				'costInitial' => $costInitial,
				'welfareInitial' => $welfareInitial,
				'fundInitial' => $fundInitial,
				'mealsInitial' => $mealsInitial,
				'educationInitial' => $educationInitial,
				'editor'    => $editor
				
		);
		
		
		$table = 'billthreshold';
		
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
		 
		$this->view->url = '/threshold/thresholdui';
		
		$this->render("afterinsert");
	}
	
	public function afterinsertAction()
	{
		
	}
	
	
	public function totalvalueuiAction()
	{
		
		//实例化模型
		$totalModel = new Totalvalue();
		
		$db = $totalModel->getAdapter();
	
		$sql = "SELECT * FROM totalvalue ORDER BY id DESC LIMIT 1";
	
		$result = $db->query($sql);
	
		$totalvalue = $result->fetchAll();
		/*
		print_r($totalvalue);
		exit();
		*/
		$this->view->totalvalue = $totalvalue[0];
		
		$this->render("totalvalueui");
	}
	
	public function totalvalueAction()
	{
		$date = $this->getRequest()->getParam("date");
		if("" == $date)
		{
			date_default_timezone_set('PRC');
			$date=date("Y");
		}
		
		$totalvalue = $this->getRequest()->getParam("totalvalue");
		if (""==$totalvalue)
		{
			$totalvalue = 0;
		}

        $loginuser = $_SESSION['loginuer'][0];        
        $editor = $loginuser['user'];
		 
		//表模型，准备插入数据库
		$totalValueModel = new Totalvalue();
		
		//防注入适配器
		$db = $totalValueModel->getAdapter();		
		
		$row = array (
				'date'    => $date,					
				'totalValue'     => (float)($totalvalue),				
				'editor'    => $editor				
		);
		
		
		$table = 'totalvalue';
		
		$where= "date =  \"$date\" ";
		$sql = "SELECT * FROM $table WHERE $where";
		$result = $db->query($sql);
		$item = $result->fetchAll();
		if($item[0]['id'] > 0)
		{
			echo "<script> alert('该年度的总产值已经输入，若需修改请到查看页面');</script>";
			$this->render('totalvalueui');
		}
		// 插入数据行并返回行数
		else {
			$rows_affected = $db->insert($table,$row);		
		
			if ($rows_affected) 
			{
				$this->view->insertState = "提交成功！";
			}
			else 
			{
				$this->view->insertState = "提交失败！";
			}
		 
			$this->view->url = '/threshold/totalvalueui';
		
			$this->render("afterinsert");
		}
	}
	
	
	
}