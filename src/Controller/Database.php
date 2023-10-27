<?php
namespace Jin\Controller;

class Database {
    private $table;
    private $method;
    private $data;
    private $format;
    public function __construct(){


    }

    //Set the table property
    public function table($tablename){
        // Verify if table exist
        $this->table = $tablename;
        return $this;
    }
    //get the Table property
    public function getTable(){
        return $this->table;
    }
    //get the Method property
    public function getMethod(){
        return $this->method;
    }
    //set the Method property
    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    public function getData(){
        return $this->data;
    }

    public function get($data = []){
        $this->setMethod("get");
        $this->makeQuery($data);
        return $this;
    }
    public function post($data = []){
        $this->setMethod("post");
        $this->makeQuery($data);
        return $this;
    }
    public function update($data = []){
        $this->setMethod("update");
        $this->makeQuery($data);
        return $this;
    }
    public function delete($data = [],$force = false){
        if($force){
            $this->setMethod("delete");
        } else {
            $this->setMethod("soft-delete");
        }
        
        $this->makeQuery($data);
        return $this;
    }

    private function makeQuery($data){
        $this->data = $data;
        $this->setFormat();
        $this->build(); 

    }
    private function setFormat(){
        $format = "";
        switch($this->getMethod()){
            case 'post':
                $format = "INSERT INTO %s %s VALUES %s ;";
                break;
            case 'update':
            case 'soft-delete':
                $format = "UPDATE %s SET %s WHERE %s ;";
                break;
            case 'delete':
                $format = "DELETE FROM %s WHERE %s;";
                break;
            case 'get':
            default: 
                $format = "SELECT %s FROM %s WHERE %s ;";
                break;
        }
        $this->format = $format;
    }
    public function getFormat( ){
        return $this->format;
    }


    //Make liting with separator


    //Parse parameter 
    public function parseParams($dataKey = 'filters'){
        $res = "";
        if(isset($this->getData()[$dataKey])){
            $res = "";
            $this->setParams($dataKey, $this->getData()[$dataKey]);
            $params = [];
            foreach ($this->getParams($dataKey) as $key => $param) {
               $params[] = "$key = $param"; 
            }
            $res .= $this->makeListing($params);
        }
        return $res;
    }

    public function makeListing($list = [] ){
        $res = "";
        $index = 0;
        foreach ($list as $value) {
            $res .= $value;
            if(!(count($list) == ($index + 1))){
                $res .= " , ";
            }
            $index += 1;
        }
        return $res;
    }

    private function setParams($key, $data){
        $this->$key =  $data;
        return $this;
    }
    public function getParams($key){
        return $this->$key;
    }

    private function build(){
        $query = "";
        switch($this->getMethod()){
            case 'update':
                // $format = "UPDATE %s SET %s WHERE %s ;";

                $query = sprintf($this->getFormat(), $this->getTable(), $this->parseParams('post'), $this->parseParams());
                break;
            
            default:
                # code...
                break;
        }
        $this->setQuery($query);
    }
    private function setQuery($query){
        $this->query = $query;
        return $this;
    }
    public function getQuery(){
        return $this->query;
    }
}
