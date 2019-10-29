<?php 
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$dbname = "astro";
$dbuser = "root";
$dbpass = "";
$dbserver = "localhost";

$conecta = mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db("$dbname") or die(mysql_error());
?>