<?php
include "templates/header_nologin.txt";
include "common/update_article.php";

//debug_dump($_REQUEST);
//debug_dump($_SESSION);
//debug_dump($_FILES);

if (array_key_exists("upload", $_REQUEST))
{
	$uploaded = $_FILES["aoc_input"];	
	
	// Open the uploaded file directly from the temp folder.
	if ($file = fopen($uploaded["tmp_name"], "r")) {
		// While the end of the file has not been reached.
		while(!feof($file)) {
			// Get each line.
			$line = fgets($file);
			# do same stuff with the $line
			echo $line."<br />\n";
			
			$parts = explode(";", $line);		
			if ("prijs" == trim($parts[2])) // Last field contains an )(&*)(*@#!!! enter!
			{
			}
			else
			{
				add_article($parts[0], trim($parts[2]), $parts[1]);
			}
		}
		// Neatly close the temp file.
		fclose($file);
	}	
}


?>
	<h1>Fireworks</h1>
	<form method="POST" enctype="multipart/form-data">
		Advent of code : <input type="file" name="aoc_input" accept="text/plain" required /><br />
		<button type="submit" name="upload">Opslaan</button>
	</form>
<?php


?>
</body>
</html>