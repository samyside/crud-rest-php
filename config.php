<?php 
/**
 * Конфиг для соединения с базой данных
 */
class Database {
	private $host = "localhost";
	private $db_name = "api_db";
	private $username = "root";
	private $password = "root";
	private $conn = null;

	function __construct(argument)
	{
		try {
			$this->conn = new PDO(
				"mysql:host=" . $this->host .
				";dbname=". $this->db_name,
				$this->username,
				$this->password
			);
		} catch (PDOException $e) {
			echo "Connection error: " . $e->getMessage();
		}
		return $this->conn;
	}
}
?>