

function beginEdit(rowid) 
{ 
	g.beginEdit(rowid);
}
  
function cancelEdit(rowid) 
{ 
	g.cancelEdit(rowid);
}
  
function endEdit(rowid) 
{
	g.select(rowid);
	var row = g.getSelectedRow();	
	g.endEdit(rowid);
	
	if (confirm('确定修改?'))
	{
	var id = row.id,
		userRight = row.userRight;
		
		//alert(userRight);
		
	var str = "id=" + id + "&userRight=" + userRight ;	
	
	//alert(str);
	
		//window.open("/modifyuserright/updateitem?"+str);
		window.location = "/modifyuserright/updateitem?"+str;
		//window.location = "/admin/xxx";
	} 
	
}

function deleteRow(rowid)
{
	if (confirm('确定删除?'))
	{
		g.select(rowid);
		var row = g.getSelectedRow();
		g.deleteSelectedRow();
		
		var id = row.id;
		var str = "id=" + id;
		//window.open("/alteritem/deleteitem?"+str);
		window.location = "/modifyuserright/deleteitem?"+str;
	}
}


function resetPwd(rowid)
{
	if (confirm('确定重置该用户的密码?'))
	{
		g.select(rowid);
		var row = g.getSelectedRow();
		g.deleteSelectedRow();
		
		var id = row.id;
		var str = "id=" + id;
		//window.open("/alteritem/deleteitem?"+str);
		window.location = "/modifyuserright/resetpwd?"+str;
	}
}