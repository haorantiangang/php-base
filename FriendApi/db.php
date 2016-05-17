<?php
/**
 * Created by PhpStorm.
 * User: lxf
 * Date: 15/12/29
 * Time: 下午6:21
 */

class Db {
   static private $_instance;
   static private $_connectSource;
   private $_dbConfig = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'database' => 'testdata',
    );

    private function  __construct()
    {
    }
    public  static  function  getInstance(){
        if(!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
    }
    public function  connect(){
       if(!self::$_connectSource)
       {
           self::$_connectSource = mysqli_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password'],$this->_dbConfig['database']);

           if(!self::$_connectSource) {
               throw new Exception('mysql connect error ' . mysqli_error());
               //die('mysql connect error' . mysql_error());
           }
           //mysqli_select_db($this->_dbConfig['database'], self::$_connectSource);
           mysqli_query("set names UTF8", self::$_connectSource);
       }
        return self::$_connectSource;
    }

}