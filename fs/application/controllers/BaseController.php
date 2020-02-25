<?php
	//增加一个所有controller的父类
	class BaseController extends Zend_Controller_Action 
	{
		public function init() 
		{
			//init mysql adapter
			$url = constant("APPLICATION_PATH").DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';
			$dbconfig = new Zend_Config_Ini($url,"mysql");
			$db = Zend_Db::factory($dbconfig->db);
						
			
			$db->query('SET NAMES UTF8');
			Zend_Db_Table::setDefaultAdapter($db);
			
			parent::init();
			//用户验证
			session_start();
			if(!isset($_SESSION['loginuer']))
			{
				$this->view->err = "用户名错误！";
				//file_put_contents("d:/appserv/log/zf.log", date("Y-m-d H:i:s")." faile\r\n",FILE_APPEND);
				$this->forward('login','login');
			}
			else
			{	
				$loginuser = $_SESSION['loginuer'][0];				
				$this->view->userRight = $loginuser['userRight'];
				//file_put_contents("d:/appserv/log/zf.log", date("Y-m-d H:i:s")." success\r\n",FILE_APPEND);
			}
		}
	}
?>