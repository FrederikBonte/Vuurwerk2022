<?php
include "templates/header_nologin.txt";
include "common/fireworks.php";
include "common/upload_file.php";
include "common/basket.php";

if (array_key_exists("upload", $_REQUEST))
{
	$file = $_FILES["image"];
	$id = $_REQUEST["artikel_id"];
	upload_file($id, $file);
}


?>
	<h1>Fireworks</h1>
	<div id="basket">
<?php
	print_basket();
?>
	</div>
<?php

if (array_key_exists("example", $_REQUEST))
{
	print_products();
}
else
{
	print_edit_products();
}

?>
</body>
</html>