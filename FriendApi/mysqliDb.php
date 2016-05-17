<?php
/**
 * Created by PhpStorm.
 * User: lxf
 * Date: 15/12/31
 * Time: 上午10:00
 */

class MysqliDb{
    static private $_instance; //实力
    public $mysqli;     //mysqli连接对象句柄
    private $_dbConfig = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'database' => 'testdata',
    );
    private function  __construct()
    {
        //连接数据库
        $this->mysqli = new mysqli($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password'],$this->_dbConfig['database']);

        if($this->mysqli->connect_error){

            die('Connect Error ('.$this->mysqli->connect_errno.')'.$this->mysqli->connect_error);

        }
        $this->mysqli->query("set names UTF8");
    }
    public  static  function  getInstance(){
        if(!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //几步的公共类

    public function  saveOrUpdateOrDelete($sql)
    {
        $stmt = $this->mysqli->prepare($sql);
        if($stmt)
        {
            $flag = $stmt->execute();
            $stmt->close();
            $this->closeConn();
            return $flag;
        }
        else
        {
            echo '数据库连接出错或者sql出错：请检查sql:     '.$sql;
            return  0;
        }
    }
  //添加

    public  function add($sql){

        return  $this->saveOrUpdateOrDelete($sql);
    }

    //删除

    public  function delete($sql){

        return  $this->saveOrUpdateOrDelete($sql);
    }

    //更新

    public  function update($sql){

        return  $this->saveOrUpdateOrDelete($sql);
    }
   //查询

    public  function query($sql){
        $stmt = $this->mysqli->prepare($sql);
        if($stmt)
        {
            $row =Array();
            $flag =  $stmt->execute();
            $stmt->store_result();
            $row =self::getAll($stmt);
//            $rs = $stmt->result_metadata();
//            $cloumn = Array();
//            $cloumnName = Array();
//            $i=0;
//            $bindre="";
//            while($field = $rs->fetch_field())
//            {
//                $cloumn[$i] = $field->name;
//                $cloumnName[$i] = $field->name;
//                $i++;
//            }
//
//            foreach($cloumnName as $cloumns)
//            {
//                $bindre=$bindre."$".$cloumns.",";
//            }
////            $stmt->bind_result()
////            var_dump($cloumnName);
////            var_dump($cloumn);
//            echo"----".$bindre;
//            $stmt->bind_result($bindre);
//            $stmt->num_rows();
//            while($stmt->fetch())
//            {  $rs=array();
//                foreach($cloumnName as $cloumns)
//                {
//                    echo "==="."$".$cloumns;
//                    $rs[]="$".$cloumns;
//                }
//
//                $row =$rs;
//            }

            $stmt->close();
            $this->closeConn();
            return $row;
        }
        else
        {
            echo '数据库连接出错或者sql出错：请检查sql:     '.$sql;
            return  0;
        }
    }

    private  function  getAll($stmt)
    {
        $res = array();
        $field =  $stmt->result_metadata()->fetch_fields();
        $out = array();
        $fields =  array();
        foreach($field as $val)
        {
           // var_dump($val);

            $fields [] = &$out[$val->name];

        }
      //  var_dump($out);
        call_user_func_array(array($stmt,'bind_result'),$fields);
        while($stmt->fetch()){
            $t = array();
            foreach($out as $key =>$val)
            {
                //echo "===".$val;
                $t[$key]  = $val;
            }
            $res[]=$t;
        }
        return $res;
    }

   //关闭链接
    function closeConn()
    {
        $this->mysqli->close();
    }

}