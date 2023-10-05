'Nvmeless/framework-php-vanilla'
<?php

require_once './configs/bootstrap.php';
// ob_start();
if(isset($_GET["page"])){
    fromInc($_GET['pazazage']);
}

$pageContent = ob_get_clean();
include "./templates/layouts/". $_GET["layout"] .".layout.php";

