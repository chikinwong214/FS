<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';

require_once APPLICATION_PATH.'/models/CostBill.php';
require_once APPLICATION_PATH.'/models/WelfareBill.php';
require_once APPLICATION_PATH.'/models/FundBill.php';
require_once APPLICATION_PATH.'/models/MealsBill.php';
require_once APPLICATION_PATH.'/models/EducationBill.php';

require_once APPLICATION_PATH.'/models/GetCount.php';

class MainController extends BaseController
{   
    public function indexAction()
    {
        // action body
       session_start();
       $loginuser = $_SESSION['loginuer'][0];  
       $this->view->loginuser = $loginuser['user'];
       
       date_default_timezone_set('PRC');
       $date=date("Y-m-d H:i:s");
       $this->view->date = $date;
        
    	$this->render("index");
    }

    public function mainAction()
    {
    	
    }
    
    public function introductionAction()
    {
    	 
    }
    
    public function additemuiAction()
    {
    	 
    }
    
    public function additemAction()
    {
    	
    	//print_r($txtBalance);
    	
    	//获取表单内容
    	//必填项内容
    	$txtDate = $this->getRequest()->getParam("txtDate","");
    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
        $txtProjectName = $this->getRequest()->getParam("txtProjectName","");
        $txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
        //print_r($txtDate);
        //exit();
        //选填项内容
        $txtMake = $this->getRequest()->getParam("txtMake");
        if (""==$txtMake) 
        {
        	$txtMake = 0;
        }
        
        $txtTravel = $this->getRequest()->getParam("txtTravel");
        if (""==$txtTravel)
        {
        	$txtTravel = 0;
        }
        // add waterElec by jacob 2014-04-10
        $txtWaterElec = $this->getRequest()->getParam("txtWaterElec");
        if (""==$txtWaterElec)
        {
        	$txtWaterElec = 0;
        }
        
        $txtCostOthers = $this->getRequest()->getParam("txtCostOthers");
        if (""==$txtCostOthers)
        {
        	$txtCostOthers = 0;
        }
        
        $txtWelfare = $this->getRequest()->getParam("txtWelfare");
        if (""==$txtWelfare)
        {
        	$txtWelfare = 0;
        }        
        
        $txtComputer = $this->getRequest()->getParam("txtComputer");
        if (""==$txtComputer)
        {
        	$txtComputer = 0;
        }
        
        $txtDisplay = $this->getRequest()->getParam("txtDisplay","0");
        if (""==$txtDisplay)
        {
        	$txtDisplay = 0;
        }
        $txtCamera = $this->getRequest()->getParam("txtCamera","0");
        if (""==$txtCamera)
        {
        	$txtCamera = 0;
        }
        
        $txtFundOthers = $this->getRequest()->getParam("txtFundOthers");
        if (""==$txtFundOthers)
        {
        	$txtFundOthers = 0;
        }
        
        $txtMeals = $this->getRequest()->getParam("txtMeals");
        if (""==$txtMeals)
        {
        	$txtMeals = 0;
        }
        
        $txtEducation = $this->getRequest()->getParam("txtEducation");
        if (""==$txtEducation)
        {
        	$txtEducation = 0;
        }
        
        $txtRemarks = $this->getRequest()->getParam("txtRemarks");
        if (""==$txtRemarks)
        {
        	$txtRemarks = " ";
        }
        $tempExpend = ($txtMake + $txtTravel + $txtWaterElec + $txtCostOthers + $txtWelfare + $txtComputer + $txtDisplay + $txtCamera + $txtFundOthers + $txtMeals + $txtEducation);
        $txtBalance = getBalance() ;
        //print_r($txtBalance);
        $txtBalance -= $tempExpend;
        
        //print_r($tempExpend);
        //print_r($txtBalance);
        
        
     // exit();
             
       // session_start();
        $loginuser = $_SESSION['loginuer'][0];
        $txtEditor = $loginuser['user'];
        
      //  print_r($loginuser);
     //   exit();
        //print_r($txtEditor);
        //exit();
        // 调用表模型
        $itemModel = new Item(); 
        
        //防注入适配器
        $db = $itemModel->getAdapter();
        
        // 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
		$row = array (
		    'date'    => $txtDate,
		    'serviceId'     => $txtServiceId,
		    'projectName' => $txtProjectName,			
			'make'     => $txtMake,
				
			'travel' => $txtTravel,
			'waterElec'=>$txtWaterElec,
			'costOthers'    => $txtCostOthers,
			'welfare' => $txtWelfare,
				
			'computer'    => $txtComputer,
			'display'     => $txtDisplay,
			'camera' => $txtCamera,
			'fundOthers'     => $txtFundOthers,
				
			'meals'     => $txtMeals,
			'education' => $txtEducation,
			'applicant'    => $txtAapplicant,
			'remarks' => $txtRemarks,
				
			'balance' => $txtBalance,
			'editor' => $txtEditor
		);
		
		//print_r($row);
		//exit();
		
		// 插入数据的数据表
		$table = 'projectbill';
		
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
		
		//$data  =  getCountFiveItem($txtServiceId);
		//print_r($data);
		//exit();
        //根据getExceedItem()返回值弹框显示超出阈值的项		
		$exceedItem = getExceedItem($txtServiceId);
        $str  =  "";
        //print_r($exceedItem);
        //exit();
        if( $exceedItem['cost'] == 1)
        {
        	//$this->view->isCostExceed = 1;
        	$str .= "成本超出阈值范围!" ;
        }
        if($exceedItem['welfare'] == 1)
        {
        	//$this->view->isWelfareExceed = 1;
        	$str .= "\\n福利超出阈值范围!" ;
        }
        if($exceedItem['fund'] == 1)
        {
        	//$this->view->isFundExceed = 1;
        	$str .= "\\n发展基金超出阈值范围!" ;
        }
        if($exceedItem['meals'] == 1)
        {
        	//$this->view->isMealsExceed = 1;
        	$str .= "\\n餐费超出阈值范围!" ;
        }
        if($exceedItem['education'] == 1)
        {
        	//$this->view->isEducationExceed = 1;
        	$str .= "\\n教育培训超出阈值范围!" ;
        }
        
        if($exceedItem['make'] == 1)
        {
        	//$this->view->isMakeExceed = 1;
        	$str .= "\\n制作费超出阈值范围!" ;
        }
        if($exceedItem['travel'] == 1)
        {
        	//$this->view->isTravelExceed = 1;
        	$str .= "\\n差旅费超出阈值范围!" ;
        }
		if($exceedItem['hasExceedItem'] == 1)
		{
			echo "<script> alert(\"$str\");</script>";
		}
		$this->render("additem");
        
    }
    //==================================================================================
    //==================================================================================
    //2014-4-27
    
    public function addcostAction()
    {
    	//转到添加成本报账的页面
    	/*
    	session_start();
    	$loginuser = $_SESSION['loginuer'][0];
    	$this->view->loginuser = $loginuser['user'];
    	 
    	date_default_timezone_set('PRC');
    	$date=date("Y-m-d H:i:s");
    	$this->view->date = $date;
    	*/
    	//$this->render("addcost");
    	
    }
    public function addcostdatabaseAction()
    {
    	//提交成本数据库
    	date_default_timezone_set('PRC');
    	$txtDate = date("Y-m-d");

    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
    	$txtProjectName = $this->getRequest()->getParam("txtProjectName","");
    	$txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
    	
    	//选填项内容
    	$txtIncome =  $this->getRequest()->getParam("txtIncome");
    	if (""==$txtIncome)
    	{
    		$txtIncome = 0;
    	}
    	
    	$txtMake = $this->getRequest()->getParam("txtMake");
    	if (""==$txtMake)
    	{
    		$txtMake = 0;
    	}
    	$txtTravel = $this->getRequest()->getParam("txtTravel");
    	if (""==$txtTravel)
    	{
    		$txtTravel = 0;
    	}
    	$txtWaterElec = $this->getRequest()->getParam("txtWaterElec");
    	if (""==$txtWaterElec)
    	{
    		$txtWaterElec = 0;
    	}
    	$txtCostOthers = $this->getRequest()->getParam("txtCostOthers");
    	if (""==$txtCostOthers)
    	{
    		$txtCostOthers = 0;
    	}   	
    	
    	$txtRemarks = $this->getRequest()->getParam("txtRemarks");
    	if (""==$txtRemarks)
    	{
    		$txtRemarks = " ";
    	}

    	$loginuser = $_SESSION['loginuer'][0];
    	$txtEditor = $loginuser['user'];

    	// 调用表模型
    	$itemModel = new CostBill();
    	
    	//防注入适配器
    	$db = $itemModel->getAdapter();
    	
    	// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
    	$row = array (
    			'date'    => $txtDate,
    			'serviceId'     => $txtServiceId,
    			'projectName' => $txtProjectName,
    			
    			'income'   =>$txtIncome,
    			
    			'make'     => $txtMake,   	
    			'travel' => $txtTravel,
    			'waterElec'=>$txtWaterElec,
    			'costOthers'    => $txtCostOthers, 
    			   			
    			'applicant'    => $txtAapplicant,
    			'remarks' => $txtRemarks,
    			'editor' => $txtEditor
    	);
    	
    	// 插入数据的数据表
    	$table = 'costbill';
    	
    	//print_r($db);
    	//exit();
    	// 插入数据行并返回行数
    	$rows_affected = $db->insert($table,$row);
    	
    	
    	if ($rows_affected)
    	{
    		echo "<script> alert('提交成功');</script>";
    	}
    	else
    	{
    		echo "<script> alert('提交失败');</script>";
    	}
    	
    	$this->render("addcost");
    }
    
    //
    public function addwelfareAction()
    {
    	//转到添加福利报账的页面
    	/*
    	session_start();
    	$loginuser = $_SESSION['loginuer'][0];
    	$this->view->loginuser = $loginuser['user'];
    	
    	date_default_timezone_set('PRC');
    	$date=date("Y-m-d H:i:s");
    	$this->view->date = $date;
    	*/
    	//$this->render("addwelfare");
    }
    public function addwelfaredatabaseAction()
    {
    	
    	//提交福利数据库
    	date_default_timezone_set('PRC');
    	$txtDate = date("Y-m-d");

    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
    	$txtProjectName = $this->getRequest()->getParam("txtProjectName","");
    	$txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
    	
    	//选填项内容
    	$txtIncome =  $this->getRequest()->getParam("txtIncome");
    	if (""==$txtIncome)
    	{
    		$txtIncome = 0;
    	}
    	
    	$txtWelfare = $this->getRequest()->getParam("txtWelfare");
    	if (""==$txtWelfare)
    	{
    		$txtWelfare = 0;
    	}
    	
    	$txtRemarks = $this->getRequest()->getParam("txtRemarks");
    	if (""==$txtRemarks)
    	{
    		$txtRemarks = " ";
    	}

    	$loginuser = $_SESSION['loginuer'][0];
    	$txtEditor = $loginuser['user'];

    	// 调用表模型
    	$itemModel = new WelfareBill();
    	
    	//防注入适配器
    	$db = $itemModel->getAdapter();
    	
    	// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
    	
    	$row = array (
    			'date'    => $txtDate,
    			'serviceId'     => $txtServiceId,
    			'projectName' => $txtProjectName,
    			
    			'income'   =>$txtIncome,
    			
    			'welfare'  => $txtWelfare,  
    			   			
    			'applicant'    => $txtAapplicant,
    			'remarks' => $txtRemarks,
    			'editor' => $txtEditor
    	);

    	// 插入数据的数据表
    	$table = 'welfarebill';
    	//print_r($row);
    	//exit();
    	//print_r($db);
    	//exit();
    	// 插入数据行并返回行数
    	$rows_affected = $db->insert($table,$row);
    	//print_r($rows_affected);
    	//exit();
    	
    	if ($rows_affected)
    	{
    		echo "<script> alert('提交成功');</script>";
    	}
    	else
    	{
    		echo "<script> alert('提交失败');</script>";
    	}
    	
    	$this->render("addwelfare");
    }
    public function addfundAction()
    {
    	//转到添加发展基金报账的页面
    
    }
    public function addfunddatabaseAction()
    {
    	//提交发展基金数据库
    	date_default_timezone_set('PRC');
    	$txtDate = date("Y-m-d");
    	
    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
    	$txtProjectName = $this->getRequest()->getParam("txtProjectName","");
    	$txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
    	 
    	//选填项内容
    	$txtIncome =  $this->getRequest()->getParam("txtIncome");
    	if (""==$txtIncome)
    	{
    		$txtIncome = 0;
    	}
    	 
    	$txtComputer = $this->getRequest()->getParam("txtComputer");
    	if (""==$txtComputer)
    	{
    		$txtComputer = 0;
    	}
    	$txtDisplay= $this->getRequest()->getParam("txtDisplay");
    	if (""==$txtDisplay)
    	{
    		$txtDisplay = 0;
    	}
    	$txtCamera = $this->getRequest()->getParam("txtCamera");
    	if (""==$txtCamera)
    	{
    		$txtCamera = 0;
    	}
    	$txtFundOthers = $this->getRequest()->getParam("txtFundOthers");
    	if (""==$txtFundOthers)
    	{
    		$txtFundOthers = 0;
    	}
    	 
    	$txtRemarks = $this->getRequest()->getParam("txtRemarks");
    	if (""==$txtRemarks)
    	{
    		$txtRemarks = " ";
    	}
    	
    	$loginuser = $_SESSION['loginuer'][0];
    	$txtEditor = $loginuser['user'];
    	
    	// 调用表模型
    	$itemModel = new FundBill();
    	//print_r($itemModel);
    	//exit();
    	//防注入适配器
    	$db = $itemModel->getAdapter();
    	 
    	// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
    	$row = array (
    			'date'    => $txtDate,
    			'serviceId'     => $txtServiceId,
    			'projectName' => $txtProjectName,
    			 
    			'income'   =>$txtIncome,
    			 
    			'computer'     => $txtComputer,
    			'display' => $txtDisplay,
    			'camera'=>$txtCamera,
    			'fundOthers'    => $txtFundOthers,
    				
    			'applicant'    => $txtAapplicant,
    			'remarks' => $txtRemarks,
    			'editor' => $txtEditor
    	);
    	 
    	// 插入数据的数据表
    	$table = 'fundbill';
    	 
    	//print_r($db);
    	//exit();
    	// 插入数据行并返回行数
    	$rows_affected = $db->insert($table,$row);
    	 
    	 
    	if ($rows_affected)
    	{
    		echo "<script> alert('提交成功');</script>";
    	}
    	else
    	{
    		echo "<script> alert('提交失败');</script>";
    	}
    	 
    	$this->render("addfund");
    }
    public function addmealsAction()
    {
    	//转到添加餐费报账的页面
    
    }
    public function addmealsdatabaseAction()
    {
    	//提交餐费数据库
    	date_default_timezone_set('PRC');
    	$txtDate = date("Y-m-d");
    	
    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
    	$txtProjectName = $this->getRequest()->getParam("txtProjectName","");
    	$txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
    	 
    	//选填项内容
    	$txtIncome =  $this->getRequest()->getParam("txtIncome");
    	if (""==$txtIncome)
    	{
    		$txtIncome = 0;
    	}
    	 
    	$txtMeals = $this->getRequest()->getParam("txtMeals");
    	if (""==$txtMeals)
    	{
    		$txtMeals = 0;
    	}
    	 
    	$txtRemarks = $this->getRequest()->getParam("txtRemarks");
    	if (""==$txtRemarks)
    	{
    		$txtRemarks = " ";
    	}
    	
    	$loginuser = $_SESSION['loginuer'][0];
    	$txtEditor = $loginuser['user'];
    	
    	// 调用表模型
    	$itemModel = new MealsBill();
    	 
    	//防注入适配器
    	$db = $itemModel->getAdapter();
    	 
    	// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
    	$row = array (
    			'date'    => $txtDate,
    			'serviceId'     => $txtServiceId,
    			'projectName' => $txtProjectName,
    			 
    			'income'   =>$txtIncome,
    			 
    			'meals'     => $txtMeals,
    				
    			'applicant'    => $txtAapplicant,
    			'remarks' => $txtRemarks,
    			'editor' => $txtEditor
    	);
    	 
    	// 插入数据的数据表
    	$table = 'mealsbill';
    	 
    	//print_r($db);
    	//exit();
    	// 插入数据行并返回行数
    	$rows_affected = $db->insert($table,$row);
    	 
    	 
    	if ($rows_affected)
    	{
    		echo "<script> alert('提交成功');</script>";
    	}
    	else
    	{
    		echo "<script> alert('提交失败');</script>";
    	}
    	 
    	$this->render("addmeals");
    }
    public function addeducationAction()
    {
    	//转到添加教育培训报账的页面
    
    }
    public function addeducationdatabaseAction()
    {
    	//提交教育培训数据库
    	date_default_timezone_set('PRC');
    	$txtDate = date("Y-m-d");
    	 
    	$txtServiceId = $this->getRequest()->getParam("txtServiceId","");
    	$txtProjectName = $this->getRequest()->getParam("txtProjectName","");
    	$txtAapplicant = $this->getRequest()->getParam("txtAapplicant","");
    	
    	//选填项内容
    	$txtIncome =  $this->getRequest()->getParam("txtIncome");
    	if (""==$txtIncome)
    	{
    		$txtIncome = 0;
    	}
    	
    	$txtEducation = $this->getRequest()->getParam("txtEducation");
    	if (""==$txtEducation)
    	{
    		$txtEducation = 0;
    	}
    	
    	$txtRemarks = $this->getRequest()->getParam("txtRemarks");
    	if (""==$txtRemarks)
    	{
    		$txtRemarks = " ";
    	}
    	 
    	$loginuser = $_SESSION['loginuer'][0];
    	$txtEditor = $loginuser['user'];
    	 
    	// 调用表模型
    	$itemModel = new EducationBill();
    	
    	//防注入适配器
    	$db = $itemModel->getAdapter();
    	
    	// 以"列名"=>"数据"的格式格式构造插入数组,插入数据行
    	$row = array (
    			'date'    => $txtDate,
    			'serviceId'     => $txtServiceId,
    			'projectName' => $txtProjectName,
    	
    			'income'   =>$txtIncome,
    	
    			'education'     => $txtEducation,
    	
    			'applicant'    => $txtAapplicant,
    			'remarks' => $txtRemarks,
    			'editor' => $txtEditor
    	);
    	
    	// 插入数据的数据表
    	$table = 'educationbill';
    	
    	//print_r($db);
    	//exit();
    	// 插入数据行并返回行数
    	$rows_affected = $db->insert($table,$row);
    	
    	
    	if ($rows_affected)
    	{
    		echo "<script> alert('提交成功');</script>";
    	}
    	else
    	{
    		echo "<script> alert('提交失败');</script>";
    	}
    	
    	$this->render("addeducation");
    }
}


