<?php 
/**
 * Описание товара
 */
class Good {
	private $id;
	private $name;
	private $price;
	private $db = NULL;

	function __construct($db) {
		$this->db = $db;
	}

	public function getAll() {
		$allGoods = array();
		$query = 'SELECT id, name, price FROM goods';
		$statement = $this->db->prepare($query);
		$statement->execute();
		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(200);
				extract($row);
				$lastRow = array(
					"id" => $id,
					"name" => $name,
					"price" => $price
				);
				array_push($allGoods, $lastRow);
			}
		} else {
			return array(
				"message" => "goods not found"
			);
		}
		return $allGoods;
	}

	public function getById($id) {
		$arrayGoods = array();
		$query = "SELECT id, name, price FROM goods WHERE id=?";
		$statement = $this->db->prepare($query);
		$statement->bindValue(1, $id);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$arrayGoods = array(
			"id" => $id,
			"name" => $name,
			"price" => $price
		);
		return $arrayGoods;
	}
}
?>
