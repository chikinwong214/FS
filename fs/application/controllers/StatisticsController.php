<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Item.php';
require_once APPLICATION_PATH.'/models/Classes/PHPExcel.php';
require_once APPLICATION_PATH.'/models/Myexcel.php';

require_once APPLICATION_PATH.'/models/CostBill.php';
require_once APPLICATION_PATH.'/models/WelfareBill.php';
require_once APPLICATION_PATH.'/models/FundBill.php';
require_once APPLICATION_PATH.'/models/MealsBill.php';
require_once APPLICATION_PATH.'/models/EducationBill.php';

class StatisticsController extends BaseController
{
	public function indexAction()
	{
		
		$itemModel = new CostBill();
		
		$db = $itemModel->getAdapter();
		
		//多表联合查询年份
		$sql = "
				SELECT year FROM				
				(
				SELECT LEFT(date,4) AS year
				FROM `costbill`
				WHERE 1
				 
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `educationbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `fundbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `mealsbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `welfarebill`
				WHERE 1 	
				)a  
				WHERE 1
				ORDER BY year DESC			
				";
		
		$result = $db->query($sql);		
		$year = $result->fetchAll();
		
		$this->view->year = $year;
		
		$this->render("index");
	}
	
	public function handleAction()
	{
		$statisticsType = $this->getRequest()->getParam("statisticsType");
		$year = $this->getRequest()->getParam("year");
		
		if ("year" == $statisticsType) 
		{
			$condition = 'LEFT(date,4)';
			$where = '1';
		}
		elseif ("month" == $statisticsType) 
		{
			if ("all" == $year) 
			{
				$condition = "LEFT(date,7)";
				$where = "1";
			}
			else 
			{
				$condition = "LEFT(date,7)";
				$where = "LEFT(date,4) = $year ";
			}
		}
		else 
		{
			$condition = 'LEFT(date,4)';
			$where = '1';
		}
		
		 
		
		//实例化模型
		$itemModel = new CostBill();
		
		$db = $itemModel->getAdapter();
		
		//多表查询联合后求和
		$sql = "SELECT 
				$condition AS date,
				SUM(make) AS make,
				SUM(travel) AS travel,
				SUM(waterElec) AS waterElec,
				SUM(costOthers) AS costOthers,
				SUM(welfare) AS welfare,
				SUM(computer) AS computer,
				SUM(display) AS display,
				SUM(camera) AS camera,
				SUM(fundOthers) AS fundOthers,
				SUM(meals) AS meals,
				SUM(education) AS education
		 		FROM
				(
				SELECT $condition AS date,
				SUM(make) AS make,
				SUM(travel) AS travel,
				SUM(waterElec) AS waterElec,
				SUM(costOthers) AS costOthers,				
				SUM(0) AS welfare,
				SUM(0) AS computer,
				SUM(0) AS display,
				SUM(0) AS camera,
				SUM(0) AS fundOthers, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `costbill` 
				WHERE $where 
				GROUP BY $condition 
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS make,
				SUM(0) AS travel,
				SUM(0) AS waterElec,
				SUM(0) AS costOthers,				
				SUM(welfare) AS welfare,
				SUM(0) AS computer,
				SUM(0) AS display,
				SUM(0) AS camera,
				SUM(0) AS fundOthers, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `welfarebill` 
				WHERE $where 
				GROUP BY $condition
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS make,
				SUM(0) AS travel,
				SUM(0) AS waterElec,
				SUM(0) AS costOthers,				
				SUM(0) AS welfare,
				SUM(computer) AS computer,
				SUM(display) AS display,
				SUM(camera) AS camera,
				SUM(fundOthers) AS fundOthers, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `fundbill` 
				WHERE $where 
				GROUP BY $condition
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS make,
				SUM(0) AS travel,
				SUM(0) AS waterElec,
				SUM(0) AS costOthers,				
				SUM(0) AS welfare,
				SUM(0) AS computer,
				SUM(0) AS display,
				SUM(0) AS camera,
				SUM(0) AS fundOthers, 
				SUM(meals) AS meals,
				SUM(0) AS education
				FROM `mealsbill` 
				WHERE $where 
				GROUP BY $condition
			
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS make,
				SUM(0) AS travel,
				SUM(0) AS waterElec,
				SUM(0) AS costOthers,				
				SUM(0) AS welfare,
				SUM(0) AS computer,
				SUM(0) AS display,
				SUM(0) AS camera,
				SUM(0) AS fundOthers, 
				SUM(0) AS meals,
				SUM(education) AS education
				FROM `educationbill` 
				WHERE $where 
				GROUP BY $condition 
				ORDER BY $condition DESC				
				)a
				GROUP BY $condition 
				ORDER BY $condition DESC

				";	
		
		$result = $db->query($sql);
		
		$item = $result->fetchAll();
		
		//print_r($item);
		//exit();
		
		session_start();
		$_SESSION['statisticsData'] = $item;
		
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);		
		
		$this->view->item = $itemOutput;
		
		//print_r($item);
		//exit();
		
		$this->render("handle");
	}
	
	public function exportexcelAction()
	{
		session_start();
	
		$dataArray = $_SESSION['statisticsData'];
	
		$excelModel = new Myexcel();
		$excelModel->init("B2","Q3");
		$excelModel->setGridFont();
		
		$excelModel->getActiveSheet()->setTitle('统计情况');
		$excelModel->getActiveSheet()->removeColumn('D',1);
		$excelModel->getActiveSheet()->removeColumn('C',1);		
		$excelModel->getActiveSheet()->removeColumn('A',1);
		
		$excelModel->getActiveSheet()->unmergeCells('B2:B3');
		
		$excelModel->getActiveSheet()->mergeCells('B2:E2');
		$excelModel->getActiveSheet()->setCellValue('B2',"成本（元）");
		$excelModel->getActiveSheet()->setCellValue('B3',"制作");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('A3:L3');
		
		//$excelModel->insertData($dataArray);
		$excelModel->getActiveSheet()->fromArray($dataArray, NULL, 'A4');
		
		$excelModel->getActiveSheet()->removeColumn('M',10);
		
		$excelModel->saveExcel(1,"统计开支情况");
	}
	
	public function statisticsuiAction()
	{
		
	}
	
	public function graphuiAction()
	{
		$itemModel = new CostBill();
		
		$db = $itemModel->getAdapter();
		
		//多表联合查询年份
		$sql = "
				SELECT year FROM				
				(
				SELECT LEFT(date,4) AS year
				FROM `costbill`
				WHERE 1
				 
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `educationbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `fundbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `mealsbill`
				WHERE 1 
				
				UNION
				
				SELECT LEFT(date,4) AS year
				FROM `welfarebill`
				WHERE 1 	
				)a  
				WHERE 1
				ORDER BY year DESC			
				";
		$result = $db->query($sql);
		$year = $result->fetchAll();
		
		$this->view->year = $year;
		
		$this->render("graphui");
	}
	
	public function graphAction()
	{
		$year = $this->getRequest()->getParam("year");
		
		if ("" == $year) 
		{
			date_default_timezone_set('PRC');
			$date=date("Y-m-d H:i:s");
			$year = substr($date,0,4);
		}
		
		$condition = "LEFT(date,4)";
		$where = "LEFT(date,4) = $year ";
		
		//实例化模型
		$itemModel = new CostBill();
		
		$db = $itemModel->getAdapter();
		
		$sql = "
				SELECT 
				$condition AS date,
				SUM(cost) AS cost,				
				SUM(welfare) AS welfare,
				SUM(fund) AS fund,				
				SUM(meals) AS meals,
				SUM(education) AS education
		 		FROM
				(
				SELECT $condition AS date,
				(SUM(make)+SUM(travel)+SUM(waterElec)+SUM(costOthers)) AS cost,							
				SUM(0) AS welfare,				
				SUM(0) AS fund, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `costbill` 
				WHERE $where 
				GROUP BY $condition 
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS cost,								
				SUM(welfare) AS welfare,				
				SUM(0) AS fund, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `welfarebill` 
				WHERE $where 
				GROUP BY $condition
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS cost,			
				SUM(0) AS welfare,
				(SUM(computer)+SUM(display)+SUM(camera)+SUM(fundOthers)) AS fund, 
				SUM(0) AS meals,
				SUM(0) AS education
				FROM `fundbill` 
				WHERE $where 
				GROUP BY $condition
				
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS cost,				
				SUM(0) AS welfare,
				SUM(0) AS fund, 
				SUM(meals) AS meals,
				SUM(0) AS education
				FROM `mealsbill` 
				WHERE $where 
				GROUP BY $condition
			
				UNION ALL
				
				SELECT $condition AS date,
				SUM(0) AS cost,			
				SUM(0) AS welfare,
				SUM(0) AS fund, 
				SUM(0) AS meals,
				SUM(education) AS education
				FROM `educationbill` 
				WHERE $where 
				GROUP BY $condition 
				ORDER BY $condition DESC				
				)a
				GROUP BY $condition 
				ORDER BY $condition DESC
		
				";
		
		$result = $db->query($sql);
		
		$item = $result->fetchAll();
		
		foreach ($item[0] as &$value)
		{
			if ("" == $value || null == $value) 
			{
				$value = 0;
			}
		}
		
		$show = array_values($item[0]);	
		
		$this->view->item = $show;
		
		$this->render("graph");
	}
	
	
	//=================业务号统计情况=============================================//
	
	public function sidindexAction()
	{
		$itemModel = new CostBill();
	
		$db = $itemModel->getAdapter();
		$sql = "
				SELECT serviceId FROM				
				(
				SELECT serviceId
				FROM `costbill`
				WHERE 1
				GROUP BY serviceId
							 
				UNION 
				
				SELECT serviceId
				FROM `mealsbill`
				WHERE 1 
				GROUP BY serviceId				
				
				)a  
				WHERE 1
				ORDER BY serviceId DESC
				";
	
		$result = $db->query($sql);
		$serviceId = $result->fetchAll();
		
		$this->view->serviceId = $serviceId;
	
				
		//多表联合查询年份
		$sql = "
				SELECT year FROM				
				(
				SELECT LEFT(date,4) AS year
				FROM `costbill`
				WHERE 1
				 
				UNION	
				
				SELECT LEFT(date,4) AS year
				FROM `mealsbill`
				WHERE 1 
				)a  
				WHERE 1
				ORDER BY year DESC			
				";
	
		$result = $db->query($sql);
		$year = $result->fetchAll();
	
		$this->view->year = $year;
	
		$this->render("sidindex");
	}
	
	public function sidhandleAction()
	{
		$serviceId = $this->getRequest()->getParam("serviceId");
		$statisticsType = $this->getRequest()->getParam("statisticsType");
		$year = $this->getRequest()->getParam("year");
	
		if ("all" == $serviceId || "" == $serviceId)
		{
			$where = "1";
		}
		else
		{
			$where = "serviceId = \"$serviceId\" ";
		}
	
		if ("year" == $statisticsType)
		{
			$condition = 'LEFT(date,4)';
		}
		elseif ("month" == $statisticsType)
		{
			if ("all" == $year)
			{
				$condition = "LEFT(date,7)";
			}
			else
			{
				$condition = "LEFT(date,7)";
				$where .= " AND LEFT(date,4) = $year ";
			}
		}
		else
		{
			$condition = 'LEFT(date,4)';
		}
	
	
		//实例化模型
		$itemModel = new CostBill();
	
		$db = $itemModel->getAdapter();
	
		$sql = "				
				SELECT 
				$condition AS date,
				serviceId,
				SUM(make) AS make,
				SUM(travel) AS travel,				
				SUM(meals) AS meals
		 		FROM
				(
				SELECT $condition AS date,
				serviceId,
				SUM(make) AS make,
				SUM(travel) AS travel,				
				SUM(0) AS meals
				FROM `costbill` 
				WHERE $where 
				GROUP BY serviceId,$condition 
				
				UNION ALL
				
				SELECT $condition AS date,
				serviceId,
				SUM(0) AS make,
				SUM(0) AS travel,				
				SUM(meals) AS meals
				FROM `mealsbill` 
				WHERE $where 
				GROUP BY serviceId,$condition
				ORDER BY serviceId DESC,$condition DESC
				)a
				WHERE 1
				GROUP BY serviceId,$condition
				ORDER BY serviceId DESC,$condition DESC
				";
	
	
		$result = $db->query($sql);
	
		$item = $result->fetchAll();
	
		session_start();
		$_SESSION['serviceData'] = $item;
	
		//对数据进行处理，变成ligerui表格需要的格式
		$itemOutput = json_encode($item);
	
		$this->view->item = $itemOutput;
	
		$this->render("sidhandle");
	}
	
	public function sidexportexcelAction()
	{
		session_start();
		$dataArray = $_SESSION['serviceData'];

		$excelModel = new Myexcel();
		$excelModel->init("A1","E1");
		$excelModel->getActiveSheet()->removeColumn('A',20);

		$excelModel->getActiveSheet()->setTitle('业务号统计情况');

		$excelModel->getActiveSheet()->setCellValue('A1',"报账时间");
		$excelModel->getActiveSheet()->setCellValue('B1',"业务号");
		$excelModel->getActiveSheet()->setCellValue('C1',"制作费");
		$excelModel->getActiveSheet()->setCellValue('D1',"差旅费");
		$excelModel->getActiveSheet()->setCellValue('E1',"餐费");
		//添加筛选
		$excelModel->getActiveSheet()->setAutoFilter('A1:E1');

		$excelModel->getActiveSheet()->fromArray($dataArray, NULL, 'A2');


		$excelModel->saveExcel(1,"业务号统计情况");
	
	}
	
		//=========业务号统计图表界面============================//
	public function sidgraphuiAction()
	{
		$itemModel = new CostBill();
	
		$db = $itemModel->getAdapter();
		$sql = "
				SELECT LEFT(serviceId,4) AS serviceId
				FROM 
				(
				SELECT LEFT(serviceId,4) AS serviceId
				FROM `costbill`
				WHERE 1
				GROUP BY LEFT(serviceId,4)
				 
				UNION
				
				SELECT LEFT(serviceId,4) AS serviceId
				FROM `mealsbill`
				WHERE 1 
				GROUP BY LEFT(serviceId,4)
				)a
				WHERE 1				
				ORDER BY LEFT(serviceId,4) DESC
				";
	
		$result = $db->query($sql);
		$serviceId = $result->fetchAll();
		
		$this->view->serviceId = $serviceId;
	
		$this->render("sidgraphui");
	}
	
	public function sidgraphAction()
	{
		$serviceId = $this->getRequest()->getParam("serviceId");
	
		if ("" == $serviceId)
		{
			date_default_timezone_set('PRC');
			$date = date("Y-m-d H:i:s");
			$serviceId = substr($date,0,4);
		}
	
		$where = "LEFT(serviceId,4) = \"$serviceId\" ";

		//实例化模型
		$itemModel = new CostBill();

		$db = $itemModel->getAdapter();

		$sql = "
				SELECT
				serviceIdRight,
				SUM(make) AS make,
				SUM(travel) AS travel,
				SUM(meals) AS meals
				FROM 
				(
				SELECT 
				substring(serviceId,6) AS serviceIdRight,
				SUM(make) AS make,
				SUM(travel) AS travel,				
				SUM(0) AS meals
				FROM `costbill` 
				WHERE $where 
				GROUP BY serviceIdRight 
				
				UNION ALL
				
				SELECT 
				substring(serviceId,6) AS serviceIdRight,
				SUM(0) AS make,
				SUM(0) AS travel,				
				SUM(meals) AS meals
				FROM `mealsbill` 
				WHERE $where 
				GROUP BY serviceIdRight
				ORDER BY serviceIdRight DESC
				)a
				WHERE 1
				GROUP BY serviceIdRight
				ORDER BY serviceIdRight
				";

		$result = $db->query($sql);

		$item = $result->fetchAll();

		$datax = array();
		$make = array();
		$travel = array();
		$meals = array();

		foreach ($item as $value)
		{
			array_push($datax, $value['serviceIdRight']);
			array_push($make, $value['make']);
			array_push($travel, $value['travel']);
			array_push($meals, $value['meals']);
				
		}
		/*
		print_r($datax);
		print_r($make);
		print_r($travel);
		print_r($meals);
		exit();*/

		//$this->view->item = json_encode($item);
		$this->view->datax = json_encode($datax);
		$this->view->make = $make;
		$this->view->travel = $travel;
		$this->view->meals = $meals;
		$this->view->serviceId = $serviceId;

		$this->render("sidgraph");
	}
	
}