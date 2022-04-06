<?php

$server="localhost";
$user="root";
$password ="root";
$db="cricket";



$mysqli = new mysqli($server,$user,$password,$db);

mysqli_report(MYSQLI_REPORT_ALL);


?>