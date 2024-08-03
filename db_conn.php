<?php

$sname = "localhost";
$unmae = "root";
$password = "";

$db_name = "testwarnet";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    echo "Conecction Failed!";
}