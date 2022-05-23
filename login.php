<?php
include "templates/header_nologin.txt";
include "common/update_customer.php";
include "common/update_employee.php";

session_start();

if (array_key_exists("login", $_REQUEST))
{
	//debug_dump($_REQUEST);
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	
	if (check_user_login($username, $password))
	{
		//echo "<h2>Joepie klant ingelogd!</h2>";
		header("Location: index.php");
	}
	else if (check_employee_login($username, $password))
	{
		//echo "<h2>Joepie medewerker ingelogd!</h2>";
		header("Location: index.php");
	}
	else
	{
		echo "<h3>Probeer het anders nog eens...</h3>";
	}
}

print_login_form();
?>
</body>
</html>