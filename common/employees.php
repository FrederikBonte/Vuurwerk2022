<?php
require_once "debug.php";
require_once "database.php";
require_once "form_gen.php";

class Employees 
{
	private $records;
	private $database;
	
	public function __construct($database)
	{
		$this->database = $database;
		// Read all the records...
		$sql = "SELECT id, naam, rol from medewerker";
		try 
		{			
			$stmt = $this->database->query($sql);
			$this->records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (Exception $ex)
		{
			debug_error("Failed to read employees.", $ex);
		}
	}
	
	public function print_select_employee($selected_id = -1)
	{
//		debug_dump($this->records);
?>
		<select name="employee">
<?php
		$this->print_option(-1, "Selecteer een medewerker", "selected disabled");
		foreach ($this->records as $record) 
		{
			// Store the id of this option.
			$id = $record["id"];
			// Is this option selected?
			$is_selected = ($id==$selected_id)?"selected":"";
			// Store the display name of this option.
			$name = $record["naam"]." (".$record["rol"].")";
			// Print each option.
			$this->print_option($id, $name, $is_selected);
		}
?>		
		</select>
<?php
	}
	
	private function print_option($id, $name, $is_selected)
	{
?>
			<option value="<?=$id?>" <?=$is_selected?> ><?=$name?></option>
<?php			
	}
	
	public function get_role($employee_id)
	{
		return null;
	}
	
	/// Update employee functions go here...
}

function print_edit_employees_table()
{
	// Let the database PDO be known...
	global $database;
	
	$sql = "SELECT * FROM medewerker";
	
?>
	<table>
		<tr>
			<th>Nummer</th>
			<th>Naam</th>
			<th>Rol</th>
			<th>Wachtwoord</th>
			<th>Acties</th>
		</tr>
<?php
	
	try {
		// Execute the query...
		$stmt = $database->query($sql);
	
		// Loop through all the records...
		foreach ($stmt as $record)
		{
			// Print a form (tr) per record.
			print_edit_employee_tr($record);
		}
	} 
	catch (Exception $ex)
	{
		debug_error("Failed to read employees! Please inform the administrator.", $ex);
	}

	print_add_employee_tr();
?>
	</table>
<?php
}

function print_edit_employee_tr($record)
{
?>
		<tr><form method="POST">
			<td>
				<input type="hidden" name="id" value="<?=$record["id"]?>" /><?=$record["id"]?>
			</td>
			<td>
				<input type="text" name="name" value="<?=$record["naam"]?>" required />
			</td>
			<td>
<?php
	print_select_role($record["rol"]);
?>			
			</td>
			<td>
				<input type="password" name="password" value="" />
			</td>
			<td>
				<button type="submit" name="edit_employee"><span class="fa fa-save"></span></button>
				<button type="submit" name="remove_employee"><span class="fa fa-trash"></span></button>
			</td>
		</form></tr>
<?php
}

function print_add_employee_tr()
{
?>
		<tr><form method="POST">
			<td>Automatisch</td>
			<td>
				<input type="text" name="name" required />
			</td>
			<td>
<?php
	print_select_role();
?>			
			</td>
			<td>
				<input type="password" name="password" required/>
			</td>
			<td>
				<button type="submit" name="add_employee"><span class="fa fa-plus"></span></button>
			</td>
		</form></tr>
<?php
}

function print_select_role($selected_role = null)
{
	$s1 = "";
	$s2 = "";
	if ($selected_role=="medew")
	{
		$s2 = "selected";
	}
	else if ($selected_role=="admin")
	{
		$s1 = "selected";
	}
?>
	<select name="role" required>
		<option value="nobody" selected disabled>Kies een rol</option>
		<option value="medew" <?=$s2?>>Medewerker</option>
		<option value="admin" <?=$s1?>>Administrator</option>
	</select>
<?php
}
?>
