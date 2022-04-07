<?php
include "templates/header.txt";
include "common/fireworks.php";
include "common/update_article.php";

//debug_dump($_REQUEST);
//debug_dump($_SESSION);

if (array_key_exists("add_article", $_REQUEST))
{
	$name = $_REQUEST["name"];
	$price = $_REQUEST["price"];
	$description = $_REQUEST["description"];
//	debug_warning("Klant wil het artikel '$name' toevoegen.");
	add_article($name, $price, $description);
}
else if (array_key_exists("update_article", $_REQUEST))
{
	$id = $_REQUEST["article_id"];
	$name = $_REQUEST["name"];
	$price = $_REQUEST["price"];
	$description = $_REQUEST["description"];
//	debug_warning("Klant wil het artikel '$name' wijzigen.");
	update_article($id, $name, $price, $description);
}
else if (array_key_exists("remove_article", $_REQUEST))
{
	$id = $_REQUEST["article_id"];
//	debug_warning("Klant wil het artikel '$name' wijzigen.");
	remove_article($id);
}
else
{
	//debug_warning("Klant heeft nog niks gedaan.");
}


//print_fireworks_table();
//print_add_article_form();

print_change_fireworks_table();

?>
</body>
</html>