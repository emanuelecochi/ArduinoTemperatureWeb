<?php
require_once 'Logger.php';
require_once 'Temperature_Config.php';

/**
 * This class allows of connection to the db through the PDO
 */

class PDO_Connector {
	private static $connection = null;
	private function __construct() {
		try {
			self::$connection = new PDO ( "mysql:host=" . Talk_Config::_HOSTNAME . ";dbname=" . Talk_Config::_DBNAME, Talk_Config::_DBUSER, Talk_Config::_DBPASSWORD );
		} catch ( PDOException $ex ) {
			self::$connection = null;
			Logger::log ( $ex->getCode (), $ex->getMessage () );
		}
	}

	// get_connection() instantiates the builder and creates the connection
	public static function get_connection() {
		if (self::$connection == NULL)
			new PDO_Connector ();
		return self::$connection;
	}
}
