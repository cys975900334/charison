<?php 
//判断组号和节点号
class judge_id{
	//$result 用于判断SQL语句应为何种方式
	//若为1, 则代表获取所有节点信息
	//若为2，则代表获取指定组ID的节点信息
	//若为3，则代表获取指定节点ID的节点信息
	//若为4，则代表报错，两个框不能同时有值
	public $result; 

	public function __construct($Group_id, $Node_id){
		if(($Group_id == NULL) && ($Node_id == NULL)){
			$this->result = 1; 
		}elseif(($Group_id <> NULL) && ($Node_id == NULL)) {
			$this->result = 2;
		}elseif(($Group_id == NULL) && ($Node_id <> NULL)) {
			$this->result = 3;
		}else{
			$this->result = 4;
		}
	}
}
 ?>
