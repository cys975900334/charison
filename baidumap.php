<?php 
include("link.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
	body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
	#allmap{height:500px;width:100%;}
	#r-result{width:100%; font-size:14px;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=xRfRRRURIijC6IDqV8bDu1Ukf8aQBjdf"></script>
<title>ZigBee节点定位</title>
</head>
<body>
	<div id="allmap"></div>
	<form action="process.php" method="post">
		<div id="r-result">
			<br>请输入需要查询的节点信息，默认空则为查询所有节点。<br>
			组ID: <input id="GroupID" type="text" name="Group_id" style="width:100px; margin-right:10px;" />
			节点ID: <input id="NodeID" type="text" name="Node_id" style="width:100px; margin-right:10px;" />
			<!--隐藏输入框，map代表发送地图命令的格式-->
			<input type="hidden" value="map" name="method">
			<input type="submit" value="查询"  />
		</div>
	</form>
</body>
</html>
<script type="text/javascript">
	window.onload = function(){
		<?php
		$link_db = new database("127.0.0.1", "root", "root", "php"); //设置数据库信息
        $link_db->link_mysql();          //链接数据库  
        //创建一个buffer数据表用于数据暂存
		$link_db->SQL_LAN("CREATE TABLE IF NOT EXISTS buffer(
			NodeID INT NOT NULL,
			GroupID VARCHAR(10) NOT NULL,
			TimeSample VARCHAR(10) NOT NULL,
			Deep_left VARCHAR(10) NOT NULL,
			Deep_center VARCHAR(10) NOT NULL,
			Deep_right VARCHAR(10) NOT NULL,
			Energy VARCHAR(10) NOT NULL,
			Power VARCHAR(10) NOT NULL,
			Rssi VARCHAR(10) NOT NULL,
			LQI VARCHAR(10) NOT NULL,
			LocationX VARCHAR(10) NOT NULL,
			LocationY VARCHAR(10) NOT NULL,
		    PRIMARY KEY ( NodeID,TimeSample ))ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $row_array = $link_db->SQL_LAN("SELECT * FROM buffer"); 
        ?>
	// 根据经纬度确定位置功能
	var map = new BMap.Map("allmap");
	map.centerAndZoom(new BMap.Point(119.4768964808,32.2006316408),11); //默认定位到镇江的地理位置
	map.enableScrollWheelZoom(true);     //启动滚轮放大缩小	
	map.clearOverlays(); 

	var opts = {
			width : 70,     // 信息窗口宽度
			height: 230,     // 信息窗口高度
			title : "ZigBee节点信息窗口" , // 信息窗口标题
			enableMessage:true//设置允许信息窗发送短息
		};
	var pointArray = new Array();
	var num = 0;       //代表节点数，从0加到最大
	<?php foreach ($row_array as $row) {
		?>
		 var marker = new BMap.Marker(new BMap.Point(<?php echo $row['LocationX'] ?>, <?php echo $row['LocationY'] ?>)); // 创建点
		 	map.addOverlay(marker);    //增加点
		 	pointArray[num] = new BMap.Point(<?php echo $row['LocationX'] ?>, <?php echo $row['LocationY'] ?>);
		 	num++;
		 	var content = "<?php echo "节点ID：{$row['NodeID']}<br>组ID：{$row['GroupID']}<br>深度（左）:{$row['Deep_left']}<br>深度（中）:{$row['Deep_center']}<br>深度（右）:{$row['Deep_right']}<br>能量：{$row['Energy']}<br>信号质量：{$row['Rssi']}<br>经度：{$row['LocationX']}<br>纬度：{$row['LocationY']}" ?>";
		 	addClickHandler(content,marker);
			<?php 
		}
			$link_db->SQL_LAN("DELETE FROM buffer");          //清空buffer表
			?> 
			num = 0;     //节点数清零
			map.setViewport(pointArray);   


	//全景图功能
	// 覆盖区域图层测试
	map.addTileLayer(new BMap.PanoramaCoverageLayer());
	var stCtrl = new BMap.PanoramaControl(); //构造全景控件
	stCtrl.setOffset(new BMap.Size(20, 20));
	map.addControl(stCtrl);//添加全景控件

	//信息窗口

	function addClickHandler(content,marker){
		marker.addEventListener("click",function(e){
			openInfo(content,e)}
			);
	}
	function openInfo(content,e){
		var p = e.target;
		var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
		var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
		map.openInfoWindow(infoWindow,point); //开启信息窗口
	}
}

</script>
