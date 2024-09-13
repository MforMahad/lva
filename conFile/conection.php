<?php

// session_start();

$conn = mysqli_connect("localhost", "root", "", "lva_db");

if (mysqli_connect_error()) {
   echo "<script>alert('databese is not connected')</script>";


} else {

   //   echo"connected successfully";
}

//DB credentials.
// define('DB_HOST','localhost');
// define('DB_USER','root');
// define('DB_PASS','');
// define('DB_NAME','lva_db');
// //Establish database connection.
// try
// {
// $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
// }
// catch (PDOException $e)
// {
// exit("Error: " . $e->getMessage());
// }
?>