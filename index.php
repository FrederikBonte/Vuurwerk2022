<?php
include "templates/header.txt";
include "templates/welkom.txt";
?>
<!--<svg version="1.1" width="300" height="200" xmlns="http://www.w3.org/2000/svg">
  <rect width="100%" height="100%"/>
  <circle cx="150" cy="100" r="80"/>
  <text x="150" y="125" font-size="60" text-anchor="middle" fill="white">SVG</text>
</svg>
<br />-->
<?php
//include "common/chart.php";
	var_dump($_REQUEST);
	
if (array_key_exists("login", $_REQUEST))
{
	$name = $_REQUEST["name"];
	echo "Gebruiker '$name' wil inloggen...";
	// Haal data uit request:
	
	do_stuff($id, $name);
}	
else if (array_key_exists("kill", $_REQUEST))
{
	$name = $_REQUEST["name"];
	echo "Gebruiker '$name' wil iets verwijderen...";
}
else if (array_key_exists("blaat", $_REQUEST))
{
	$name = $_REQUEST["name"];
	echo "Gebruiker '$name' wil blaten...";
}
	
?>


<form method="POST">
	<label for="name">Naam:</label>
	<input type="text" name="name" value="John" /><br />
	
	<label for="password">Wachtwoord:</label>
	<input type="password" name="password" value="Geheim1234!" /><br />
	
	<br />
    <input type="submit" name="login" value="Inloggen" />
    <input type="submit" name="kill" value="Verwijderen" />
</form>

<form>
	<label for="name">Naam:</label>
	<input type="text" name="name" value="John" /><br />
	
	<label for="password">Wachtwoord:</label>
	<input type="password" name="password" value="Geheim1234!" /><br />
	
	<br />
    <input type="submit" name="blaat" value="Blaten" />
</form>
</body>
</html>