<?php
include "templates/header.txt";
include "common/fireworks.php";
include "common/basket.php";

?>
	<div id="basket">
<?php
	print_basket();
?>
	</div>
<?php
print_products();
?>
</body>
</html>