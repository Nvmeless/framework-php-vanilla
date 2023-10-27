<?php
require './vendor/autoload.php';
require './src/dbConnect.php';
use Jin\Controller\Database;


$db = new Database($connection );

var_dump($db->table('contacts')->post(['post' => [ "surname" => "Alexandre", "name" => "Delaistre", "status" => 'online']])->getQuery());
var_dump($db->table('contacts')->post(['post' => [ "surname" => "Alexandre", "name" => "Delaistre", "status" => 'online']])->do());
var_dump($db->table('contacts')->update(['post' => [ "surname" => "Valentin"], "filters" => ['name' => "Delaistre"]])->getQuery());
var_dump($db->table('contacts')->update(['post' => [ "surname" => "Valentin"], "filters" => ['name' => "Delaistre"]])->do());

// require_once './configs/bootstrap.php';
// ob_start();

// if(isset($_GET["page"])){
//     fromInc($_GET['page']);
// }

// $pageContent = [
//     "html" => ob_get_clean(),

// ];

// include "./templates/layouts/". $_GET["layout"] .".layout.php";

