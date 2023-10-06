<ul>
    <?php 
    require_once './src/crud.php';
    $data = $connection->query(queryBuilder('r', 'contacts'));
    foreach ( $data as $key => $value) {
        ?>
        <li>
            <h4><?= $value["surname"]?></h4>
            <h5><?= $value["name"]?></h5>
        </li>
        <?php
    }
    ?>
</ul>