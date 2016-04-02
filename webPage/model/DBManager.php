<?php 
require_once '../shared/Logger.php';

class DBManager {
	private $dbh;
	const _SAVE_TEMPERATURE = "INSERT INTO Arduino_Temperature(Temperature) VALUES(:temperature)";
	const _SELECT_TEMPERATURE = "SELECT Temperature, date_format(TimeSave, '%k:%i') Date FROM `Arduino_Temperature` order by id_temperature";
	
	public function __construct($conn) {
		$this->dbh = $conn;
	}
	/**
	 * This function saves the temperature value on the db 
	 * @param string $temperature
	 * @throws Exception is used in case of exception
	 */
	public function save_temperature($temperature) {
		try {
			$stmt = $this->dbh->prepare(self::_SAVE_TEMPERATURE);
			$stmt->bindParam(":temperature",$temperature,PDO::PARAM_STR);
			$stmt->execute();
			
		} catch (PDOException $ex) {
			Logger::log($ex->getCode(), $ex->getMessage());
			throw new Exception("Failed save temperature");
		}
	}
	
	/**
	 * This function recovers the temperature values
	 * @throws Exception is used in case of exception
	 * @return $result is a array with the result of the query
	 */
	public function select_temperature() {
		try {
		$stmt = $this->dbh->prepare(self::_SELECT_TEMPERATURE);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
		} catch (PDOException $ex) {
			Logger::log($ex->getCode(), $ex->getMessage());
			throw new Exception("Impossible load last 5 posts, there was an error");
		}
	}
		
}
?>