<?php
require './src/dbConnect.php';
require './configs/global.php';
?>
<form action="/" method="post">
  <ul>
    <li>
      <label for="name">Nom&nbsp;:</label>
      <input type="text" id="name" name="name" />
    </li>
    <li>
      <label for="surname">prenom&nbsp;:</label>
      <input type="text" id="surname" name="surname" />
    </li>

  </ul>
</form>

