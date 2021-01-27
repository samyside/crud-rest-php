<?php 
/**
 * Соединение с базой данных
 */
class Database {
	$host = "localhost";
	$db_name = "api_db";
	$username = "root";
	$password = "root";
	$connection = null;
	
	function __construct()
	{
	}

	public function getConnection() {
			try {
			$connection = new PDO(
				"mysql:host=" . db_name .
				";dbname=" . db_name . username . password
			);
		} catch (PDOException $e) {
			echo "Connection error" . $e->getMessage();
		}
		return $connection;
	}
}


?>
