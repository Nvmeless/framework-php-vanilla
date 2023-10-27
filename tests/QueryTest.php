<?php 
use PHPUnit\Framework\TestCase;
use Jin\Controller\Database;
class QueryTest extends TestCase {

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
            $this->assertEquals('`name` = "Delaistre" AND `age` = 26', $db->get(['filters' => ["name" => "Delaistre", "age" => 26]])->parseParams());
            $this->assertEquals('`name` = "Delaistre" AND `age` = 26', $db->get(['filters' => ["name" => "Delaistre", "age" => 26]])->parseParams());
            $this->assertEquals('`name` = "Delaistre" AND `age` = 26', $db->get(['filters' => ["name" => "Delaistre", "age" => 26]])->parseParams());
 
    }
    public function testTable(){
        $database = new Database();
        $tableName = "table";
        $database->table($tableName);
        $this->assertEquals($tableName, $database->getTable());
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
}