<?php
require_once '../shared/PDO_Connector.php';
require_once '../model/DBManager.php';
// create the connection to the db
$dbh = PDO_Connector::get_connection ();
// create the object DBManager
$dbm = new DBManager ( $dbh );
// create two array for save the data for axis x and y
$temp_y = array ();
$data_x = array ();
try {
	// recovery the temperature values
	$query_select = $dbm->select_temperature ( $temperature );
} catch ( Exception $ex ) {
	print "Error";
}
// read the result of the select and save temperature and date
foreach ( $query_select as $row ) {
	array_push ( $temp_y, $row ['Temperature'] );
	array_push ( $data_x, $row ['Date'] );
}
// converts the array elements into a string
$labels_x = implode ( '","', $data_x );
$values_y = implode ( ",", $temp_y );
?>