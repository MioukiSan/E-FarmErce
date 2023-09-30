<?php
$servername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="E-FarmErce";

$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

// Check connection
if (!$conn){
    die("Maintenance Mode.");
}
define("CURRENCY","Php ");
require_once ("sql_utility_2.0.php"); 
require_once ("function.php");
session_start();


if(isset($_GET['logout'])){
    session_destroy();
    header("location: ./");
}
?>