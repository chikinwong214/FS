	
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
		date = row.date,
		serviceId = row.serviceId,
		projectName = row.projectName,
		
		income = row.income,
		
		meals = row.meals,
			
		applicant = row.applicant,
		remarks = row.remarks;
		
	var str = "id=" + id + "&date=" + date + "&serviceId=" + serviceId + "&projectName=" + projectName + "&income=" + income+ "&meals=" + meals
			+"&applicant=" + applicant + "&remarks=" + remarks;	
	
		//window.open("/alteritem/updateitem?"+str);
		window.location = "/alteritem/updatemeals?"+str;
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
			deleItem = "meals";
		var str = "id=" + id+"&deleItem="+deleItem;;
		//window.open("/alteritem/deleteitem?"+str);
		window.location = "/alteritem/deleteitem?"+str;
	}
}
	