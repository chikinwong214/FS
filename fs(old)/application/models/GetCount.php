<?php
require_once APPLICATION_PATH.'/models/Item.php';
require_once APPLICATION_PATH.'/models/Totalvalue.php';
require_once APPLICATION_PATH.'/models/Designmoney.php';
require_once APPLICATION_PATH.'/models/Billthreshold.php';
require_once APPLICATION_PATH.'/models/CostBill.php';

function getCountFiveItem($ServiceId)
{

	//$condition = $SeverviceId;
	$where = "serviceId = \"$ServiceId\" ";

		
	//实例化模型
	$itemModel = new Item();

	$db = $itemModel->getAdapter();
	
	$sql = "
	SELECT  serviceId,
	ROUND(SUM(make)+SUM(travel)+SUM(waterElec)+SUM(costOthers),2) AS cost,
	ROUND(SUM(welfare),2) AS welfare,
	ROUND(SUM(computer)+SUM(display)+SUM(camera)+SUM(fundOthers),2) AS fund,
	ROUND(SUM(meals),2) AS meals,
	ROUND(SUM(education),2) AS education
	FROM `projectbill`
	WHERE $where
	GROUP BY serviceId
	ORDER BY serviceId DESC
	";
	
	
	$result = $db->query($sql);
	$item = $result->fetchAll();
	
	//session_start();
	//$_SESSION['statisticsData'] = $item;
	
		//对数据进行处理，变成ligerui表格需要的格式
	//$itemOutput = json_encode($item);
	return $item;
	

}
function getCountMakeAndTravel($ServiceId)
{
	$where = "serviceId = \"$ServiceId\" ";
	
	
	//实例化模型
	$itemModel = new Item();
	
	$db = $itemModel->getAdapter();
	
	$sql = "
	SELECT  serviceId,
	ROUND(SUM(make),2) AS make,
	ROUND(SUM(travel),2) AS travel
	FROM `projectbill`
	WHERE $where
	GROUP BY serviceId
	ORDER BY serviceId DESC
	";
	
	
	$result = $db->query($sql);
	$item = $result->fetchAll();
	
	//session_start();
	//$_SESSION['statisticsData'] = $item;
	
	//对数据进行处理，变成ligerui表格需要的格式
	//$itemOutput = json_encode($item);
	return $item;
}
function getTotalValue()
{
	$totalModel = new Totalvalue();
	
	$db = $totalModel->getAdapter();
	
	$sql = "SELECT * FROM totalvalue ORDER BY id DESC LIMIT 1";
	
	$result = $db->query($sql);
	
	$totalvalue = $result->fetchAll();
	
	return $totalvalue;
}
function getCountDesignMoney($ServiceId)
{
	$where = "serviceId = \"$ServiceId\" ";
	// 调用表模型
	$itemModel = new Designmoney();
	
	//防注入适配器
	$db = $itemModel->getAdapter();
	
	$sql = "
	SELECT  serviceId,
	ROUND(SUM(money),2) AS money
	FROM `designmoney`
	WHERE $where
	GROUP BY serviceId
	ORDER BY serviceId DESC
	";
	
	
	$result = $db->query($sql);
	$item = $result->fetchAll();
	
	//session_start();
	//$_SESSION['statisticsData'] = $item;
	
	//对数据进行处理，变成ligerui表格需要的格式
	//$itemOutput = json_encode($item);
	return $item;
	
}
function getThreshold()
{
	$thresholdModel = new Billthreshold();
	
	$db = $thresholdModel->getAdapter();
	
	$sql = "SELECT * FROM billthreshold ORDER BY id DESC LIMIT 1";
	
	$result = $db->query($sql);
	
	$threshold = $result->fetchAll();
	
	return $threshold;
}


function getExceedItem($ServiceId)
{
	$threshold        = getThreshold();
	$countFiveItem    = getCountFiveItem($ServiceId);
	$totalValue       = getTotalValue();
	$countMakeTravel  = getCountMakeAndTravel($ServiceId);
	$countDesignMoney = getCountDesignMoney($ServiceId);
	
	//print_r($threshold);
	//print_r($countFiveItem);
	//print_r($totalValue);
	
	
	$exceedItem['hasExceedItem'] = "0";
	$exceedItem['cost']          = "0";
	$exceedItem['welfare']       = "0";
	$exceedItem['fund']          = "0";
	$exceedItem['meals']         = "0";
	$exceedItem['education']     = "0";
	$exceedItem['make']          = "0";
	$exceedItem['travel']        = "0";
	$str  =  "";
	$needToEcho = 0;

	
	if( $countFiveItem[0]['cost'] > ($threshold[0]['cost']*$totalValue[0]['totalValue']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['cost']          = "1";
		//$str .= "成本超出阈值范围!" ;
		//$needToEcho = 1;
	}
	if($countFiveItem[0]['welfare'] > ($threshold[0]['welfare']*$totalValue[0]['totalValue']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['welfare']       = "1";
		//$str .= "\\n福利超出阈值范围!" ;
		//$needToEcho = 1;
	}
	if($countFiveItem[0]['fund'] > ($threshold[0]['fund']*$totalValue[0]['totalValue']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['fund']          = "1";
		//$str .= "\\n发展基金超出阈值范围!" ;
		//$needToEcho = 1;
	}
	if($countFiveItem[0]['meals'] > ($threshold[0]['meals']*$totalValue[0]['totalValue']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['meals']         = "1";
		//$str .= "\\n餐费超出阈值范围!" ;
		//$needToEcho = 1;
	}
	if($countFiveItem[0]['education'] > ($threshold[0]['education']*$totalValue[0]['totalValue']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['education']     = "1";
		//$str .= "\\n教育培训超出阈值范围!" ;
		//$needToEcho = 1;
	}
	
	if($countMakeTravel[0]['make'] > ($threshold[0]['make']*$countDesignMoney[0]['money']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['make']          = "1";
		
		//$str .= "\\n制作费超出阈值范围!" ;
		//$needToEcho = 1;
	}
	if($countMakeTravel[0]['travel'] > ($threshold[0]['travel']*$countDesignMoney[0]['money']))
	{
		$exceedItem['hasExceedItem'] = "1";
		$exceedItem['travel']          = "1";
		//$str .= "\\n差旅费超出阈值范围!" ;
		//$needToEcho = 1;
	}
	return $exceedItem;
}

function getBalance()
{
	$itemDesignMoney = new Designmoney();
	
	//防注入适配器
	$dbDesignMoney = $itemDesignMoney->getAdapter();
	
	$sqlDesignMoney = "
	SELECT  
	ROUND(SUM(money),2) AS money
	FROM `designmoney`
	";
	
	$resultDesignMoney = $dbDesignMoney->query($sqlDesignMoney);
	$DesignMoney = $resultDesignMoney->fetchAll();
	//return $item;


	//=========================================================================
	//实例化模型
	$itemExpend = new Item();
	
	$dbExpend = $itemExpend->getAdapter();
	
	$sqlExpend = "
	SELECT  
	ROUND(SUM(make)+SUM(travel)+SUM(waterElec)+SUM(costOthers)+SUM(welfare)+SUM(computer)+SUM(display)+SUM(camera)+SUM(fundOthers)+SUM(meals)+SUM(education),2)  AS expend
	FROM `projectbill`
	";
	
	
	$resultExpend = $dbExpend->query($sqlExpend);
	$Expend = $resultExpend->fetchAll();
	
	//========================================================================================
	$thresholdModel = new Billthreshold();
	
	$dbInitial = $thresholdModel->getAdapter();
	
	$sqlInitial = "SELECT initial FROM billthreshold ORDER BY id DESC LIMIT 1";
	
	$resultInitial = $dbInitial->query($sqlInitial);
	
	$Initial = $resultInitial->fetchAll();
	//========================================================================================
	
	
	$balance = $Initial[0]['initial'] + $DesignMoney[0]['money'] - $Expend[0]['expend'];
	return $balance;
	/*
	print_r($Initial);
	print_r($DesignMoney);
	print_r($Expend);
	print_r($balance);
	exit();
	*/
}
//==================================================================================================
////////////////////////////////////////////////////////////////////////////////////////////////////////

//   2014-4-26开始
function GetCostBalance()
{
	$itemCost = new CostBill();
	
	//防注入适配器
	$dbCost = $itemCost->getAdapter();
	
	$sqlCost = "
	SELECT
	SUM(income) AS income,
	(SUM(make)+SUM(travel)+SUM(waterElec)+SUM(costOthers)) AS spend
	FROM `costbill`
	";
	
	$resultCost = $dbCost->query($sqlCost);
	$Cost = $resultCost->fetchAll();
	//return $item;
	//print_r($Cost);
	//exit();
	//=========================================================================
	//实例化模型

	//========================================================================================
	$thresholdModel = new Billthreshold();
	
	$dbInitial = $thresholdModel->getAdapter();
	
	$sqlInitial = "SELECT costInitial FROM billthreshold ORDER BY id DESC LIMIT 1";
	
	$resultInitial = $dbInitial->query($sqlInitial);
	
	$Initial = $resultInitial->fetchAll();
	//========================================================================================
	
	
	$balance = $Initial[0]['costInitial'] + $Cost[0]['income'] - $Cost[0]['spend'];
	/*
	print_r($Initial[0]['costInitial']);
	print_r( $Cost[0]['income']);
	print_r($Cost[0]['spend']);
	exit();
	*/
	return $balance;
}














