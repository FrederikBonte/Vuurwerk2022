<?php
include "templates/header.txt";
require_once "debug.php";
require_once "database.php";
require_once "update_article.php";

function testDatabase()
{
	global $database;
	
	// Confirm that there is a database object...
	assert($database!=null, "There should be a database object!");
	// Retrieve the latest error.
	$error_data = $database->errorInfo();	
	// Confirm that the error is empty.
	assert($error_data[0] == "00000", "There should not have been an error.");
}

function testTableExists($name)
{
	global $database;
	
	$sql = "SELECT * FROM $name";
	$stmt = $database->query($sql);
	assert($stmt!=null, "There should be a database response object!");
	assert($stmt->columnCount()>0, "There should be a number of columns.");
	debug_log("The table $name can be queried in the database.");
}

function testTables()
{
	testTableExists("artikel");
	testTableExists("bestelling");
	testTableExists("klant");
	testTableExists("bestelling_artikel");
	debug_warning("All tables are present.");
}

function testEverything()
{
	testDatabase();
	testTables();
	testAddArticle();
	debug_warning("Unittest finished.");
}

function testAddArticle()
{
	$id = add_article("Fnork", 3.75);
	debug_warning("A new article was added with id $id.");
}

?>
</body>
</html>