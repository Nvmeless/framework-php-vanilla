<?php

require_once './configs/bootstrap.php';
ob_start();
if(isset($_GET["page"])){
    fromInc($_GET['page']);
}
$contacts = $connection->query(queryBuilder('r', 'contacts'));
$pageContent = [
    "html" => ob_get_clean(),
    "data" => [
        'contacts' => $contacts
    ]
];

include "./templates/layouts/". $_GET["layout"] .".layout.php";

