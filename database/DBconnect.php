<?php
class DBconnect 
{
    public function connect()
    {
        return new PDO('mysql:host=localhost;dbname=task_manager','root','', 
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
}