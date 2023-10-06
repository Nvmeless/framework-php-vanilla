<?php 
require_once "./src/dbConnect.php";



//fonction getAll
$statement = $connection->query("SELECT * FROM contacts WHERE 1");
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
//fonction getById
$statement = $connection->query("SELECT * FROM contacts WHERE `name` =  'Delaistre' AND `surname` = '".htmlspecialchars( $_GET["surname"])."'");
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
//fonction create 
$statement = $connection->prepare("INSERT INTO `contacts` (`name`, `surname`, `status`) VALUES (?, ?, 'online') ");
$statement->bindParam(1,$_GET["name"]);
$statement->bindParam(2,$_GET["surname"]);
$statement->execute();

//fonction delete
$statement = $connection->prepare("DELETE FROM `contacts` WHERE id = ?");
$id = 3;
$statement->bindParam(1, $id);
$statement->execute();
//fonction update

$statement = $connection->prepare("UPDATE `contacts` SET `status` = 'offline' WHERE id = ?");
$id = 2;
$statement->bindParam(1, $id);
$statement->execute();