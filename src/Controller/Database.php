<?php
namespace Jin\Controller;
//Namespace

class Database {

    protected $table;
    protected $format;
    protected $method;
    protected $data;
    protected $query;

    protected $lastResult;
    protected $connexion;
    
    private $availableKeys = ["post", "filters"]; 
    private $post;
    private $filters;
    public function __construct($connexion = null) {
        $this->connexion = $connexion;
    }
    public function table($tablename)
    {
        //Verify if table exist
        $this->table = $tablename;
        return $this;
    }
 
    //set the Method property
    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    public function getData(){
        return $this->data;
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
    public function getFormat(){
        return $this->format;
    }
    public function getQuery(){
        return $this->query;
    }
    private function setQuery($query){
        $this->query = $query;
        return $this;
    }

    public function getTable(){
        return $this->table;
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
                 $res .= " " . $separator . " ";
            }
            $index += 1;
        }
        $res .= $suffix;
        return $res;
    }
    public function parseParams($dataKey = 'filters', $separator = "AND"){
        $res = "1";
        if(isset($this->getData()[$dataKey])){
            $res = "";
            $this->setParams($dataKey, $this->getData()[$dataKey]);
            $params = [];
            foreach ($this->getParams($dataKey) as $key => $param) {
                $param = $this->makeSqlValue($param);
                $params[] = "`$key` = $param"; 
            }
            $res .= $this->makeListing($params, $separator);
        }
        return $res;
    }
    private function build(){

            switch ($this->method) {
                case 'post':
                $query = "";

                if(isset($this->data['post'])){
                    $columns = $this->makeListing(array_keys($this->data["post"]), ',', '(',')', false, "`");
                    $values = $this->makeListing($this->data['post'], ',', '(',')',true);
                    $query = sprintf($this->getFormat(), $this->table, $columns, $values);
                }
                break;
            case 'update':
                // $format = "UPDATE %s SET %s WHERE %s ;";
                $query = sprintf($this->getFormat(), $this->table, $this->parseParams('post', ' , '), $this->parseParams());
                break;
            case 'soft-delete':
                $query = sprintf($this->getFormat(), $this->table, "`status` = \"offline\"", $this->parseParams());
                break;
            case 'delete':
                $query = sprintf($this->getFormat(), $this->table, $this->parseParams());
                break;
            case 'get':
                $colums = "*";
                if(isset($this->data['cols'])){
                    $colums= $this->makeListing($this->data['cols'],',',"","",false, '`');
                }
                $query = sprintf($this->getFormat(),$colums, $this->table, $this->parseParams());
                break;
            default:
                $format = "SELECT %s FROM %s WHERE %s ;"; 
                $query = sprintf($this->getFormat(),"*", $this->table, $this->parseParams());
                
                break;
        }
        $this->setQuery($query);
    }
    private function setParams($key, $data){
        if(in_array($key, $this->availableKeys)){
            $this->$key =  $data;
            return $this;
        }
    }
    public function getParams($key){
        if(in_array($key, $this->availableKeys)){
            return $this->$key;
        }
        
    }
    public function do(){
        $this->lastResult = $this->connexion->query($this->getQuery());
        return $this->lastResult;
    }
}