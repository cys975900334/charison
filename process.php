<?php 
include("task_function.php");
include("link.php");

$group_id = $_POST["Group_id"];     //获取要查询的组ID信息
$node_id  = $_POST["Node_id"];      //获取要查询的节点ID信息
$method   = $_POST["method"];       //获取查询的方式
                                    //若为"sheet"则表示是right.php发来的表单
                                    //若为"map"则表示是baidumap.php发来的表单
                                    //若为"deep_chart"则表示是DeepChart.php发来的表单
                                    //若为"paint_chart"则表示是PaintChart.php发来的表单
$link_db = new database("127.0.0.1", "root", "root", "php"); //设置数据库信息
$link_db->link_mysql();          //链接数据库 
//创建一个buffer数据表用于数据暂存
$link_db->SQL_LAN("CREATE TABLE buffer(
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

//先将指定要查询的节点全部从msg表中取出，然后存入buffer表
//取出msg表中的数据,并且如果有节点ID重复的数据，则取最新的数据，即TimeSample最大
$judge = new judge_id($group_id, $node_id);     
if($judge->result == 1){
	$row_array = $link_db->SQL_LAN("SELECT NodeID,GroupID,MAX(TimeSample)AS TimeSample,Deep_left,Deep_center,Deep_right,Energy,Power,Rssi,LQI,LocationX,LocationY FROM msg GROUP BY NodeID"); 
	save($row_array, $link_db);
}elseif($judge->result == 2){
	//WHERE和GROUP BY一块用时，WHERE必须在前面，即WHERE先对数据进行筛选，然后GROUP BY才进行分组
	$row_array = $link_db->SQL_LAN("SELECT NodeID,GroupID,MAX(TimeSample)AS TimeSample,Deep_left,Deep_center,Deep_right,Energy,Power,Rssi,LQI,LocationX,LocationY FROM msg WHERE GroupID = $group_id GROUP BY NodeID "); //查询组ID
	save($row_array, $link_db);
}elseif($judge->result == 3){
	if(($method == "sheet") ||($method =="map")){
		$row_array = $link_db->SQL_LAN("SELECT NodeID,GroupID,MAX(TimeSample)AS TimeSample,Deep_left,Deep_center,Deep_right,Energy,Power,Rssi,LQI,LocationX,LocationY FROM msg WHERE NodeID = $node_id GROUP BY NodeID ");  //查询节点ID
		save($row_array, $link_db);
	}else{
		//如果是节点能量或深度数据，那么就要取出单个节点的所有历史数据
		$row_array = $link_db->SQL_LAN("SELECT * FROM msg WHERE NodeID = $node_id ORDER BY TimeSample ASC");

		save($row_array, $link_db);
	}
} 
//var_dump($row_array);
//存入buffer表
function save($r_array, $link){
	foreach ($r_array as $r) {
	$link->SQL_LAN("INSERT INTO buffer 
		(NodeID,GroupID,TimeSample,Deep_left,Deep_center,Deep_right,Energy,Power,Rssi,LQI,LocationX,LocationY) 
		VALUES 
		('{$r['NodeID']}','{$r['GroupID']}','{$r['TimeSample']}','{$r['Deep_left']}','{$r['Deep_center']}','{$r['Deep_right']}','{$r['Energy']}','{$r['Power']}','{$r['Rssi']}','{$r['LQI']}','{$r['LocationX']}','{$r['LocationY']}')");
}
}
//返回对应的php文件
switch ( $method ) {
	case "sheet":
		header("location:right.php");
		break;
	case "map":
		header("location:baidumap.php");
		break;
	case "deep_chart":
		header("location:DeepChart.php");
		break;
	case "paint_chart":
		header("location:PaintChart.php");
		break;
	default:
		break;
}

 ?>