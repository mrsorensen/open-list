<?php

/*
 * This script inserts a new item to the database
 * and returns the ID of the last inserted item
 *
 *
 * Check for POST info
 */
if(isset($_POST)){

	/*
	 * Clean text input
	 */
	$text = key($_POST);
	$text = str_replace("_", " ", $text);
	$text = htmlentities($text, ENT_QUOTES);

	/*
	 * SQL Info
	 */
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "openlist";

	try {
		/*
		 * Prepares connection
		 */
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		/*
		 * Inserts item to db
		 */
		$sql = "INSERT INTO checklist(user, item) VALUES(?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(1, $text));

		/*
		 * Returns last inserted ID
		 */
		echo $conn->lastInsertId();

	}
	/*
	 * Catch error
	 */
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
	/*
	 * Kill connection
	 */
	$conn = null;

}

