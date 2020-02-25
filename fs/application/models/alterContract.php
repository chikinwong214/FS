	
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
		serviceId = row.serviceId,
		projectName = row.projectName,
		signDate = row.signDate,
		
		totalContract = row.totalContract;
		
	var str = "id=" + id + "&signDate=" + signDate + "&serviceId=" + serviceId + "&projectName=" + projectName + "&totalContract=" + totalContract;
	
		//window.open("/alteritem/updateitem?"+str);
		window.location = "/alteritem/updatecontract?"+str;
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
			deleItem = "contract";
		var str = "id=" + id+"&deleItem="+deleItem;;
		//window.open("/alteritem/deleteitem?"+str);
		window.location = "/alteritem/deleteitem?"+str;
	}
}
	