<?php 
/**
 * Соединение с базой данных
 */
class Database {
	private $host = "127.0.0.1";
	private $db_name = "api_db";
	private $username = "root";
	private $password = "root";
	private $connection = NULL;

	public function getConnection() {
			try {
			$this->connection = new PDO(
				"mysql:host=" . $this->host .
				";dbname=" . $this->db_name, 
				$this->username, 
				$this->password
			);
			$this->connection->exec("set names utf8");
		} catch (PDOException $e) {
			echo "Failed database connection: " . $e->getMessage();
		}
		return $this->connection;
	}
}

?>
