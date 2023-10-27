<?php
use PHPUnit\Framework\TestCase;
use Jin\Controller\Database;
class QueryTest extends TestCase{
    public function testMethod(){
        $db = new Database();
        $this->assertEquals("get", $db->get([])->getMethod());
        $this->assertEquals("post", $db->post([])->getMethod());
        $this->assertEquals("update", $db->update([])->getMethod());
        $this->assertEquals("delete", $db->delete([], true)->getMethod());
        $this->assertEquals("soft-delete", $db->delete([])->getMethod());

        //5 asssertions, une par methode
    }
    public function testFormat(){
            $db = new Database();
            $this->assertEquals("SELECT %s FROM %s WHERE %s ;", $db->get([])->getFormat());
            $this->assertEquals("INSERT INTO %s %s VALUES %s ;", $db->post([])->getFormat());
            $this->assertEquals("UPDATE %s SET %s WHERE %s ;", $db->update([])->getFormat());
            $this->assertEquals("DELETE FROM %s WHERE %s;", $db->delete([], true)->getFormat());
            $this->assertEquals("UPDATE %s SET %s WHERE %s ;", $db->delete([])->getFormat());
 
    }
    public function testParamsListing(){
            $db = new Database();
            $this->assertEquals('`name` = "Delaistre" AND `age` = 26', $db->get(['filters' => ["name" => "Delaistre", "age" => 26]])->parseParams());
            $this->assertEquals('`name` = "Delaistre" AND `age` = 26', $db->get(['post' => ["name" => "Delaistre", "age" => 26]])->parseParams("post"));
 
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
          $this->assertEquals('`column` = "value"', $database->parseParams());
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
          $this->assertEquals('`column` = "value" AND `column2` = TRUE', $database->parseParams());
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
          $this->assertEquals('`column` = "value" AND `column2` = TRUE AND `column3` = FALSE AND `column4` = 2', $database->parseParams());
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
        $this->assertEquals('UPDATE Table SET `name` = "Thierry"  ,  `surname` = 2 WHERE `col` = "ent" AND `cola` = "ent" ;', $query);
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
        $this->assertEquals('UPDATE Table SET `name` = "Thierry" WHERE `col` = "ent" ;', $query);
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
        $this->assertEquals('UPDATE Table SET `status` = "offline" WHERE `col` = "ent" AND `cola` = "ent" ;', $query);
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
        $this->assertEquals('UPDATE Table SET `status` = "offline" WHERE `col` = "ent" ;', $query);
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
        $this->assertEquals('SELECT * FROM Table WHERE `col` = "ent" AND `cola` = "ent" ;', $query);
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
        $this->assertEquals('SELECT `name` , `id` , `status` FROM Table WHERE 1 ;', $query);
    }

    public function testPost(){
        $database = new Database( );

        $query = $database->table("Table")->post([
        'post' => [
            "name" => "Thierry",
            "surname" => 2
        ], ])->getQuery();
        $this->assertEquals('INSERT INTO Table (`name` , `surname`) VALUES ("Thierry" , 2) ;', $query);
    }

}