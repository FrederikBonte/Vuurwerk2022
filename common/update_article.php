<?php
require_once "debug.php";
require_once "database.php";

function print_add_article_form()
{
?>
<form method="GET">
	Naam : <input type="text" name="name" placeholder="Naam van het vuurwerk" required /><br />	
	Omschrijving : <input type="textarea" name="description" placeholder="Beschrijf het soort vuurwerk" required /><br />	
	Prijs : <input type="number" name="price" placeholder="Prijs van het artikel" min="0.10" step="0.01" required /><br />	
	<input type="submit" name="add_article" value="Toevoegen" />
	<input type="reset" />
</form>
<?php
}

function print_add_firework_form_tr()
{
?>
	<tr>
	<form method="GET">
		<td></td>
		<td><input type="text" name="name" placeholder="Naam van het vuurwerk" required /></td>	
		<td><input type="textarea" name="description" placeholder="Beschrijf het soort vuurwerk" required /></td>
		<td><input type="number" name="price" placeholder="Prijs van het artikel" min="0.10" step="0.01" required /></td>
		<td>
		<button type="submit" name="add_article"><span class="fa fa-plus"></span></button>
		<button type="reset" ><span class="fa fa-undo"></span></button>
		</td>
	</form>
	</tr>
<?php
}

function print_change_article_form($record)
{
?>
<form method="GET">
	<input type="hidden" name="article_id" value="<?=$record['artikelnummer']?>" />
	Naam : <input type="text" name="name" value="<?=$record['naam']?>" required /><br />	
	Omschrijving : <input type="textarea" name="description" value="<?=$record['omschrijving']?>" /><br />	
	Prijs : <input type="number" name="price" value="<?=$record['prijs']?>" min="0.10" step="0.01" required /><br />	
	<input type="submit" name="add_article" value="Toevoegen" />
	<input type="submit" name="cancel_article" value="Cancel" />
	<input type="reset" />
</form>
<?php	
}

function print_change_firework_form_tr($record)
{
?>
	<tr>
		<form method="GET">
		<td><input type="hidden" name="article_id" value="<?=$record['artikelnummer']?>" /><?=$record['artikelnummer']?></td>
		
		<td><input type="text" name="name" value="<?=$record['naam']?>" required /></td>
		<td><input type="textarea" name="description" value="<?=$record['omschrijving']?>" /></td>
		<td><input type="number" name="price" value="<?=$record['prijs']?>" min="0.10" step="0.01" required /></td>
		<td>
			<button type="submit" name="update_article"><span class="fa fa-pencil"></span></button>
			<button type="reset" ><span class="fa fa-undo"></span></button>
			<button type="submit" name="remove_article" ><span class="fa fa-trash"></span></button>
		</td>
		</form>
	</tr>
<?php	
}

function print_change_fireworks_table()
{
	// There is a database.
	global $database;
	
	$sql = "SELECT artikelnummer, naam, omschrijving, ROUND(prijs,2) as prijs FROM artikel WHERE deleted = 0";
	echo "<!-- $sql -->";
	
	try
	{	
		$stmt = $database->prepare($sql);
		if ($stmt->execute())
		{
			// Read all the records...
			echo "<h1>Fireworks!!!</h1>";
?>	
		<table>
			<tr>
				<th>id</th>
				<th>naam</th>
				<th>omschrijving</th>
				<th>prijs</th>
			</tr>
<?php
			
			// Retrieve each record separately.
			while (($record = $stmt->fetch(PDO::FETCH_ASSOC))!=null) 
			{
				print_change_firework_form_tr($record);
			}
			
			print_add_firework_form_tr();
			
			echo "</table>";		
		}
		else
		{
			echo "Database refuses to supply fireworks data.";
		}
	}
	catch (Exception $ex) 
	{
		echo "Failed to read fireworks : ".$ex->getMessage();
	}
}

/// BELOW ARE THE FUNCTIONS THAT CHANGE THE DATABASE

function add_article($name, $price, $description=null)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	$sql = "INSERT INTO artikel (naam, prijs, omschrijving) VALUES (:field1, :field2, :field3)";
	
	// Prepare the list of data that we need.
	$data = [
		"field1" => $name,
		"field2" => $price,
		"field3" => $description
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("A new article was added to the database.");
			return $database->lastInsertId();
		}
		else
		{
			debug_warning("The database refuses to add an acticle.");
			return -1;
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to add article to the database.", $ex);
	}
}

function update_article($id, $name, $price, $description=null)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	$sql = "UPDATE artikel SET naam = :field1, prijs = :field2, omschrijving = :field3 WHERE artikelnummer = :field_id";
	
	// Prepare the list of data that we need.
	$data = [
		"field_id" => $id,
		"field1" => $name,
		"field2" => $price,
		"field3" => $description		
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("The article $id was changed in the database.");
		}
		else
		{
			debug_warning("The database refuses to change an acticle.");
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to change an article in the database.", $ex);
	}
}

function remove_article($id)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	$sql = "UPDATE artikel SET deleted = true WHERE artikelnummer = :field_id";
	
	// Prepare the list of data that we need.
	$data = [
		"field_id" => $id
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("The article $id was removed from the database.");
		}
		else
		{
			debug_warning("The database refuses to remove the acticle.");
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to remove an article from the database.", $ex);
	}
}
?>