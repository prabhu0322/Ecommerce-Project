<?php
namespace Controllers;

class BaseController {

    protected $con = NULL;

    public function db(){
        global $con; 

        $this->con = $con;

        return $this->con;
    }

    public function iterQuery( $query_object ){
        $list = [];

        if( $query_object->num_rows ){
            while( $row = $query_object->fetch_assoc() ){
                array_push( $list, $row );
            }
        }

        return $list;
    }

    public function prepareQuery( $query ){
        
        $db = $this->db();

        $op = $db->query( $query );

        return $this->iterQuery( $op );
    }

}
?>