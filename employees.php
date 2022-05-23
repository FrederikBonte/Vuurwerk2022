<?php
include "templates/header.txt";
include "common/database.php";
include "common/update_employee.php";
include "common/employees.php";

if (array_key_exists("add_employee", $_REQUEST))
{
	$name = $_REQUEST["name"];
	$role = $_REQUEST["role"];
	$passwd = $_REQUEST["password"];
	
	register_employee($name, $role, $passwd);
}
else if (array_key_exists("edit_employee", $_REQUEST))
{
	$id = $_REQUEST["id"];
	$name = $_REQUEST["name"];
	$role = $_REQUEST["role"];
	$passwd = $_REQUEST["password"];
	update_employee($id, $name, $role);
	if (strlen(trim($passwd))>0)
	{
		update_employee_password($id, $passwd);
	}
}
else if (array_key_exists("remove_employee", $_REQUEST))
{
	// Execute the query that shall not be named...
	remove_employee($_REQUEST["id"]);
}

print_edit_employees_table();
?>
</body>
</html>