<?php
/*
 * This function will load (and echo) all row elements from the database.
 */
function getListings(){
	// SQL info
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
		 * SQL to find items for X user
		 */
		$sql = 'SELECT * FROM checklist WHERE user = ? ORDER BY id DESC';
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(1));
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);

		/*
		 * Echo message if there is no result
		 */
		if(empty($r)){

			echo '<p id="noitems" style="color:#ccc; text-align:center; opacity: 1;">No items added...</p>';
		}
		/*
		 * Echo each row from database
		 */
		else {
			foreach($r as $v){

				echo '<p id="row-id-'.$v["id"].'"><input type="checkbox" onclick="checklistener('.$v["id"].');" id="checkbox-id-'.$v["id"].'"> '.$v["item"].'</p>'."\n";
			}
			// Prepare message for empty results
			echo '<p id="noitems" style="color:#ccc; text-align:center; opacity: 0;">No items added...</p>';
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
?>

<!-- Inpt to add item to list -->
<input autofocus autcomplete="off" type="text" name="newInput" id="newInput" value="" placeholder="Add new listing...">

<!-- All available listings -->
<div id="listings">
<?php getListings(); // Load all listings for user from database ?>
</div>

