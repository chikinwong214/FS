	
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
		make = row.make,
		
		travel = row.travel,
		waterElec = row.waterElec,
		costOthers = row.costOthers,
		welfare = row.welfare,
		
		computer = row.computer,
		display = row.display,
		camera = row.camera,
		fundOthers = row.fundOthers,
		
		meals = row.meals,
		education = row.education,
		applicant = row.applicant,
		remarks = row.remarks;
		
	var str = "id=" + id + "&date=" + date + "&serviceId=" + serviceId + "&projectName=" + projectName + "&make=" + make + "&travel=" +
			travel + "&waterElec="+ waterElec +"&costOthers=" + costOthers  + "&welfare=" + welfare + "&computer=" +computer + "&display=" 
			+ display + "&camera=" + camera + "&fundOthers=" + fundOthers + "&meals=" + meals+ "&education=" + education +"&applicant=" + applicant + "&remarks=" + remarks;	
	
		//window.open("/alteritem/updateitem?"+str);
		window.location = "/alteritem/updateitem?"+str;
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
		window.location = "/alteritem/deleteitem?"+str;
	}
}
	