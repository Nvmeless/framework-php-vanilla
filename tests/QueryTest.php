<?php
use PHPUnit\Framework\TestCase;
use Jin\Controller\Database;
class QueryTest extends TestCase{

    public function testMethod(){
        $database = new Database();
        $this->assertEquals("get", $database->get([])->getMethod());
        $this->assertEquals('post', $database->post([])->getMethod());
        $this->assertEquals('update', $database->update([])->getMethod());
        $this->assertEquals('soft-delete', $database->delete([])->getMethod());
        $this->assertEquals('delete', $database->delete([],true)->getMethod());
    }

    public function testTable(){
        $database = new Database();
        $tableName = "table";
        $database->table($tableName);
        $this->assertEquals($tableName, $database->getTable());
    }
    public function testQueryFilters(){
        $database = new Database( );
        $payload = [
          'filters' => [
            ["column" => "value"]
          ]  
          ];
          $this->assertEquals('column = "value"', $database->getFilters());
    }
    
}