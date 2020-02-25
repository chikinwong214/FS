function addTab_click(litext) {
	 switch (litext) {
		 
		case "财务系统首页":
			 navtab.addTabItem({tabid:'home', url: '/main/main', text: litext, height: 800 }); 
			 break;		
			 
		case "系统使用说明":
			 navtab.addTabItem({tabid:litext, url: '/main/introduction', text: litext, height: 800 }); 
			 break;	
		/*	 
		case "添加财务报账":
			 navtab.addTabItem({tabid:litext, url: '/main/additemui', text: litext, height: 800 });			
			 break;
			 
		case "查看财务情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/index', text: litext, height: 800 });			
			 break;
		*/	 
		case "查看成本情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showcost', text: litext, height: 800 });			
			 break;
		case "查看福利情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showwelfare', text: litext, height: 800 });			
			 break;
		case "查看发展基金情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showfund', text: litext, height: 800 });			
			 break;
		case "查看餐费情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showmeals', text: litext, height: 800 });			
			 break;
		case "查看教育培训情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showeducation', text: litext, height: 800 });			
			 break;
		case "查看年度总产值情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showtotalvalue', text: litext, height: 800 });			
			 break;
		case "查看合同签订情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/showcontract', text: litext, height: 800 });			
			 break;
		case "查看设计费收取情况":
			 navtab.addTabItem({tabid:litext, url: '/showitem/choosedesignmoney', text: litext, height: 800 });			
			 break;
		case "成本报账":
			 navtab.addTabItem({tabid:litext, url: '/main/addcost', text: litext, height: 800 });			
			 break;
		case "福利报账":
			 navtab.addTabItem({tabid:litext, url: '/main/addwelfare', text: litext, height: 800 });			
			 break;
		case "发展基金报账":
			 navtab.addTabItem({tabid:litext, url: '/main/addfund', text: litext, height: 800 });			
			 break;
		case "餐费报账":
			 navtab.addTabItem({tabid:litext, url: '/main/addmeals', text: litext, height: 800 });			
			 break;
		case "教育培训报账":
			 navtab.addTabItem({tabid:litext, url: '/main/addeducation', text: litext, height: 800 });			
			 break;
			 	 
		case "用户管理":
			 navtab.addTabItem({tabid:litext, url: '/admin/index', text: litext, height: 800 });			
			 break;
		case "修改密码":
			 navtab.addTabItem({tabid:litext, url: '/admin/modifypassword', text: litext, height: 800 });			
			 break;
			 
		case "阈值输入":
			 navtab.addTabItem({tabid:litext, url: '/threshold/thresholdui', text: litext, height: 800 });			
			 break;		
			 
		case "年度总产值输入":
			 navtab.addTabItem({tabid:litext, url: '/threshold/totalvalueui', text: litext, height: 800 });			
			 break;	

		case "统计开支情况":
			 navtab.addTabItem({tabid:litext, url: '/statistics/index', text: litext, height: 800 });			
			 break;
			 
		case "统计开支图表":
			 navtab.addTabItem({tabid:litext, url: '/statistics/graphui', text: litext, height: 800 });			
			 break;

		case "设计费收入输入":
			 navtab.addTabItem({tabid:litext, url: '/designmoney/inputui', text: litext, height: 800 });			
			 break;
			 
		case "业务号统计情况":
			 navtab.addTabItem({tabid:litext, url: '/statistics/sidindex', text: litext, height: 800 });			
			 break;
			 
		case "业务号统计图表":
			 navtab.addTabItem({tabid:litext, url: '/statistics/sidgraphui', text: litext, height: 800 });			
			 break;
			 
		case "合同总额输入":
			 navtab.addTabItem({tabid:litext, url: '/designmoney/totalcontractui', text: litext, height: 800 });			
			 break;
	 }
}
