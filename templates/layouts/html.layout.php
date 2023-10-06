<?php
include_once './templates/includes/html_header.inc.php';
fromInc("menu");
echo $pageContent['html'];
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
<ul>
    <?php 
    foreach ($pageContent["data"]['contacts'] as $key => $value) {
        ?>
        <li>
            <h4><?= $value["surname"]?></h4>
            <h5><?= $value["name"]?></h5>
        </li>
        <?php
    }
    ?>
</ul>

<?= 
include_once './templates/includes/html_footer.inc.php';
