,
{ display: '操作', isSort: false, render: function (rowdata, rowindex, value)
 {
     var h = "";
     if (!rowdata._editing)
     {
        h += "<a href='javascript:beginEdit(" + rowindex + ")'>修改权限</a> ";
        h += "<a href='javascript:deleteRow(" + rowindex + ")'>删除用户</a> "; 
        h += "<a href='javascript:resetPwd(" + rowindex + ")'>重置密码</a> "; 
     }
     else
     {
        h += "<a href='javascript:endEdit(" + rowindex + ")'>提交</a> ";
        h += "<a href='javascript:cancelEdit(" + rowindex + ")'>取消</a> "; 
     }
     return h;
  }
}
