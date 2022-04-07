<?php
include "basket.php";
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
if (array_key_exists("basket", $_SESSION))
{
	$basket = $_SESSION["basket"];
}
else
{
	$basket = array();
}
$present = 0;
// Loop through all elements in the basket...
for ($i=0;$i<count($basket);$i++)
{
	// Change the element using the $basket variable.
	// For each provides a copy.
	if ($basket[$i]['id']==$product_id)
	{
		// Increase the amount...
		$basket[$i]['number'] = $basket[$i]['number']+1; 
		// Store the amount found so far.
		$present = $basket[$i]['number'];
		// Stop searching...
		break;
	}
}
// When this product doesn't exist in the basket.
if ($present == 0)
{
	// Add one item of this product.
	$basket[] = array('id'=>$product_id, 'number'=>1);
}
// Update the session variable.
$_SESSION["basket"] = $basket;
// Print the data as a json structure.
print_basket();
?>