<?php

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Admin.php';

class LoginController extends BaseController
{   
    public function loginAction()
    {
        // 调用表模型
        $adminModel = new Admin();
        
        //获取用户名和密码
        $user = $this->getRequest()->getParam("user","");
        $pwd = $this->getRequest()->getParam("pwd","");               
        
        //防注入适配器
        $db = $adminModel->getAdapter();
        $where = $db->quoteInto("user = ?", $user).$db->quoteInto(" AND password = ?", md5($pwd));        
      
        $loginuser = $adminModel->fetchAll($where)->toArray();
        
        if(1 == count($loginuser))
        {
        	//保存到session
        	session_start();
        	$_SESSION['loginuer'] = $loginuser;        	
        	$this->_forward('index','main');
        }
        else 
        {
        	$this->view->err = "<font color='red'>您的用户名或密码错误</font>";
        	$this->_forward('index','index');
        }
    }

    
    public function logoutAction()
    {
    	session_start();
    	unset($_SESSION['loginuer']);
    	$this->_forward('index','index');
    }
    

}

