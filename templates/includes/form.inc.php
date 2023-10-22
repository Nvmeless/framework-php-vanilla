<?php
require './src/dbConnect.php';
require './configs/global.php';
use Jin\Controller\Database;

echo "ZONE TEST <br/>";
$database = new Database($connection);

// $database->post([])->
var_dump( $database->table("contacts")->update([
  'post' => [
    "name" => "El Titoune",
], 'filters' => [
  "surname" => "Lopez" 
]])->do());

echo "<br/>";
echo "FIN ZONE TEST <br/>";
?>
<form action="#" method="post">
  <ul>
    <li>
      <label for="name">Nom du pelo&nbsp;:</label>
      <input type="text" id="name" name="name" />
    </li>
    <li>
      <label for="surname">Prénom du pelo&nbsp;:</label>
      <input type="text" id="surname" name="surname" />
    </li>

  </ul>
  <input type="submit" value="Ajouter un Pelo" />
</form>

<?php 
if(isset($_POST['name']) && isset($_POST['surname'])){
    // $connection->query(queryBuilder('c', 'contacts', ['name' => $_POST['name']], ['surname' => $_POST['surname']]));
$database->post([
  'post' => [
    "name" => $_POST['name'],
    "surname" => $_POST['surname'],
    "status" => "online"
]])->do();
  }