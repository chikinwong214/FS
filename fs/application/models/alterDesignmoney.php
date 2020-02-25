	
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
		date  = row.date,
		serviceId = row.serviceId,
		projectName = row.projectName,
		
		money = row.money;
		
	var str = "id=" + id + "&date=" + date + "&serviceId=" + serviceId + "&projectName=" + projectName + "&money=" + money;
	
		//window.open("/alteritem/updateitem?"+str);
		window.location = "/alteritem/updatedesignmoney?"+str;
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
			deleItem = "designmoney";
		var str = "id=" + id+"&deleItem="+deleItem;;
		//window.open("/alteritem/deleteitem?"+str);
		window.location = "/alteritem/deleteitem?"+str;
	}
}
	