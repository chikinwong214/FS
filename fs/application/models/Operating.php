,
{ display: '操作', isSort: false, width: 120, render: function (rowdata, rowindex, value)
 {
     var h = "";
     if (!rowdata._editing)
     {
        h += "<a href='javascript:beginEdit(" + rowindex + ")'>修改</a> ";
        h += "<a href='javascript:deleteRow(" + rowindex + ")'>删除</a> "; 
     }
     else
     {
        h += "<a href='javascript:endEdit(" + rowindex + ")'>提交</a> ";
        h += "<a href='javascript:cancelEdit(" + rowindex + ")'>取消</a> "; 
     }
     return h;
  }
}