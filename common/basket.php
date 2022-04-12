<?php
require_once "debug.php";
require_once "database.php";
require_once "form_gen.php";

function add_product_to_basket($product_id, $amount = 1)
{
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
	// & is required to be able to change on of the items.
	foreach ($basket as $i=>&$item)
	{
		// Change the element using the $basket variable.
		// For each provides a copy.
		if ($item['id']==$product_id)
		{
			// Increase the amount...
			$item['number'] += $amount; 
			// Store the amount found so far.
			$present = $item['number'];
			if ($present<=0) 
			{
				unset($basket[$i]);
			}
			// Stop searching...
			break;
		}
	}
	// Stop referencing the array...
	unset($item);
	// When this product doesn't exist in the basket.
	if ($present == 0 && $amount>0)
	{
		// Add one item of this product.
		$basket[] = array('id'=>$product_id, 'number'=>$amount);
	}
	// Update the session variable.
	$_SESSION["basket"] = $basket;
}

function print_basket()
{
	if (array_key_exists("basket", $_SESSION))
	{		
		foreach ($_SESSION["basket"] as $product)
		{
			print_edit_basket($product['id'], $product['number']);
		}
	}
	else
	{
?>
	<h2>Basket is empty</h2>
<?php
	}
}

function print_edit_basket($product_id, $amount)
{
	// There is a database.
	global $database;
	
	$sql = "SELECT artikelnummer, naam, omschrijving, ROUND(prijs,2) as prijs, plaatje FROM artikel WHERE artikelnummer=:field_id";
	debug_log($sql);
	
	$data = [
		"field_id" => $product_id
	];
	
	try
	{	
		$stmt = $database->prepare($sql);
		if ($stmt->execute($data))
		{
			$count = 0;
			// Retrieve each record separately.
			$record = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($record)
			{
				print_edit_basket_product($record, $amount);
			}
			else 
			{
				debug_warning("Unknown product id in basket: $product_id");
			}
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

function print_edit_basket_product($record, $amount)
{
?>
	<div id="<?=$record['id']?>">
		<h2><?=$record["naam"]?></h2>
		<span class="price">Prijs: <?=$record['prijs']?></span><br />
		<span class="amount">
<?php
print_button("button", "decrease", "fa fa-minus", "on_add_basket(".$record["artikelnummer"].", -1)");
echo "$amount\n";
print_button("button", "increase", "fa fa-plus", "on_add_basket(".$record["artikelnummer"].", 1)");
?>
		</span>
	</div>
<?php
}

?>