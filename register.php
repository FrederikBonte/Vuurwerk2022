<?php
include "templates/header.txt";
include "common/update_customer.php";

if (array_key_exists("register", $_REQUEST))
{
	$name = $_REQUEST["name"];
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	
	register_customer($name, $username, $password);
}

print_register_form();
?>
</body>
</html>