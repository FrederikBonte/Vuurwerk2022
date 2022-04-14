<?php
require_once "debug.php";
require_once "database.php";
require_once "common/form_gen.php";

function print_add_employee_form()
{
?>
<form method="POST">
	Naam : <input type="text" name="name" required /><br />	
	Wachtwoord : <input type="password" name="password" required /><br />	
<?php
	print_button("submit", "register", "Registreren");
	print_button("reset", null, "Reset");
?>	
</form>
<?php	
}

// BELOW ARE THE ACTUAL DATABASE FUNCTIONS

function register_employee($name, $passwd)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	// SALT is provided because otherwise the "field may not be null" check is triggered.
	$sql = "INSERT INTO medewerker (naam, password, salt) VALUES (:field1, :field2, :field3, 1)";
	
	// Prepare the list of data that we need.
	$data = [
		"field1" => $name,
		"field3" => $passwd
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("A new employee was added to the database.");
			return $database->lastInsertId();
		}
		else
		{
			debug_warning("The database refuses to add an employee.");
			return -1;
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to add employee to the database.", $ex);
	}
}

function check_employee_login($number, $passwd)
{
	// There is a database.
	global $database;
	
	$sql = "SELECT * FROM medewerker WHERE id = :field1 AND MD5(CONCAT(:field2, salt)) = password;";
	debug_log($sql);
	
	// Prepare the list of data that we need.
	$data = [
		"field1" => $number,
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
				$_SESSION["user_id"] = $record["id"];
				$_SESSION["employee"] = $record["role"];
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
			debug_warning("The database refuses to check the employees credentials.");
			return false;
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to read employee credentials.", $ex);
		return false;
	}
}
?>