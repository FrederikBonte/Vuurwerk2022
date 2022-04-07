<?php
require_once "database.php";
//@TODO: Include and use the proper debug functions.

function print_fireworks_table()
{
	// There is a database.
	global $database;
	
	$sql = "SELECT artikelnummer, naam, omschrijving, ROUND(prijs,2) as prijs FROM artikel";
	debug_log($sql);
	
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
				print_fireworks_tr($record);
			}
			
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

function print_fireworks_tr($record)
{
?>
	<tr>
		<td><?=$record["artikelnummer"]?></td>
		<td><?=$record["naam"]?></td>
		<td><?=$record["omschrijving"]?></td>
		<td><?=$record["prijs"]?></td>
	</tr>
<?php
}

function print_products($user_id = null)
{
	// There is a database.
	global $database;
	
	$sql = "SELECT artikelnummer, naam, omschrijving, ROUND(prijs,2) as prijs, plaatje FROM artikel";
	debug_log($sql);
	
	try
	{	
		$stmt = $database->prepare($sql);
		if ($stmt->execute())
		{
			// Retrieve each record separately.
			while (($record = $stmt->fetch(PDO::FETCH_ASSOC))!=null) 
			{
				print_product_div($record, $user_id);
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

function print_edit_products()
{
	// There is a database.
	global $database;
	
	$sql = "SELECT artikelnummer, naam, omschrijving, ROUND(prijs,2) as prijs, plaatje FROM artikel";
	debug_log($sql);
	
	try
	{	
		$stmt = $database->prepare($sql);
		if ($stmt->execute())
		{
			$count = 0;
?>
	<table id="products">
	<tr>
<?php			
			// Retrieve each record separately.
			while (($record = $stmt->fetch(PDO::FETCH_ASSOC))!=null) 
			{
				$count++;
				echo "\t<td>\n";
				print_edit_product_div($record);
				echo "\t</td>\n";
				if ($count%3==0)
				{
					echo "\t</tr><tr>\n";
				}
			}
?>
	</tr>
	</table>
<?php			
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

function print_edit_product_div($record)
{
?>
	<div class="product" onclick="on_add_basket(<?=$record["artikelnummer"]?>, <?=($user_id==null)?0:$user_id?>)>
		<h2><?=$record["naam"]?></h2>
<?php
	if ($record["plaatje"]!=null)
	{
?>
		<img src="images/<?=$record["plaatje"]?>" />
<?php
	}
	else
	{
?>
		<img src="images/no_image.png" />
<?php
	}
?>		
		<form method="POST" enctype="multipart/form-data">
			<input type="hidden" name="artikel_id" value="<?=$record["artikelnummer"]?>" />
			Naam: <input type="text" name="naam" value="<?=$record['naam']?>" /><br />
			Omschr.: <input type="text" name="description" value="<?=$record['omschrijving']?>" /><br />
			Prijs: <input type="number" name="price" value="<?=$record['prijs']?>" /><br />
			<button type="submit" name="upload">Wijzigen</button><br />
			Plaatje wijzigen <input type="file" name="image" accept="image/png, image/gif, image/jpeg" required /><br />
			<button type="submit" name="upload">Opslaan</button>
		</form>
	</div>
<?php
}

function print_product_div($record, $user_id)
{
?>
	<div class="product" onclick="on_add_basket(<?=$record["artikelnummer"]?>, <?=($user_id==null)?0:$user_id?>)">
		<h2><?=$record["naam"]?></h2>
<?php
	if ($record["plaatje"]!=null)
	{
?>
		<img src="images/<?=$record["plaatje"]?>" />
<?php
	}
	else
	{
?>
		<img src="images/no_image.png" />
<?php
	}
?>		
		<p><?=$record['omschrijving']?></p>
		<span class="price"><?=$record["prijs"]?></span>
	</div>
<?php
}


?>