<?php
require_once "debug.php";

$connString = "mysql:host=localhost;port=3306;dbname=classicmodels";
$username = "root";
$password = "usbw";

try 
{
	// Create a PDO object using the connection string with the correct username and password.
	$database = new PDO($connString, $username, $password);
	// Throw exceptions with error info when stuff fails.
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	debug_log("Database connection succeeded.");
}
catch (Exception $ex)
{
	debug_error("Failed to connect to the database : ", $ex);
}

$sql = 	"SELECT year(paymentDate) as year, month(paymentDate) as month, SUM(amount) as total ".
		"FROM `payments` ".
		"WHERE year(paymentDate) = 2004 ".
		"GROUP BY year, month ".
		"ORDER BY year, month";
		
$stmt = $database->query($sql);

?>
<svg version="1.1" width="360" height="200" xmlns="http://www.w3.org/2000/svg">
	<rect width="100%" height="100%" />
<?php
for ($i=200;$i>0;$i-=10)
{
	$width = ($i%50==0)?0.5:0.1;
?>
	<line x1="0" x2="360" y1="<?=$i?>" y2="<?=$i?>" stroke="red" stroke-width="<?=$width?>"/>
<?php
}

while (($record = $stmt->fetch(PDO::FETCH_ASSOC))!=null)
{
	$month = $record["month"];
	$x = (($month-1) * 30)+2;
	$height = $record["total"];
	$height = 200*$height/1000000;
	$y = 200-$height;
?>
	<rect class="shadow" x="<?=$x+3?>" y="<?=$y+3?>" width="26" height="<?=$height?>" />
	<rect class="shadow" x="<?=$x+2?>" y="<?=$y+2?>" width="26" height="<?=$height?>" />
	<rect class="shadow" x="<?=$x+1?>" y="<?=$y+1?>" width="26" height="<?=$height?>" />
	<rect class="bar" x="<?=$x?>" y="<?=$y?>" width="26" height="<?=$height?>" />
	<text x="<?=$x+6?>" y="<?=$y+20?>" font-size="15 text-anchor="center" fill="white"><?=$month?></text>
<?php
}
?>
</svg>
