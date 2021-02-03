<?php
namespace Models;

class BaseModel {
    private $con = NULL;

    protected $table;
    protected $fillables;
    protected $primaryKey;
    protected $query;
    protected $query_meta;
    protected $query_results;

    function __construct()
    {
        $this->db();
    }


    public function db(){
        global $con; 

        $this->con = $con;

        return $this->con;
    }

    public static function find( $id ){
        $class = get_called_class();

        $obj = new $class;

    }


    // query methods
    public function select( $colums="*" ){
        $c = $colums;
        if( is_array( $colums ) ){ //if columns specified separately
            $c = implode( ',', $colums );
        }

        $this->query = "SELECT $c FROM ".$this->tableName()." "; 

        // dd( [$this->query] );
        return $this;
    }

    public function where( $column, $operator="=", $value ){
        // dd('s');
        $this->query .= " WHERE $column $operator $value";

        return $this;
    }

    public function orderBy( $column, $operator="ASC" ){

        // dd('ss');
        
        $this->query .= " ORDER BY $column $operator ";

        return $this;
    }

    public function get(  ){

        $this->prepareQuery();
        $this->query_results = $this->getItems();
        
        foreach( $this->query_results as $k => $result ){
            $this->query_results[$k] = $this->fill( $result );
        }

        return $this;
    }

    public function first(  ){
        $this->query .= " LIMIT 1 ";
        $this->prepareQuery();
        $this->query_results = $this->getItems();
        
        $item = [];
        foreach( $this->query_results as $k => $result ){
            $item = $this->fill( $result );
        }

        return $item;
    }

    public function fill( $result ){

        $class = get_called_class();

        $obj = new $class;
        $obj->attributes = $result;
        
        return $obj;

    }
     
    public function prepareQuery(  ){

        // dd( $this->query );

        $this->query_meta = $this->db()->query( $this->query );
        
        return $this;
    }

    public function getItems(  ){

        $items = [];

        if( $this->query_meta->num_rows ){
            while( $row = $this->query_meta->fetch_assoc() ){
                array_push( $items, $row );
            }
        }
        
        return $items;
    } 

    public static function tableName(){

        $class = get_called_class();
        
        $obj = new $class;
        
        return $obj->table;
    }

    public function getQueryResults(){
        return $this->query_results;
    }

    public function getQuery(){
        return $this->query;
    }

    
}