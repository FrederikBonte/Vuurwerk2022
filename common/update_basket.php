<?php
require_once "basket.php";
header("Content-type: text/plain");
session_start();
$product_id = $_REQUEST["product_id"];
if (array_key_exists("user_id", $_SESSION))
{
	$user = $_SESSION["name"];
}
else
{
	$user = "Dummy User";
}
$amount = 1;
if (array_key_exists("amount", $_REQUEST))
{
	$amount = $_REQUEST["amount"];
}
add_product_to_basket($product_id, $amount);

// Print the data as a json structure.
print_basket();
?>