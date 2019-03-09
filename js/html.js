/*******************html.html部分的js函数*************************/
    //获取当前时间及日期
    function GetDate() {
        var t = null;
        t = setTimeout(time,1000);//开始执行
        function time()
        {
            clearTimeout(t);//清除定时器
            var dt = new Date();
            var y=dt.getFullYear();
            var mm=dt.getMonth()+1;
            var d=dt.getDate();
            var h=dt.getHours();
            var m=dt.getMinutes();
            var s=dt.getSeconds();
            if(h<10){h="0"+h;}
            if(m<10){m="0"+m;}
            if(s<10){s="0"+s;}
            document.getElementById("yue_fen").innerHTML =  y+"."+mm+"."+d;
            document .getElementById("day_day").innerHTML=h+":"+m+":"+s+"";
            t = setTimeout(time,1000); //设定定时器，循环执行
        }
    }
//当点击退出图片时进行提示，并且跳转到初始页面
function ClossWindow(){
    if(confirm("您确定要退出本系统吗？")){
        window.open( "index.html");
    }
}
//对左方基础数据功能栏进行操作
function Tab1Down() {
    var TheDisplay=document.getElementById("tab1_").style.display;
    if(TheDisplay==="none")
    {
        document.getElementById("tab1_").style.display="inline";
        document.getElementById("tab1_switch").innerHTML="-";

    }
    else {

        document.getElementById("tab1_").style.display = "none";
        document.getElementById("tab1_switch").innerHTML = "+";
    }
}
//对左方图形绘制功能栏进行操作
function Tab2Down() {
    var TheDisplay=document.getElementById("tab2_").style.display;
    if(TheDisplay==="none")
    {
        document.getElementById("tab2_").style.display="inline";
        document.getElementById("tab2_switch").innerHTML="-";

    }
    else {

        document.getElementById("tab2_").style.display = "none";
        document.getElementById("tab2_switch").innerHTML = "+";
    }
}
//执行右方页面动态转换功能，此处为跳转到绘图页面
function PaintChar() {
    document.getElementById("rightMain").setAttribute('src','PaintChart.php ');
}
function PaintDeepChar() {
    document.getElementById("rightMain").setAttribute('src','DeepChart.php ');
}
function Tab3Down() {
    document.getElementById("rightMain").setAttribute('src','baidumap.php');
}
function GetAll() {
    document.getElementById("rightMain").setAttribute('src','right.php');
}

//获取节点能量函数
    function  GetThePower(){

    }
    //获取节点深度函数
    function  GetTheDeep(){

    }
    //获取节点无线信号函数
    function  GetTheRssi(){

    }
    //获取节点位置坐标函数
    function  GetTheLocation(){

    }

/**********************right.html部分的js函数****************/

    var row_num=11;
    //通过查询获取需要串讲的表格数，并执行onAddTR()和getTheData()函数
    function onAddTRTime() {
        var time=10;
        for(var i=0;i<time;i++) {
            onAddTR();
        }
        getTheData()
    }
    //创建表格函数
    function onAddTR()
    {
        var ID = "NUM" + row_num;
        var tb = document.getElementById("table");
        var oTr = document.createElement('tr');     //创建TR
        oTr.setAttribute("id", ID);
        oTr.innerHTML = '<td><input type="checkbox" name="IDCheck" class="check" /></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
        tb.appendChild(oTr);
        row_num++;

    }
    //传送NodeId与GroupId
    function getTheData(){
        var NodeId=document.getElementById("NodeID").value;
        var GroupId= document.getElementById("GroupID").value;
    }
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
