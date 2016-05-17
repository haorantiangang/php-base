<?php
/**
 * Created by PhpStorm.
 * User: lxf
 * Date: 15/12/30
 * Time: 上午9:06
 */

require("mysqliDb.php");
//if(Db::getInstance()->connect())
//{
//    echo "====";
//}

//插入
//$sql = "insert into one values(223,'小风')";
//mysqliDb::getInstance()->add($sql);

//更新
//update  tb_name   set id=1,name='asd',sex='男'  where  条件2
//$sql = "update one  set id =100,name = 'hah2222' where id =223";
//mysqliDb::getInstance()->update($sql);

 //删除
//$sql = "delete from one where id = 222 ";
//mysqliDb::getInstance()->delete($sql);

 //查询
// $sql = "select * from one  limit 30,20";
// $arr=mysqliDb::getInstance()->query($sql,$para);
// var_dump($arr);

//select * from table limit m,n
//其中m是指记录开始的index，从0开始，表示第一条记录
//n是指从第m+1条开始，取n条。


$sql = "select * from one  limit 30,20";
$arr = mysqliDb::getInstance()->query($sql);

//echo $arr[0][0];
var_dump($arr);