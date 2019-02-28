<?php

/*
 * This script will remove item from database
 * and return true if there are more items left
 *
 *
 * Check for POST info
 */

if(isset($_POST)){

	/*
	 * Clean ID input
	 */
	$id = key($_POST);
	$id = str_replace("_", " ", $id);
	$id = htmlentities($id, ENT_QUOTES);

	/*
	 * SQL Info
	 */
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "openlist";

	try {
		/*
		 * Prepare connection
		 */
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		/*
		 * Delete item from db
		 */
		$sql = "DELETE FROM checklist WHERE id = ? AND user = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array($id, 1));

		/*
		 * Look for more items for X user
		 */
		$sql = 'SELECT * FROM checklist WHERE user = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(1));
		$c = $stmt->rowCount();

		/*
		 * Return true with an echo
		 * if there are more items
		 * in database
		 */
		if($c == 0){
			echo 1;
		}

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

