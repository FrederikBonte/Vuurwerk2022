<?php
require_once "debug.php";

function print_button($type, $name, $text_or_icon)
{
	$content = $text_or_icon;
	if (substr($content, 0, 3) == "fa ")
	{
		$content = "<span class=\"$content\"></span>";
	}
?>
<button type="<?=$type?>" name="<?=$name?>"><?=$content?></button>
<?php
}
?>