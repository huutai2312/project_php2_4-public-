<?php
namespace App\model;

class xl_data extends database{
    //read data
    function readitem($sql){
        // $conn = new database();
        $result = parent::connection_database()->query($sql);
        $danhsach = $result->fetchAll();
        return $danhsach;
       }
    // execute data
    function execute_item($sql){
        // $conn = new database();
        parent::connection_database()->query($sql);
    }
}