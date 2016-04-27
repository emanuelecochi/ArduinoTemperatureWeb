<?php 
require_once '../shared/PDO_Connector.php';
require_once '../model/DBManager.php';
// extract the temperature value from the carrier GET
$temperature = filter_input(INPUT_GET, 'temperature');
// create the connection to the db
$dbh = PDO_Connector::get_connection();
// create the object DBManager
$dbm = new DBManager($dbh);
try {
	// save the temperature value on the db
	$dbm->save_temperature($temperature);
} catch (Exception $ex) {
	print "Error";
}
?>
