<?php
$images_folder = "D:/temp/usbwebserver_v8.6.2/root/vuurwerk/images";

function upload_file($id, $file)
{
	$filename = copy_temp_file($file);
	
	if ($filename!=null)
	{
		update_image($id, $filename);
	}
}

function update_image($id, $filename)
{
	// There exists a database connection.
	global $database;
	
	// Design the SQL query...
	$sql = "UPDATE artikel SET plaatje = :field1 WHERE artikelnummer = :field_id";
	
	// Prepare the list of data that we need.
	$data = [
		"field_id" => $id,
		"field1" => $filename
	];
	
	try 
	{		
		// Make the database process the query...
		$stmt = $database->prepare($sql);
		// Actually run the query using the prepared data.
		if ($stmt->execute($data))
		{
			debug_log("The articles image was updated.");
		}
		else
		{
			debug_warning("The articles image was NOT updated.");
		}
	}
	catch (Exception $ex)
	{
		debug_error("Failed to update image ($filename) for article $id.", $ex);
	}
}

// Move the temp file to the actual image folder...
function copy_temp_file($file)
{
	global $images_folder;
	$temp_filename = $file["tmp_name"];
	$mime_type = $file["type"];

	// Store only the temporary name of the file.
	$filename = basename($temp_filename, ".tmp");
	
	// Only accept specific file types.
	if ($mime_type == "image/jpeg")
	{
		$filename = $filename . ".jpg";
	}
	else if ($mime_type == "image/png")
	{
		$filename = $filename . ".png";
	}
	else if ($mime_type == "image/gif")
	{
		$filename = $filename . ".gif";
	}
	else
	{
		debug_warning("Unacceptable file type : $mime_temp");
		// Unknown type of file...
		$filename = null;
	}
	
	if ($filename!=null)
	{	
		move_uploaded_file($temp_filename, "$images_folder/$filename");
	}
	
	return $filename;
}	

?>