<?php
require_once "debug.php";
require_once "database.php";

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
		<form>
			<input type="hidden" name="product_id" value="<?=$record["artikelnummer"]?>" />
		<span class="amount">
			<button name="decrease" type="submit"><span class="fa fa-minus"></span></button>
			<?=$amount?>
			<button name="increase" type="submit"><span class="fa fa-plus"></span></button>
		</span>
		</form>
	</div>
<?php
}

?>