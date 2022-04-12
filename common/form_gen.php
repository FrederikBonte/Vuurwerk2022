<?php
require_once "debug.php";

function print_button($type, $name, $text_or_icon, $script = null)
{
	$javascript = "";
	if ($script!=null)
	{
		$javascript="onclick=\"$script\"";
	}
	$content = $text_or_icon;
	if (substr($content, 0, 3) == "fa ")
	{
		$content = "<span class=\"$content\"></span>";
	}
?>
<button type="<?=$type?>" name="<?=$name?>" <?=$javascript?>><?=$content?></button>
<?php
}
?>