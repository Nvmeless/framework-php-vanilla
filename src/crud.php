<?php
require_once "./src/dbConnect.php";

// Function getAll
function getAll($connection,$dbname){
    $statement = $connection->query("SELECT * FROM  $dbname  WHERE 1");
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return dd($data);
}
// getAll($connection,"contacts");


// Fonction getById
function getByID($connection,$dbname){
$statement = $connection->query("SELECT * FROM $dbname WHERE id=1");
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
return dd($data);
}
// getByID($connection,"contacts");


// Fonction create
function create($connection, $dbname, $name, $surname){
    $statement = $connection->prepare("INSERT INTO $dbname (`name`, `surname`, `status`) VALUES (?, ?, 'offline') ");
    $statement->bindParam(1,$name);
    $statement->bindParam(2,$surname);
    $data = $statement->execute();
    return dd($data);
}
// create($connection,"contacts","kenzo","lelieur");


// Fonction delete
function delete($connection, $dbname, $id){
    $statement = $connection->prepare("DELETE FROM $dbname WHERE id =?");
    $statement->bindParam(1,$id);
    $data = $statement->execute();
    return dd($data);
}
// delete($connection,"contacts",63);


// Fonction update
function update($connection,$dbname,$name,$id){
    $statement = $connection->prepare("UPDATE $dbname SET name=? WHERE id=?");
    $statement->bindParam(1,$name);
    $statement->bindParam(2,$id);
    $data = $statement->execute();

    return dd($data);
}
// update($connection,"contacts","lap",64);







