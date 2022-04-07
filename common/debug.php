<?php
function debug_log($message)
{
	echo "<!-- $message -->\n";
}

function debug_dump($variable)
{
	echo "<pre>\n";
	print_r($variable);
	echo "</pre>\n";	
}

function debug_warning($message)
{
?>
	<p class="warning"><?=$message?></p>
<?php
}
	
function debug_error($message, $ex=null)
{
?>
	<p class="error"><?=$message?>
<?php
	if ($ex!=null)
	{
		echo $ex->getMessage();
	}
	echo "</p>\n";
	die();
}

// Create a handler function
function my_assert_handler($file, $line, $code, $desc = null)
{
	$msg = "<p>Assertion failed at $file:$line: $code";
    if ($desc) {
        $msg .= ":<br /><pre>$desc</pre>";
    }
    $msg .= "</p>";
    debug_warning($msg);
}

// Set up the callback
assert_options(ASSERT_ACTIVE,   true);
assert_options(ASSERT_BAIL,     true);
assert_options(ASSERT_WARNING,  false);
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

?>