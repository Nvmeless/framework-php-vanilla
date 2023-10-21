<?php
namespace Jin\Controller;
//Namespace

class Database {

    protected $table;
    protected $format;
    protected $method;
    protected $data;
    protected $filters;

    public function table($tablename)
    {
        //Verify if table exist
        $this->table = $tablename;
        return $this;
    }
    public function get($data){
        $this->method = "get";
        return $this;
    }
    public function post($data){
        $this->method = "post";
        $this->data = $data;
        return $this;
    }
    public function delete($data,$force = false){
        $this->data = $data;
        $this->method = "soft-delete";
        if($force){
            $this->method = "delete";
        }
        return $this;
    }
    public function update($data){

        $this->method = "update";
        return $this;
    }
    public function getMethod(){
        return $this->method;
    }

    private function setFormat(){
        switch ($this->method) {
            case 'get':
                #code...
                break;
            case 'post':
                # code...
                break;
            case 'update':
                # code...
                break;
            case 'delete':
                # code...
                break;
            case 'soft-delete':
                # code...
                break;            
            default:
                # code...
                break;
        }
    }
    public function getTable(){
        return $this->table;
    }
    // public payload
    public function getFilters($dataKey = 'filters'){
        $res = "";
        if(isset($this->data[$dataKey])){
            $this->filters = $this->data[$dataKey];
            $filters = [];
            foreach ($this->filters as  $filter) {
                $col = array_keys($filter)[0];
                $val = $filter[$col];
                if(is_string($val)){
                    $val = '"'.$val.'"';
                } 
                if($val === true){
                    $val = 'TRUE';
                }
                if($val === false){
                    $val = 'FALSE';
                }
                $filters[] = "$col = $val";
            }
            foreach ($filters as $key => $value) {
                    $res .= $value;
                   if(!(count($filters) == ($key + 1 ))){
                        $res .= " AND ";
                    }
            }
        }
        return $res;
        
    }
    public function qb(){

    }

}