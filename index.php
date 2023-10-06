'Nvmeless/framework-php-vanilla'
<?php

require_once './configs/bootstrap.php';
// ob_start();
if(isset($_GET["page"])){
    fromInc($_GET['page']);
}
//hello
$pageContent = [
    "html" => ob_get_clean()
    "data" => []
];

if(isset($_GET["layout"])){
include "./templates/layouts/". $_GET["layout"] .".layout.php";
}


