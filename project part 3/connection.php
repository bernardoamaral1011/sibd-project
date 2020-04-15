<?php
$host = 'db.ist.utl.pt';
$user = 'ist181216'; //Your student number
$pass = ''; //Your database passowrd, login to your server with putty to generate one
$dsn = "mysql:host=$host;dbname=$user";

try
{
	$connection = new PDO($dsn, $user, $pass);
}
catch(PDOException $exception)
{
	echo("<p>Error: ");
	echo($exception->getMessage());
	echo("</p>");
	exit();
}
?>