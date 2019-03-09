    <?php 
    //mysql数据库链接
    class database{
        private $HOST;                //mysql服务器主机地址
        private $USER;                //mysql用户名
        private $PWD;                 //mysql密码
        private $DBNAME;              //链接的数据库名
        private $db;
        public  $rows = [];           //存放数据的二维数组
        public  $mysqli_result;       //存放数据库中的数据
        //构造函数
        public function __construct($host, $user, $pwd, $dbname){
            $this->HOST   = $host;
            $this->USER   = $user;
            $this->PWD    = $pwd;
            $this->DBNAME = $dbname; 
        }
        //链接数据库
        public function link_mysql(){
            $this->db = new mysqli($this->HOST, $this->USER, $this->PWD, $this->DBNAME);
            if($this->db->connect_errno <> 0){
                echo "数据库链接失败";
                echo $this->db->connect_error;    //输出错误原因
                exit;
            }
             $this->db->query("SET NAMES UTF8");     //设定编码
         }
        //执行SQL
        public function SQL_LAN($sql){
            $this->mysqli_result = $this->db->query($sql);  //通过query方法运用SQL语句操作数据库中的数据
            //gettype函数用于判断变量类型，若为对象则返回“object”,若为bool值则返回“bool”
            //若sql语句为查询数据，则mysqli_result为一个对象;
            //若sql语句为增删改数据,则mysqli_result为布尔值true
            //若sql语句错误，则mysqli_result为布尔值false
            if(gettype($this->mysqli_result) == "object"){
            $rows = [];           //存放数据的二维数组
            while($row = $this->mysqli_result->fetch_array(MYSQLI_ASSOC)){
            $rows[] = $row;     //每次取一组数据
        }
        return $rows;
    }else{
        return true;
    }
        
     }
   }

