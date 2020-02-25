<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';

require_once APPLICATION_PATH.'/models/CostBill.php';
require_once APPLICATION_PATH.'/models/WelfareBill.php';
require_once APPLICATION_PATH.'/models/FundBill.php';
require_once APPLICATION_PATH.'/models/MealsBill.php';
require_once APPLICATION_PATH.'/models/EducationBill.php';
require_once APPLICATION_PATH.'/models/Totalvalue.php';
require_once APPLICATION_PATH.'/models/Totalcontract.php';
require_once APPLICATION_PATH.'/models/Designmoney.php';

require_once APPLICATION_PATH.'/models/GetCount.php';

class AlteritemController extends BaseController
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
		/*
		echo "nimei";
		exit();
		*/
		//这里，后面可能要加上空的话的处理情况
		$date = $this->getRequest()->getParam("date","");
    	$serviceId = $this->getRequest()->getParam("serviceId","");
        $projectName = $this->getRequest()->getParam("projectName","");
        
        
        //选填项内容
        $make = $this->getRequest()->getParam("make");
        if (""==$make) 
        {
        	$make = 0;
        }
        //=================================================================
        $travel = $this->getRequest()->getParam("travel");
        if (""==$travel)
        {
        	$travel = 0;
        }
        // add waterElec by jacob 2014-04-10
        $waterElec = $this->getRequest()->getParam("waterElec");
        if (""==$waterElec)
        {
        	$waterElec = 0;
        }
        $costOthers = $this->getRequest()->getParam("costOthers");
        if (""==$costOthers)
        {
        	$costOthers = 0;
        }
        
        $welfare = $this->getRequest()->getParam("welfare");
        if (""==$welfare)
        {
        	$welfare = 0;
        }  
              
        //=================================================================
        $computer = $this->getRequest()->getParam("computer");
        if (""==$computer)
        {
        	$computer = 0;
        }
        
        $display = $this->getRequest()->getParam("display","0");
        if (""==$display)
        {
        	$display = 0;
        }
        $camera = $this->getRequest()->getParam("camera","0");
        if (""==$camera)
        {
        	$camera = 0;
        }
        
        $fundOthers = $this->getRequest()->getParam("fundOthers");
        if (""==$fundOthers)
        {
        	$fundOthers = 0;
        }
        
        //==================================================================
        $applicant = $this->getRequest()->getParam("applicant","");
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
        $remarks = $this->getRequest()->getParam("remarks");
        if (""==$remarks)
        {
        	$remarks = " ";
        }
           
		//表模型，准备插入数据库
        $itemModel = new Item();   
        
        //防注入适配器
        $db = $itemModel->getAdapter();

        
        $set = array (
		    'date'    => $date,
		    'serviceId'     => $serviceId,
		    'projectName' => $projectName,			
			'make'     => $make,
				
			'travel' => $travel,
			'waterElec'=>$waterElec,
			'costOthers'    => $costOthers,
			'welfare' => $welfare,
				
			'computer'    => $computer,
			'display'     => $display,
			'camera' => $camera,
			'fundOthers'     => $fundOthers,
				
			'meals'     => $meals,
			'education' => $education,
			'applicant'    => $applicant,
			'remarks' => $remarks
		);  
        

        // where语句
        $where =$db->quoteInto('id = ?', $id);  
        
        //echo "g";
       	//print_r($set);
       //	echo "         ";
       //	print_r($where);
       // exit();
        
        // 更新表数据,返回更新的行数
        $rows_affected = $itemModel->update($set, $where);
        //print_r($set);
        //exit();
        
        if ($rows_affected > 0) 
        {
        	echo "<script> alert('修改成功');</script>";
        }
        else 
        {
        	echo "<script> alert('修改失败');</script>";
        }
       
        $this->forward("index","showitem");
	}
	public function delete($itemModel,$id)
	{
		//echo "nimei";

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
		$deleItem = $this->getRequest()->getParam("deleItem","");

		//表模型，准备插入数据库
		if("cost" == $deleItem)
		{

			$itemModel = new CostBill();
			$this->delete($itemModel,$id);
			$this->forward("showcost","showitem");
		}
		else if("welfare" == $deleItem)
		{
			$itemModel = new WelfareBill();
			$this->delete($itemModel,$id);
			$this->forward("showwelfare","showitem");
		}
		else if("fund" == $deleItem)
		{
			$itemModel = new FundBill();
			$this->delete($itemModel,$id);
			$this->forward("showfund","showitem");
		}
		else if("meals" == $deleItem)
		{
			$itemModel = new MealsBill();
			$this->delete($itemModel,$id);
			$this->forward("showmeals","showitem");
		}
		else if("education" == $deleItem)
		{
			$itemModel = new EducationBill();
			$this->delete($itemModel,$id);
			$this->forward("showeducation","showitem");
		}
		else if("totalvalue" == $deleItem)
		{
			$itemModel = new Totalvalue();
			$this->delete($itemModel,$id);
			$this->forward("showtotalvalue","showitem");
		}
		else if("contract" == $deleItem)
		{
			$itemModel = new Totalcontract();
			$this->delete($itemModel,$id);
			$this->forward("showcontract","showitem");			
		}
		else if("designmoney" == $deleItem)
		{
			$itemModel = new Designmoney();
			$this->delete($itemModel,$id);
			$this->forward("showdesignmoney","showitem");
		}
		else 
		{
			echo "数据错误！";
			exit();
		}
	}
	
	//======================================================================================================
	///
	///
	//// 2014-4-26 新开始
	
	
	
	
	public function updatecostAction()
	{
		//获取表格修改的内容
		$id = $this->getRequest()->getParam("id","");
	
		if ("" == $id)
		{
			echo "数据错误！";
			exit();
		}
		
		//这里，后面可能要加上空的话的处理情况
		$date = $this->getRequest()->getParam("date","");
		$serviceId = $this->getRequest()->getParam("serviceId","");
		$projectName = $this->getRequest()->getParam("projectName","");
		$income = $this->getRequest()->getParam("income","");
		if(""==$income)
		{
			$income = 0;
		}
	
	
		//选填项内容
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
		$waterElec = $this->getRequest()->getParam("waterElec");
		if (""==$waterElec)
		{
			$waterElec = 0;
		}
		$costOthers = $this->getRequest()->getParam("costOthers");
		if (""==$costOthers)
		{
			$costOthers = 0;
		}

		
		$applicant = $this->getRequest()->getParam("applicant","");
		$remarks = $this->getRequest()->getParam("remarks");
		if (""==$remarks)
		{
			$remarks = " ";
		}
		
		
		//表模型，准备插入数据库
		$itemModel = new CostBill();
	
		//防注入适配器
		$db = $itemModel->getAdapter();
	
		//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
		
		$set = array (
				'date'    => $date,
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'income'     => $income,
				
				'make'     => $make,	
				'travel' => $travel,
				'waterElec'=>$waterElec,
				'costOthers'    => $costOthers,

				'applicant'    => $applicant,
				'remarks' => $remarks
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
		 
		$this->forward("showcost","showitem");
	}
	
	
	public function updatewelfareAction()
		{
			$id = $this->getRequest()->getParam("id","");
	
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
		
			//这里，后面可能要加上空的话的处理情况
			$date = $this->getRequest()->getParam("date","");
			$serviceId = $this->getRequest()->getParam("serviceId","");
			$projectName = $this->getRequest()->getParam("projectName","");
			$income = $this->getRequest()->getParam("income","");
			if(""==$income)
			{
				$income = 0;
			}
	
	
		//选填项内容
			$welfare= $this->getRequest()->getParam("welfare");
			if (""==$welfare)
			{
				$welfare = 0;
			}

		
			$applicant = $this->getRequest()->getParam("applicant","");
			$remarks = $this->getRequest()->getParam("remarks");
			if (""==$remarks)
			{
				$remarks = " ";
			}
		
		
			//表模型，准备插入数据库
			$itemModel = new WelfareBill();
	
			//防注入适配器
			$db = $itemModel->getAdapter();
	
			//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
		
			$set = array (
				'date'    => $date,
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'income'     => $income,
				
				'welfare'     => $welfare,	

				'applicant'    => $applicant,
				'remarks' => $remarks
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
			$this->forward("showwelfare","showitem");
		}
		
		
	public function updatefundAction()
	{
		$id = $this->getRequest()->getParam("id","");
	
		if ("" == $id)
		{
			echo "数据错误！";
			exit();
		}
		
		//这里，后面可能要加上空的话的处理情况
		$date = $this->getRequest()->getParam("date","");
		$serviceId = $this->getRequest()->getParam("serviceId","");
		$projectName = $this->getRequest()->getParam("projectName","");
		$income = $this->getRequest()->getParam("income","");
		if(""==$income)
		{
			$income = 0;
		}
	
	
		//选填项内容
		$computer = $this->getRequest()->getParam("computer");
		if (""==$computer)
		{
			$computer = 0;
		}
		$display = $this->getRequest()->getParam("display");
		if (""==$display)
		{
			$display = 0;
		}
		$camera = $this->getRequest()->getParam("camera");
		if (""==$camera)
		{
			$camera = 0;
		}
		$fundOthers = $this->getRequest()->getParam("fundOthers");
		if (""==$fundOthers)
		{
			$fundOthers = 0;
		}

		
		$applicant = $this->getRequest()->getParam("applicant","");
		$remarks = $this->getRequest()->getParam("remarks");
		if (""==$remarks)
		{
			$remarks = " ";
		}
		
		
		//表模型，准备插入数据库
		$itemModel = new FundBill();
	
		//防注入适配器
		$db = $itemModel->getAdapter();
	
		//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
		
		$set = array (
				'date'    => $date,
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'income'     => $income,
				
				'computer'     => $computer,	
				'display' => $display,
				'camera'=>$camera,
				'fundOthers'    => $fundOthers,

				'applicant'    => $applicant,
				'remarks' => $remarks
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
		 
		
		$this->forward("showfund","showitem");
	}
		
		
		
		
		public function updatemealsAction()
		{
			$id = $this->getRequest()->getParam("id","");
	
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
		
			//这里，后面可能要加上空的话的处理情况
			$date = $this->getRequest()->getParam("date","");
			$serviceId = $this->getRequest()->getParam("serviceId","");
			$projectName = $this->getRequest()->getParam("projectName","");
			$income = $this->getRequest()->getParam("income","");
			if(""==$income)
			{
				$income = 0;
			}
	
	
		//选填项内容
			$meals= $this->getRequest()->getParam("meals");
			if (""==$meals)
			{
				$meals = 0;
			}

		
			$applicant = $this->getRequest()->getParam("applicant","");
			$remarks = $this->getRequest()->getParam("remarks");
			if (""==$remarks)
			{
				$remarks = " ";
			}
		
		
			//表模型，准备插入数据库
			$itemModel = new MealsBill();
	
			//防注入适配器
			$db = $itemModel->getAdapter();
	
			//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
		
			$set = array (
				'date'    => $date,
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'income'     => $income,
				
				'meals'     => $meals,	

				'applicant'    => $applicant,
				'remarks' => $remarks
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
			$this->forward("showmeals","showitem");
		}
		
		
		
		
		public function updateeducationAction()
		{
			$id = $this->getRequest()->getParam("id","");
	
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
		
			//这里，后面可能要加上空的话的处理情况
			$date = $this->getRequest()->getParam("date","");
			$serviceId = $this->getRequest()->getParam("serviceId","");
			$projectName = $this->getRequest()->getParam("projectName","");
			$income = $this->getRequest()->getParam("income","");
			if(""==$income)
			{
				$income = 0;
			}
	
	
		//选填项内容
			$education= $this->getRequest()->getParam("education");
			if (""==$education)
			{
				$education = 0;
			}

		
			$applicant = $this->getRequest()->getParam("applicant","");
			$remarks = $this->getRequest()->getParam("remarks");
			if (""==$remarks)
			{
				$remarks = " ";
			}
		
		
			//表模型，准备插入数据库
			$itemModel = new EducationBill();
	
			//防注入适配器
			$db = $itemModel->getAdapter();
	
			//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
		
			$set = array (
				'date'    => $date,
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'income'     => $income,
				
				'education'     => $education,	

				'applicant'    => $applicant,
				'remarks' => $remarks
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
			$this->forward("showeducation","showitem");
		}
		
		public function updatetotalvalueAction()
		{
			$id = $this->getRequest()->getParam("id","");
			
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
			
			//这里，后面可能要加上空的话的处理情况
			$date = $this->getRequest()->getParam("date","");
			$totalValue = $this->getRequest()->getParam("totalValue","");
			if(""==$totalValue)
			{
				$totalValue = 0;
			}
			
			
			
			//表模型，准备插入数据库
			$itemModel = new Totalvalue();
			
			//防注入适配器
			$db = $itemModel->getAdapter();
			
			//$balance = GetCostBalance();//这样算出来是不对的，擦，算出来的是修改之前的余额
			
			$set = array (
					'date'    => $date,
					'totalValue'     => $totalValue
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
			$this->forward("showtotalvalue","showitem");
		}
		
		
		public function updatecontractAction()
		{
			//echo 'df';
			//exit();
			$id = $this->getRequest()->getParam("id","");
		
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
		
		//这里，后面可能要加上空的话的处理情况
			$signDate = $this->getRequest()->getParam("signDate","");
			$serviceId = $this->getRequest()->getParam("serviceId","");
			$projectName = $this->getRequest()->getParam("projectName","");
			$totalContract = $this->getRequest()->getParam("totalContract","");
			if(""==$totalContract)
			{
				$totalContract = 0;
			}
		
		
			//表模型，准备插入数据库
			$itemModel = new Totalcontract();
		
			//防注入适配器
			$db = $itemModel->getAdapter();
		
		
			$set = array (
				
				'serviceId'     => $serviceId,
				'projectName' => $projectName,
				'signDate'    => $signDate,
				'totalContract'     => $totalContract
			);
		
			//print_r($set);
			//exit();
		
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
			$this->forward("showcontract","showitem");
		}
		
		

		public function updatedesignmoneyAction()
		{
			//echo 'df';
			//exit();
			$id = $this->getRequest()->getParam("id","");
		
			if ("" == $id)
			{
				echo "数据错误！";
				exit();
			}
		
			//这里，后面可能要加上空的话的处理情况
			$date = $this->getRequest()->getParam("date","");
			$serviceId = $this->getRequest()->getParam("serviceId","");
			$projectName = $this->getRequest()->getParam("projectName","");
			$money = $this->getRequest()->getParam("money","");
			if(""==$money)
			{
				$money = 0;
			}
		
		
			//表模型，准备插入数据库
			$itemModel = new Designmoney();
		
			//防注入适配器
			$db = $itemModel->getAdapter();
		
		
			$set = array (
					'date'    => $date,
					'serviceId'     => $serviceId,
					'projectName' => $projectName,
					
					'money'     => $money
			);
		
			//print_r($set);
			//exit();
		
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
			$this->forward("showdesignmoney","showitem");
		}
}