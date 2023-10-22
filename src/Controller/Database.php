<?php
namespace Jin\Controller;
//Namespace

class Database {

    protected $table;
    protected $format;
    protected $method;
    protected $data;
    protected $filters;
    protected $query;
    protected $lastResult;
    protected $connexion;
    public function __construct($connexion = null) {
        $this->connexion = $connexion;
    }
    public function table($tablename)
    {
        //Verify if table exist
        $this->table = $tablename;
        return $this;
    }
    public function get($data){
        $this->method = "get";
        $this->makeQuery($data);
        return $this;
    }
    public function post($data){
        $this->method = "post";
        $this->makeQuery($data);
        return $this;
    }
    public function delete($data,$force = false){
        $this->method = "soft-delete";
        if($force){
            $this->method = "delete";
        }
        $this->makeQuery($data);
        return $this;
    }
    public function update($data){
        $this->method = "update";
        $this->makeQuery($data);
        return $this;
    }
    public function makeQuery($data){
        $this->data = $data;
        $this->setFormat();
        $this->build();
    }
    public function getMethod(){
        return $this->method;
    }
    private function setFormat(){
        $format = "";
        switch ($this->method) {
            case 'post':
                $format = "INSERT INTO %s %s VALUES %s ;";
                break;
            case 'soft-delete':
            case 'update':
                $format = "UPDATE %s SET %s WHERE %s ;";
                break;
            case 'delete':
                $format = "DELETE FROM %s WHERE %s ;";
                break;
            case 'get':
            default:
                $format = "SELECT %s FROM %s WHERE %s ;";
                break;
        }
        $this->format = $format;
    }
    public function getFormat(){
        return $this->format;
    }
    public function getQuery(){
        return $this->query;
    }
    public function getTable(){
        return $this->table;
    }
    public function setColumns(){

    }
    //Change Value to SQL Acceptable value
    public function makeSqlValue($raw){
                if(is_string($raw)){
                    $raw = '"'.$raw.'"';
                } 
                if($raw === true){
                    $raw = 'TRUE';
                }
                if($raw === false){
                    $raw = 'FALSE';
                }
                return $raw;
    }
    //Make listing with separator
    public function makeListing($list =[], $separator = "," ,$prefix ="", $suffix = "", $sqlVal = false,$encapsuler = ""){
        $res = $prefix;
        $index = 0;
            foreach ($list as $value) {
            if($sqlVal){
                $res .= $this->makeSqlValue($value);
            } else {
                $res .= $encapsuler . $value . $encapsuler;
            }
            
            if(!(count($list) == ($index + 1 ))){
                $res .= $separator;
            }
            $index += 1;
        }
        $res .= $suffix;
        return $res;
    }
    public function parseParams($dataKey = 'filters', $separatedBy = " AND "){
        $res = "1";
        if(isset($this->data[$dataKey])){
            $res = "";
            $this->filters = $this->data[$dataKey];
            $filters = [];
            foreach ($this->filters as $key => $filter) {
                $filter  = $this->makeSqlValue($filter);
                $filters[] = "$key = $filter";
            }
            $res .= $this->makeListing($filters, $separatedBy);
        }
        return $res;
        
    }
    private function build(){

            switch ($this->method) {
                case 'post':
                $query = "";

                if(isset($this->data['post'])){
                    $columns = $this->makeListing(array_keys($this->data["post"]), ',', '(',')');
                    $values = $this->makeListing($this->data['post'], ',', '(',')',true);
                    $query = sprintf($this->getFormat(), $this->table, $columns, $values);
                }
                break;
            case 'update':
                // $format = "UPDATE %s SET %s WHERE %s ;";
                $query = sprintf($this->getFormat(), $this->table, $this->parseParams('post', ' , '), $this->parseParams());
                break;
            case 'soft-delete':
                $query = sprintf($this->getFormat(), $this->table, "status = \"offline\"", $this->parseParams());
                break;
            case 'delete':
                $query = sprintf($this->getFormat(), $this->table, $this->parseParams());
                break;
            case 'get':
                $colums = "*";
                if(isset($this->data['cols'])){
                    $colums= $this->makeListing($this->data['cols'],',');
                }
                $query = sprintf($this->getFormat(),$colums, $this->table, $this->parseParams());
                break;
            default:
                $format = "SELECT %s FROM %s WHERE %s ;"; 
                $query = sprintf($this->getFormat(),"*", $this->table, $this->parseParams());
                
                break;
        }
        $this->query = $query;
    }
    public function do(){
        $this->lastResult = $this->connexion->query($this->getQuery());
        return $this->lastResult;
    }
}