<?php

require_once APPLICATION_PATH.'/models/Classes/PHPExcel.php';

class Myexcel extends PHPExcel
{
	//$cell_1和$cell_2为表头设置黑体和边框的单元格范围
	public function init($cell_1,$cell_2)
	{
		$this->getProperties()->setCreator("Hezhuobin")
		->setLastModifiedBy("Hezhuobin")
		->setTitle("报账情况")
		->setSubject("报账情况")
		->setDescription("报账情况")
		->setKeywords("报账情况")
		->setCategory("报账情况");
		
		
		// Add some data
		
		$this->setActiveSheetIndex(0);
		
		
		
		//设置单元格格式
		$style_obj = new PHPExcel_Style();
		$style_array = array(
				'borders' => array(
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
				),
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
				)
		);
		$style_obj->applyFromArray($style_array);
		$this->getActiveSheet()->setSharedStyle($style_obj, "$cell_1:$cell_2");
		$this->getActiveSheet()->getStyle("$cell_1:$cell_2")->getFont()->setBold(true);				
		
		$this->getActiveSheet()->setTitle('报账情况');
		
		$this->setActiveSheetIndex(0);
		
	}
	
	public function setGridFont($whichCase = "")
	{

		if("成本" == $whichCase)
		{
			//表头
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
		
			$this->getActiveSheet()->setCellValue('E2',"收入");
			
			$this->getActiveSheet()->setCellValue('F2',"制作");
			$this->getActiveSheet()->setCellValue('G2',"差旅");
			$this->getActiveSheet()->setCellValue('H2',"水电");
			$this->getActiveSheet()->setCellValue('I2',"其它");
			
			$this->getActiveSheet()->setCellValue('J2',"余额(元)");
			
			$this->getActiveSheet()->setCellValue('K2',"报账人");
			$this->getActiveSheet()->setCellValue('L2',"备注");
			
		}
		else if("福利" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
			
			$this->getActiveSheet()->setCellValue('E2',"收入");
				
			$this->getActiveSheet()->setCellValue('F2',"福利");

				
			$this->getActiveSheet()->setCellValue('G2',"余额(元)");
				
			$this->getActiveSheet()->setCellValue('H2',"报账人");
			$this->getActiveSheet()->setCellValue('I2',"备注");
		}
		else if("发展基金" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
			
			$this->getActiveSheet()->setCellValue('E2',"收入");
				
			$this->getActiveSheet()->setCellValue('F2',"电脑");
			$this->getActiveSheet()->setCellValue('G2',"显示器");
			$this->getActiveSheet()->setCellValue('H2',"照相机");
			$this->getActiveSheet()->setCellValue('I2',"其它");
				
			$this->getActiveSheet()->setCellValue('J2',"余额(元)");
				
			$this->getActiveSheet()->setCellValue('K2',"报账人");
			$this->getActiveSheet()->setCellValue('L2',"备注");
		}
		else if("餐费" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
				
			$this->getActiveSheet()->setCellValue('E2',"收入");
			
			$this->getActiveSheet()->setCellValue('F2',"餐费");
			
			
			$this->getActiveSheet()->setCellValue('G2',"余额(元)");
			
			$this->getActiveSheet()->setCellValue('H2',"报账人");
			$this->getActiveSheet()->setCellValue('I2',"备注");
		}
		else if("教育培训费" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
				
			$this->getActiveSheet()->setCellValue('E2',"收入");
			
			$this->getActiveSheet()->setCellValue('F2',"教育培训费");
			
			
			$this->getActiveSheet()->setCellValue('G2',"余额(元)");
			
			$this->getActiveSheet()->setCellValue('H2',"报账人");
			$this->getActiveSheet()->setCellValue('I2',"备注");
		}
		else if("年度总产值" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"年度");
			$this->getActiveSheet()->setCellValue('C2',"年度总产值");
			$this->getActiveSheet()->setCellValue('D2',"编辑时间");
		}
		else if("合同总额" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"业务号");
			$this->getActiveSheet()->setCellValue('C2',"项目名称");
			$this->getActiveSheet()->setCellValue('D2',"签订时间");
			$this->getActiveSheet()->setCellValue('E2',"合同总额");
		}
		else if("设计费收入细目" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('B2',"收款时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
			$this->getActiveSheet()->setCellValue('E2',"收取的设计费");
		}
		else if("设计费收入统计" == $whichCase)
		{
			$this->getActiveSheet()->setCellValue('A2',"合同签订时间");
			$this->getActiveSheet()->setCellValue('B2',"业务号");
			$this->getActiveSheet()->setCellValue('C2',"项目名称");
			$this->getActiveSheet()->setCellValue('D2',"已收取的设计费");
			$this->getActiveSheet()->setCellValue('E2',"未收取的设计费");
		}
		else if("" == $whichCase)
		{

		// 合并单元格
			$this->getActiveSheet()->mergeCells('B2:B3');
			$this->getActiveSheet()->mergeCells('C2:C3');
			$this->getActiveSheet()->mergeCells('D2:D3');
			$this->getActiveSheet()->mergeCells('E2:H2');
			$this->getActiveSheet()->mergeCells('I2:I3');
			//$this->getActiveSheet()->mergeCells('J2:I2');
			$this->getActiveSheet()->mergeCells('J2:M2');
			$this->getActiveSheet()->mergeCells('N2:N3');
			$this->getActiveSheet()->mergeCells('O2:O3');
			$this->getActiveSheet()->mergeCells('P2:P3');
			$this->getActiveSheet()->mergeCells('Q2:Q3');
			$this->getActiveSheet()->mergeCells('R2:R3');
			//$this->getActiveSheet()->mergeCells('S2:S3');
			//$this->getActiveSheet()->mergeCells('T2:T3');
			//表头
			$this->getActiveSheet()->setCellValue('B2',"报账时间");
			$this->getActiveSheet()->setCellValue('C2',"业务号");
			$this->getActiveSheet()->setCellValue('D2',"项目名称");
			$this->getActiveSheet()->setCellValue('E2',"成本（元）");
			$this->getActiveSheet()->setCellValue('E3',"制作");
			$this->getActiveSheet()->setCellValue('F3',"差旅");
			$this->getActiveSheet()->setCellValue('G3',"水电");
			$this->getActiveSheet()->setCellValue('H3',"其它");
			$this->getActiveSheet()->setCellValue('I2',"福利（元）");
			//$this->getActiveSheet()->setCellValue('H3',"餐费");
			//$this->getActiveSheet()->setCellValue('I3',"其它");
			$this->getActiveSheet()->setCellValue('J2',"发展基金（元）");
			$this->getActiveSheet()->setCellValue('J3',"电脑");
			$this->getActiveSheet()->setCellValue('K3',"显示器");
			$this->getActiveSheet()->setCellValue('L3',"相机");
			$this->getActiveSheet()->setCellValue('M3',"其它");
			$this->getActiveSheet()->setCellValue('N2',"餐费");
			$this->getActiveSheet()->setCellValue('O2',"教育培训");
			$this->getActiveSheet()->setCellValue('P2',"报账人");
			$this->getActiveSheet()->setCellValue('Q2',"备注");
			$this->getActiveSheet()->setCellValue('R2',"余额(元)");
		}
		
	}
	
	public function insertData($dataArray)
	{
		$this->getActiveSheet()->fromArray($dataArray, NULL, 'A3');		
	}
	
	//$flag= 1 表示用excel2007版，否则导出03版的excel
	public function saveExcel($flag = 1,$outPutName ="报账情况")
	{
		//echo"nimei";
		//exit();
		if ($flag) 
		{
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007');
			$filename = ".xlsx";
		}
		else 
		{
			$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
			$filename = ".xls";
		}		
		
		date_default_timezone_set('PRC');
		$date = date("YmdHis").rand(10, 99);     
		//print_r($date);
		//exit();
        
		$outputFileName = $outPutName.$date.$filename;
		//$outputFileName = "报账情况".$date.$filename;
		//print_r($outputFileName);
		//exit();
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition:inline;filename="'.$outputFileName.'"');
		header("Content-Transfer-Encoding: binary");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		$objWriter->save('php://output');
	}
	
	
}