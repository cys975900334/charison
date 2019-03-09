<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, user-scalable=0, minimal-ui">
    <title>智能回收箱管理系统</title>
    <link rel="stylesheet" href="css/html.css" type="text/css">
    <script src="js/html.js"></script>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<body onload="GetDate()">
<div id="top">
    <div id="top_logo">
        <ul>
            <li><img src="picture/logo.png">Smart Recyclable Bin</li>
        </ul>
    </div>
    <div id="top_links">
        <div id="top_op">
            <ul>
                <li>
                    <img alt="事务月份" src="picture/yue.png">：
                    <span id="yue_fen"></span>
                </li>
                <li>
                    <img alt="当前时间" src="picture/time.png">：
                    <span id="day_day"></span>
                </li>
            </ul>
        </div>
        <div id="top_close">
                <img alt="退出系统" title="退出系统" src="picture/closs.png" onclick="ClossWindow()">
        </div>
    </div>
</div>
<div id="middle">
    <div id="middle-left">
        <div class="categories">
            <ul id="tab">
                <li id="tab1_1">
                    <span id="tab1_switch" onclick="GetAll()">+</span>
                    <a id="tab1_a">
                        <span id="tab1_a_span2" onclick="GetAll()">基础数据</span>
                    </a>
                </li>
                <li id="tab2_2">
                    <span id="tab2_switch" onclick="Tab2Down()">+</span>
                    <a id="tab2_a">
                        <span id="tab2_a_span2" onclick="Tab2Down()">图形绘制</span>
                    </a>
                    <ul id="tab2_">
                        <li>
                            <span id="tab2_li_span1">|</span>
                            <a href="#" onclick="PaintChar()">&nbsp;&nbsp;绘制节点能量图</a>
                        </li>
                        <li>
                            <span id="tab2_li_span2">|</span>
                            <a href="#" onclick="PaintDeepChar()">&nbsp;&nbsp;绘制测量深度图</a>
                        </li>
                    </ul>
                </li>
                <li id="tab3_3">
                    <span id="tab3_switch">+</span>
                    <a id="tab3_a">
                        <span id="tab3_a_span3" onclick="Tab3Down()">节点坐标</span>
                    </a>
                </li>
				<li id="tab4_4">
                    <span id="tab4_switch">+</span>
                    <a href="智能回收箱管理系统操作说明.txt" download="智能回收箱管理系统操作说明.txt" id="tab4_a">
                        <span id="tab4_a_span3">帮助文档</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="middle-right">
        <iframe name="right" id="rightMain" src="right.php" width="86%" height="700px" frameborder="no" scrolling="yes" allowtransparency="true" marginheight="0" marginwidth="0">
        </iframe>
    </div>
</div>
<div id="foot">
    <div class="second">
        <div class="img1"></div>
        <div class="one">jiangsu university of science and technology</div>
        <div class="img2"></div>
        <div class="two">100100101</div>
        <div class="img3"></div>
        <div class="three">youname@mail.com</div>
        <div class="img4"></div>
        <div class="four">wangqi</div>
    </div>
</div>

</body>
</html>