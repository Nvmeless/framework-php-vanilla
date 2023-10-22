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
            "column" => "value"
          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value"', $database->parseParams());
    }
        public function testQueryFilters(){
        $database = new Database( );
        $payload = [
          'filters' => [
            "column" => "value",
            "column2" => true,

          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value" AND column2 = TRUE', $database->parseParams());
    }
    public function testQueryTypedFilters(){
        $database = new Database( );
        $payload = [
          'filters' => [
            "column" => "value",
            "column2" => true,
            "column3" => FALSE,
            "column4" => 2,

          ]  
          ];
          $database->post($payload);
          $this->assertEquals('column = "value" AND column2 = TRUE AND column3 = FALSE AND column4 = 2', $database->parseParams());
    }
    public function testQueryEmptyFilters(){
        $database = new Database( );
          $database->post([]);
          $this->assertEquals('1', $database->parseParams());
    }

    public function testUpdate(){
        $database = new Database( );

        $query = $database->table("Table")->update([
            'post' => [
                "name" => "Thierry",
                "surname" => 2
            ], "filters" => [
                "col" => "ent",
                "cola" => "ent"
            ]])->getQuery();
        $this->assertEquals('UPDATE Table SET name = "Thierry" , surname = 2 WHERE col = "ent" AND cola = "ent" ;', $query);
    }
    public function testUpdateNoArgs(){
        $database = new Database( );

        $query = $database->table("Table")->update([
            'post' => [
                "name" => "Thierry"
            ],
            "filters" => [
                "col" => "ent"
            ]])->getQuery();
        $this->assertEquals('UPDATE Table SET name = "Thierry" WHERE col = "ent" ;', $query);
    }
    public function testSoftDelete(){
        $database = new Database( );

        $query = $database->table("Table")->delete([
            'post' => [
                "name" => "Thierry",
                "surname" => 2
            ], 
            "filters" => [
                "col" => "ent",
                "cola" => "ent"
            ]])->getQuery();
        $this->assertEquals('UPDATE Table SET status = "offline" WHERE col = "ent" AND cola = "ent" ;', $query);
    }
    public function testSoftDeleteNoArgs(){
        $database = new Database( );

        $query = $database->table("Table")->delete([
            'post' => [
                "name" => "Thierry",
            ], 
            "filters" => [
                "col" => "ent",
            ]])->getQuery();
        $this->assertEquals('UPDATE Table SET status = "offline" WHERE col = "ent" ;', $query);
    }
    public function testGetWithoutColums(){
        $database = new Database( );

        $query = $database->table("Table")->get([
            'post' => [
                "name" => "Thierry",
                "surname" => 2
            ], "filters" => [
                "col" => "ent",
                "cola" => "ent"
            ]])->getQuery();
        $this->assertEquals('SELECT * FROM Table WHERE col = "ent" AND cola = "ent" ;', $query);
    }
    public function testGetWithoutFilters(){
        $database = new Database( );

        $query = $database->table("Table")->get([
        'post' => [
            "name" => "Thierry",
            "surname" => 2
        ], ])->getQuery();
        $this->assertEquals('SELECT * FROM Table WHERE 1 ;', $query);
    }
    public function testGetWithColumns(){
        $database = new Database( );

        $query = $database->table("Table")->get([
        'cols' => [
            "name", "id", "status"
        ], ])->getQuery();
        $this->assertEquals('SELECT name,id,status FROM Table WHERE 1 ;', $query);
    }

    public function testPost(){
        $database = new Database( );

        $query = $database->table("Table")->post([
        'post' => [
            "name" => "Thierry",
            "surname" => 2
        ], ])->getQuery();
        $this->assertEquals('INSERT INTO Table (name,surname) VALUES ("Thierry",2) ;', $query);
    }

}