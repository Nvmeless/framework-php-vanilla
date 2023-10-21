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
    public function testQueryFilter(){
        $database = new Database( );
        $payload = [
          'filters' => [
            ["column" => "value"]
          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value"', $database->getFilters());
    }
        public function testQueryFilters(){
        $database = new Database( );
        $payload = [
          'filters' => [
            ["column" => "value"],
            ["column" => true],

          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value" AND column = TRUE', $database->getFilters());
    }
    public function testQueryTypedFilters(){
        $database = new Database( );
        $payload = [
          'filters' => [
            ["column" => "value"],
            ["column" => true],
            ["column" => FALSE],
            ["column" => 2],

          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value" AND column = TRUE AND column = FALSE AND column = 2', $database->getFilters());
    }
    public function testQueryEmptyFilters(){
        $database = new Database( );
          $database->post([]);
          $this->assertEquals('', $database->getFilters());
    }

    
}