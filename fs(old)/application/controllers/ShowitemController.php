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

require_once APPLICATION_PATH.'/models/Classes/PHPExcel.php';
require_once APPLICATION_PATH.'/models/Myexcel.php';




class ShowitemController extends BaseController
{
	public function indexAction()
	{
		//实例化模型
		$itemModel = new Item();
		
		//防注入适配器
		//$db = $itemModel->getAdapter();	
		
		//选择语句//由于不需要最前面的序号，所以这里要将选择的字段列出来
		//$select = $db->select();
		//$select->from('projectbill',array('date','serviceId','projectName','make','travel','costOthers','meals','welfareOthers','computer','display','camera','fundOthers','applicant','remarks'));
		//$sql = 'SELECT date,serviceId,projectName,make,travel,costOthers,meals,welfareOthers,computer,display,camera,fundOthers,applicant,remarks FROM projectbill WHERE 1';
		
		//取出数据
		//$item = $db->fetchAll($select);
		$item = $itemModel->fetchAll()->toArray();
		
		session_start();
		$_SESSION['exportdata'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);		
		
		$this->view->item = $itemOutput;
		

		$this->render("index");
	}
	
	public function showcostAction()
	{
		//实例化模型
		$itemModel = new CostBill();
		$db = $itemModel->getAdapter();
		
		$sql = 'SELECT a.id,date,serviceId,projectName,income,make,travel,waterElec,costOthers,b.balance as balance,applicant,remarks,editor,b.costIsAlarm as costAlarm,b.makeIsAlarm as makeAlarm,b.travelIsAlarm as travelAlarm FROM costbill as a,costbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		
		$result = $db->query($sql);	
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exportcost'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		
		
		$this->render("showcost");
	}

	public function showwelfareAction()
	{
		//实例化模型
		$itemModel = new WelfareBill();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT a.id,date,serviceId,projectName,income,welfare,b.balance as balance,applicant,remarks,editor FROM welfarebill as a,welfarebalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		$sql = 'SELECT a.id,date,serviceId,projectName,income,welfare,b.balance as balance,applicant,remarks,editor,b.welfareIsAlarm as alarm FROM welfarebill as a,welfarebalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		$result = $db->query($sql);	
		
		$item = $result->fetchAll();
		//print_r($item);
		//exit();
		session_start();
		$_SESSION['exportwelfare'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		

		$this->render("showwelfare");
	}
	public function showfundAction()
	{
		//实例化模型
		$itemModel = new FundBill();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT a.id,date,serviceId,projectName,income,computer,display,camera,fundOthers,b.balance as balance,applicant,remarks,editor FROM fundbill as a,fundbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		$sql = 'SELECT a.id,date,serviceId,projectName,income,computer,display,camera,fundOthers,b.balance as balance,applicant,remarks,editor,b.fundIsAlarm as alarm FROM fundbill as a,fundbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		
		$result = $db->query($sql);	
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exportfund'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		
		$this->render("showfund");
	}
	public function showmealsAction()
	{
		//实例化模型
		$itemModel = new MealsBill();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT a.id,date,serviceId,projectName,income,meals,b.balance as balance,applicant,remarks,editor FROM mealsbill as a,mealsbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		$sql = 'SELECT a.id,date,serviceId,projectName,income,meals,b.balance as balance,applicant,remarks,editor,b.mealsIsAlarm as alarm FROM mealsbill as a,mealsbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		
		$result = $db->query($sql);	
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exportmeals'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		
		
		$this->render("showmeals");
	}
	public function showeducationAction()
	{
		//实例化模型
		$itemModel = new EducationBill();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT a.id,date,serviceId,projectName,income,education,b.balance as balance,applicant,remarks,editor FROM educationbill as a,educationbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		$sql = 'SELECT a.id,date,serviceId,projectName,income,education,b.balance as balance,applicant,remarks,editor,b.educationIsAlarm as alarm FROM educationbill as a,educationbalance as b  WHERE a.id=b.foreign_id order by a.id desc';
		
		$result = $db->query($sql);	
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exporteducation'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		
		
		$this->render("showeducation");
	}
	
	public function showtotalvalueAction()
	{
		//实例化模型
		$itemModel = new Totalvalue();
	
		$db = $itemModel->getAdapter();
	
		//$sql = 'SELECT id,date,totalValue,editDate FROM (select * from totalvalue where 1 ORDER BY LEFT(date,4) desc,id DESC)a  WHERE 1 GROUP BY LEFT(date,4) ORDER BY LEFT(date,4) desc';
		$sql = 'SELECT id,date,totalValue,editDate FROM totalvalue order by id desc';
		$result = $db->query($sql);
	
		$item = $result->fetchAll();
	
		session_start();
		$_SESSION['exporttotalvalue'] = $item;
	
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
	
		$this->view->item = $itemOutput;
	
	
		$this->render("showtotalvalue");
	}
	public function showdesignmoneyAction()
	{
		//echo 'wait';
		//exit();
		$statisticsType = $this->getRequest()->getParam("statisticsType");
		//echo ($statisticsType);
		//exit();
		/*
		if("sumbyservice" == $statisticsType)
		{
			//$sql = 'SELECT id,date,serviceId,projectName,SUM(money) AS money FROM designmoney where 1 group by serviceId order by id desc';
			$sql = 'SELECT date,serviceId,projectName,SUM(money) AS money,(totalContract - money) AS restMoney FROM
					(
					SELECT date,serviceId,projectName,SUM(money) AS money,SUM(0) AS totalContract FROM designmoney where 1 group by serviceId 
					UNION ALL
			SELECT 0 as date,serviceId,0 as projectName,SUM(0) AS money,totalContract FROM totalcontract ORDER BY serviceId
					)a
					GROUP BY serviceId
					ORDER BY date DESC
					';
			$showType = "sumbyservice";
		}
		*/
		if("showonebyone" == $statisticsType)
		{
			$sql = 'SELECT id,date,serviceId,projectName,money FROM designmoney order by id desc';
			$showType = "showonebyone";
		}
		else 
		{
			//$sql = 'SELECT id,date,serviceId,projectName,SUM(money) AS money FROM designmoney where 1 group by serviceId order by id desc';
			/*
			$sql = 'SELECT date,serviceId,projectName,SUM(money) AS money,(totalContract - money) AS restMoney FROM
					(
					SELECT date,serviceId,projectName,SUM(money) AS money,SUM(0) AS totalContract FROM designmoney where 1 group by serviceId
					UNION ALL
			SELECT 0 as date,serviceId,0 as projectName,SUM(0) AS money,totalContract FROM totalcontract ORDER BY serviceId
					)a
					GROUP BY serviceId
					ORDER BY date DESC
					';
			*/
			$sql = 'SELECT date,serviceId,projectName,SUM(money) AS money,(SUM(totalContract) - SUM(money)) AS restMoney FROM
					(
					SELECT date,serviceId,projectName,SUM(money) AS money,SUM(0) AS totalContract FROM
					(SELECT * FROM designmoney ORDER BY date DESC)a
					WHERE 1 GROUP BY serviceId
					UNION ALL
					SELECT signDate as date,serviceId,projectName,0 AS money,totalContract FROM totalcontract WHERE 1 ORDER BY serviceId
					)b
					GROUP BY serviceId
					ORDER BY date DESC';
			$showType = "sumbyservice";
		}
		//echo ($sql);
		//exit();
		$itemModel = new Designmoney();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT id,date,totalValue,editDate FROM (select * from totalvalue where 1 ORDER BY LEFT(date,4) desc,id DESC)a  WHERE 1 GROUP BY LEFT(date,4) ORDER BY LEFT(date,4) desc';
		//$sql = 'SELECT id,date,serviceId,projectName,money FROM designmoney order by id desc';
		$result = $db->query($sql);
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exportDesignmoney'] = $item;
		$_SESSION['exportDesignmoneyType'] = $showType;
		
		//print_r($item);
		//exit();
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		$this->view->showtype = $showType;
		//$this->view->strContract = "合同签订时间";
		//$this->view->strMoney = "收款时间";
		
		
		
		$this->render("showdesignmoney");
	}
	public function choosedesignmoneyAction()
	{
		/*
		$itemModel = new Designmoney();
	
		$db = $itemModel->getAdapter();
	
		//$sql = 'SELECT id,date,totalValue,editDate FROM (select * from totalvalue where 1 ORDER BY LEFT(date,4) desc,id DESC)a  WHERE 1 GROUP BY LEFT(date,4) ORDER BY LEFT(date,4) desc';
		//$sql = 'SELECT id,date,serviceId,projectName,money FROM designmoney where 1 order by id desc';
		$sql = 'SELECT id,date,serviceId,projectName,SUM(money) AS money FROM designmoney where 1 group by serviceId order by id desc';
		$result = $db->query($sql);
	
		$item = $result->fetchAll();
	
		//session_start();
		//$_SESSION['exportDesignmoney'] = $item;
	
		//print_r($item);
		//exit();
	
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
	
		$this->view->item = $itemOutput;
		
		//echo 'd';
		//exit();
		  */
		 
		$this->render("choosedesignmoney");
	}
	public function showcontractAction()
	{
		//echo 'contract';
		//exit();
		//实例化模型
		$itemModel = new Totalcontract();
		
		$db = $itemModel->getAdapter();
		
		//$sql = 'SELECT id,date,totalValue,editDate FROM (select * from totalvalue where 1 ORDER BY LEFT(date,4) desc,id DESC)a  WHERE 1 GROUP BY LEFT(date,4) ORDER BY LEFT(date,4) desc';
		$sql = 'SELECT id,serviceId,projectName,signDate,totalContract FROM totalcontract order by id desc';
		$result = $db->query($sql);
		
		$item = $result->fetchAll();
		
		session_start();
		$_SESSION['exporttoalContract'] = $item;
		
		//print_r($item);
		//exit();
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
		
		$this->view->item = $itemOutput;
		
		
		$this->render("showcontract");
	}
	
//=========================================================================================	
	// 导出excel的动作
	
	
	
	public function exportexcelAction()
	{
		session_start();
		
		$dataArray = $_SESSION['exportdata'];
		
		$excelModel = new Myexcel();
		$excelModel->init("B2","R3");

		$excelModel->setGridFont();
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B3:R3');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('R',10);
		//导出保存
		$excelModel->saveExcel(1);
	}
	public function exportcostAction()
	{

		$dataArray = $_SESSION['exportcost'];		
		
		$excelModel = new Myexcel();
		
		$excelModel->getActiveSheet()->setTitle('成本统计情况');
		$excelModel->init("B2","L2");
	
		$excelModel->setGridFont("成本");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:K2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('L',10);
		//导出保存
		
		$excelModel->saveExcel(1,"成本统计情况");
	}
	public function exportwelfareAction()
	{
	
		$dataArray = $_SESSION['exportwelfare'];
	
		$excelModel = new Myexcel();
	
		$excelModel->getActiveSheet()->setTitle('福利统计情况');
		$excelModel->init("B2","I2");
	
		$excelModel->setGridFont("福利");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:H2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('I',10);
		//导出保存
	
		$excelModel->saveExcel(1,"福利统计情况");
	}
	public function exportfundAction()
	{
		$dataArray = $_SESSION['exportfund'];
		
		$excelModel = new Myexcel();
		
		$excelModel->getActiveSheet()->setTitle('发展基金统计情况');
		$excelModel->init("B2","L2");
		
		$excelModel->setGridFont("发展基金");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:K2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		//$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('L',10);
		//导出保存
		
		$excelModel->saveExcel(1,"发展基金统计情况");
	}
	public function exportmealsAction()
	{
		$dataArray = $_SESSION['exportmeals'];
		
		$excelModel = new Myexcel();
		
		$excelModel->getActiveSheet()->setTitle('餐费统计情况');
		$excelModel->init("B2","I2");
		
		$excelModel->setGridFont("餐费");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:H2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('I',10);
		//导出保存
		
		$excelModel->saveExcel(1,"餐费统计情况");
	}
	public function exporteducationAction()
	{
		$dataArray = $_SESSION['exporteducation'];
		
		$excelModel = new Myexcel();
		
		$excelModel->getActiveSheet()->setTitle('教育培训费统计情况');
		$excelModel->init("B2","I2");
		
		$excelModel->setGridFont("教育培训费");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:H2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('I',10);
		//导出保存
		
		$excelModel->saveExcel(1,"教育培训费统计情况");
	}
	
	public function exporttotalvalueAction()
	{
		$dataArray = $_SESSION['exporttotalvalue'];
	
		$excelModel = new Myexcel();
	
		$excelModel->getActiveSheet()->setTitle('年度总产值统计情况');
		$excelModel->init("B2","D2");
	
		$excelModel->setGridFont("年度总产值");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:D2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('E',10);
		//导出保存
	
		$excelModel->saveExcel(1,"年度总产值统计情况");
	}
	public function exportdesignmoneyAction()
	{
		//$statisticsType = $this->getRequest()->getParam("statisticsType");
		//echo ($statisticsType);/ "sumbyservice";
		//if("showonebyone" == $statisticsType)
		//exit();
		$showtype = $_SESSION['exportDesignmoneyType'];
		$dataArray = $_SESSION['exportDesignmoney'];

		$excelModel = new Myexcel();
		if("showonebyone" == $showtype)
		{
			$excelModel->getActiveSheet()->setTitle('设计费统计情况');
			$excelModel->init("B2","E2");
	
			$excelModel->setGridFont("设计费收入细目");
			//添加筛选
			$excelModel->getActiveSheet()->setAutoFilter('B2:E2');
			//插入数据
			$excelModel->insertData($dataArray);
			//去除多余的列
			$excelModel->getActiveSheet()->removeColumn('A',1);
			$excelModel->getActiveSheet()->removeColumn('F',10);
			//导出保存
			$excelModel->saveExcel(1,"设计费收入细目情况");
		}
		else 
		{
			$excelModel->getActiveSheet()->setTitle('设计费统计情况');
			$excelModel->init("A2","E2");
			
			$excelModel->setGridFont("设计费收入统计");
			//添加筛选
			$excelModel->getActiveSheet()->setAutoFilter('A2:E2');
			//插入数据
			$excelModel->insertData($dataArray);
			//去除多余的列
			//$excelModel->getActiveSheet()->removeColumn('A',1);
			$excelModel->getActiveSheet()->removeColumn('F',10);
			//导出保存
			$excelModel->saveExcel(1,"设计费收入统计情况");
		}
		
	}
	public function exportcontractAction()
	{
		$dataArray = $_SESSION['exporttoalContract'];
		
		$excelModel = new Myexcel();
		
		$excelModel->getActiveSheet()->setTitle('合同总额统计情况');
		$excelModel->init("B2","E2");
		
		$excelModel->setGridFont("合同总额");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('B2:E2');
		//插入数据
		$excelModel->insertData($dataArray);
		//去除多余的列
		$excelModel->getActiveSheet()->removeColumn('A',1);
		$excelModel->getActiveSheet()->removeColumn('F',10);
		//导出保存
		
		$excelModel->saveExcel(1,"合同总额统计情况");
	}
}