<?php
require './src/dbConnect.php';
require './configs/global.php';
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
    $connection->query(queryBuilder('c', 'contacts', ['name' => $_POST['name']], ['surname' => $_POST['surname']]));
}