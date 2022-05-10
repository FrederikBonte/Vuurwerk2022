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
