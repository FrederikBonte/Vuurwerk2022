<?php
require_once "debug.php";

$connString = "mysql:host=localhost;port=3306;dbname=vuurwerk";
$username = "root";
$password = "usbw";

try 
{
	// Create a PDO object using the connection string with the correct username and password.
	$database = new PDO($connString, $username, $password);
	// Throw exceptions with error info when stuff fails.
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	debug_log("Database connection succeeded.");
}
catch (Exception $ex)
{
	debug_error("Failed to connect to the database : ", $ex);
}

?>