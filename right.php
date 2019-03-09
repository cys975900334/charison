<?php 
include("link.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>功能数据</title>
    <link href="css/right.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="content">
        <div class="ui_content">
            <div class="ui_text_indent">
                <div id="box_border">
                    <div id="box_top">搜索</div>
                    <form action="process.php" method="post">
                        <div id="box_center">
                            组ID &nbsp;&nbsp;<input type="text" id="GroupID" name="Group_id" />
                            节点ID &nbsp;&nbsp;<input type="text" id="NodeID" name="Node_id" />
                            <!--隐藏输入框，sheet代表发送表单命令的格式-->
                            <input type="hidden" value="sheet" name="method">                
                        </div>
                        <div id="box_bottom">
                            <input type="submit" value="查询" class="ui_input_btn01" onclick="checktwobox()" />
                            <input type="button" value="删除" class="ui_input_btn01" onclick="removeRow()"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="ui_content">
            <div class="ui_tb">
                <table id="table" cellspacing="0" cellpadding="0" width="95%" align="center" border="0">
                    <tr>
                        <th width="30"><input type="checkbox" id="all" onclick="CheckAll()" /></th>
                        <th>NodeID</th>
                        <th>GroupID</th>
                        <th>TimeSample</th>
                        <th>Deep_Left(cm)</th>
                        <th>Deep_Center(cm)</th>
                        <th>Deep_Right(cm)</th>
                        <th>Energy(J)</th>
                        <th>&nbsp;Power&nbsp;</th>
                        <th>&nbsp;&nbsp;Rssi&nbsp;&nbsp;</th>
                        <th>&nbsp;&nbsp;LQI&nbsp;&nbsp;</th>
                        <th>LocationX</th>
                        <th>locationY</th>
                    </tr>


                </table>
            </div>

        </div>
    </div>
    <script>

    //移除表格函数
    function removeRow()
    {
        var items = document.getElementsByClassName("check");
        var len=items.length;
        for(var i=len-1;i>=0;i--){
            var is_checked=items[i].checked;     //获取复选框是否被选中，true/false
            if(is_checked){
                var td=items[i].parentNode;     //td标签
                var tr=td.parentNode;          //tr标签
                var tb=tr.parentNode;         //table标签
                tb.removeChild(tr);
                document.getElementById("all").checked=false;     //删除表格后把首位复选框取消选中
            }
        }

    }
    //当首位复选框选中时，全部复选框都为选中状态
    function CheckAll(){
        var flag=document.getElementById("all").checked;
        var check=document.getElementsByName("IDCheck");  //获取所有name为IDcheck的复选框数量
        for(var i=0;i<check.length;i++){          //通过循环对每个复选框的checked进行赋值
            check[i].checked=flag;
        }
    }
	function checktwobox(){
        var GID=document.getElementById("GroupID").value;
        var NID=document.getElementById("NodeID").value;
        if(GID!=="" && NID!== "" )
        {
            alert("Warning:Values cannot be entered in both text boxes");
        }
    }
	 function OnAddTRTime(){
        var GID=document.getElementById("GroupID").value;
        var NID=document.getElementById("NodeID").value;
        if(GID!=="" && NID!== "" )
        {
            alert("Warning:Values cannot be entered in both text boxes");
        }
    }
  window.onload = function()
    {
        var Row_num;
        var Row_id = 1;
            //创建表格函数
    function onAddTR()
    {
        var ID = "NUM" + Row_id;
        var tb = document.getElementById("table");
            var oTr = document.createElement('tr');     //创建TR
            oTr.setAttribute("id", ID);
            oTr.innerHTML = '<td><input type="checkbox" name="IDCheck" class="check" /></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
            tb.appendChild(oTr);
        }

        <?php 
        $link_db = new database("127.0.0.1", "root", "root", "php"); //设置数据库信息
        $link_db->link_mysql();          //链接数据库  
        
        $row_array = $link_db->SQL_LAN("SELECT * FROM buffer");    
        $row_num = count($row_array);    //统计二维数组长度   ?>

        Row_num = <?php echo $row_num;?>;
        for(;Row_id<=Row_num;Row_id++) {
            onAddTR();
        }
<?php
    $row_id = 1;
    foreach ($row_array as $row) {
        $num_php = "NUM".$row_id;
        ?>
        var row = document.getElementById("<?php echo $num_php; ?>");
        var ach = row.getElementsByTagName("td");

        ach[1].innerHTML = "<?php echo $row['NodeID']; ?>";
        ach[2].innerHTML = "<?php echo $row['GroupID']; ?>";
        ach[3].innerHTML = "<?php echo $row['TimeSample']; ?>";
        ach[4].innerHTML = "<?php echo $row['Deep_left']; ?>";
        ach[5].innerHTML = "<?php echo $row['Deep_center']; ?>";
        ach[6].innerHTML = "<?php echo $row['Deep_right']; ?>";
        ach[7].innerHTML = "<?php echo $row['Energy']; ?>";
        ach[8].innerHTML = "<?php echo $row['Power']; ?>";
        ach[9].innerHTML = "<?php echo $row['Rssi']; ?>";
        ach[10].innerHTML = "<?php echo $row['LQI']; ?>";
        ach[11].innerHTML = "<?php echo $row['LocationX']; ?>";
        ach[12].innerHTML = "<?php echo $row['LocationY']; ?>";
        <?php 
        $row_id++;
    }
    $link_db->SQL_LAN("DROP TABLE buffer");
    ?>
}

</script>
</body>
</html>