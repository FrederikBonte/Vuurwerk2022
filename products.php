<?php
include "templates/header.txt";
include "common/fireworks.php";
include "common/basket.php";

//debug_dump($_SESSION);

if (array_key_exists("employee", $_SESSION))
{
	print_edit_products();
}
else
{
?>
	<div id="basket">
<?php
	print_basket();
?>
	</div>
<?php
print_products();
}
?>

</body>
</html>