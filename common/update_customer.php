<?php
require_once "debug.php";
require_once "database.php";
require_once "common/form_gen.php";

function print_register_form()
{
?>
<form method="POST">
	Naam : <input type="text" name="name" required /><br />	
	Inlognaam : <input type="text" name="username" /><br />	
	Wachtwoord : <input type="password" name="password" required /><br />	
<?php
	print_button("submit", "register", "Registreren");
	print_button("reset", null, "Reset");
?>	
</form>
<?php	
}

function print_login_form()
{
?>
<form method="POST">
	Inlognaam : <input type="text" name="username" /><br />	
	Wachtwoord : <input type="password" name="password" required /><br />	
<?php
	print_button("submit", "login", "Inloggen");
	print_button("reset", null, "Reset");
?>	
</form>
<?php	
}

// BELOW ARE THE ACTUAL DATABASE FUNCTIONS

function register_customer($name, $username, $passwd)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	// SALT is provided because otherwise the "field may not be null" check is triggered.
	$sql = "INSERT INTO klant (naam, username, password, salt) VALUES (:field1, :field2, :field3, 1)";
	
	// Prepare the list of data that we need.
	$data = [
		"field1" => $name,
		"field2" => $username,
		"field3" => $passwd
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("A new customer was added to the database.");
			return $database->lastInsertId();
		}
		else
		{
			debug_warning("The database refuses to add a customer.");
			return -1;
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to add customer to the database.", $ex);
	}
}

function check_user_login($username, $passwd)
{
	// There is a database.
	global $database;
	
	$sql = "SELECT * FROM klant WHERE username = :field1 AND MD5(CONCAT(:field2, salt)) = password;";
	debug_log($sql);
	
	// Prepare the list of data that we need.
	$data = [
		"field1" => $username,
		"field2" => $passwd
	];	
	
	try
	{	
		$stmt = $database->prepare($sql);
		if ($stmt->execute($data))
		{
			// Retrieve each record separately.
			if (($record = $stmt->fetch(PDO::FETCH_ASSOC))!=null) 
			{
				// Recognise the user!
				$_SESSION["name"] = $record["naam"];
				$_SESSION["user_id"] = $record["klantnummer"];
				// $_SESSION["korting"] = $record["korting"];
				// Report that we found the user.
				return true;
			}
			else 
			{
				return false;
			}
		}
		else
		{
			debug_warning("The database refuses to check the customers credentials.");
			return false;
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to read customer credentials.", $ex);
		return false;
	}
}
?>