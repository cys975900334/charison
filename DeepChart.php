<?php 
include("link.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DeepChart</title>
    <script src="js/echarts.js"></script>
 <style>
     body{
         margin-top: 10%;
         margin-left: 10%;

     }
     #myChart{
         margin-left: 500px;
         margin-top: 500px;
     }

     .text{
            margin-left: 7%;
        }
     .input{
            margin-left: 7%;
        }

    </style>
</head>
<body>
<canvas id="myChart" width="1000" height="500"></canvas>
<form action="process.php" method="post">
    <div id="r-result">
        <p class="text">请输入需要查询的节点信息，默认空则为查询所有节点。<p>
        <div class="input">
        <input type="hidden" value="" name="Group_id"/>
        节点ID: <input id="NodeID" type="text" name="Node_id" style="width:100px; margin-right:10px;" />
        <!--隐藏输入框，map代表发送地图命令的格式-->
        <input type="hidden" value="deep_chart" name="method">
        <input type="submit" value="查询"  />
    </div>
    </div>
</form>
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
    // 初始化echarts实例
    var myChart = echarts.init(document.getElementById('myChart'));

    // 图表的配置和数据
    var option = {
        title: {
            text: '测量深度图'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend:{
            data:['Deep_Left','Deep_Center','Deep_Right']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                magicType : {show: true, type: ['line', 'bar']},
                dataView : {show: true, readOnly: false},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis: {
            type : 'category',
            data: [20180808]
        },
        yAxis: {
            type : 'value'
        },
        series: [
            {
            name: 'Deep_Left',
            type: 'bar',
            itemStyle: {
                normal: {
                    color: '#B5C345',
                    label: {
                        show: true,
                        position: 'top'
                    }
                }
            },
            data: [0]
        },
            {
                name: 'Deep_Center',
                type: 'bar',
                itemStyle: {
                    normal: {
                        color:  '#FE8463',
                        label: {
                            show: true,
                            position: 'top'
                        }
                    }
                },
                data: [0]
            },
            {
                name: 'Deep_Right',
                type: 'bar',
                itemStyle: {
                    normal: {
                        color: '#60C0DD',
                        label: {
                            show: true,
                            position: 'top'
                        }
                    }
                },
                data: [0]
            }],
    };
    var num = 0;    //数组下标
    <?php foreach ($row_array as $row) {
    ?>
    //插入横坐标
    option.xAxis.data[num] = "<?php echo $row['TimeSample']; ?>";
    //依次插入深度信息
    option.series[0].data[num] = "<?php echo $row['Deep_left']; ?>";
    option.series[1].data[num] = "<?php echo $row['Deep_center']; ?>";
    option.series[2].data[num] = "<?php echo $row['Deep_right']; ?>";
    num++;
    <?php 
    }
    $link_db->SQL_LAN("DELETE FROM buffer");          //清空buffer表
     ?>

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
}
</script>
</body>
</html>