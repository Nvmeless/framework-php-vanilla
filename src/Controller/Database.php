<?php
namespace Jin\Controller;
//Namespace

class Database {

    private $table;
    private $format;
    private $method;
    private $data;
    public function table($tablename)
    {
        //Verify if table exist
        $this->table = $tablename;
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
    // public payload
    public function qb(){

    }

}