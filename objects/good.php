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
		$goods = array();
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
				array_push($goods, $lastRow);
			}
		} else {
			return array(
				"message" => "goods not found"
			);
		}
		return $goods;
	}

	public function getById($id) {
		$query = "SELECT id, name, price FROM goods WHERE id=?";
		$statement = $this->db->prepare($query);
		$statement->bindValue(1, $id);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);

		// Обработка пустого ответа
		if (
			is_null($row['name']) &&
			is_null($row['price'])
		) {
			$goods = array('message' => 'no matches found');
		} else {
			$goods = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"price" => $row['price']
			);
		}
		return $goods;
	}

	public function createGood($name, $price) {
		$goods = array();
		$query = "INSERT INTO goods (name, price) VALUES (?, ?)";
		$statement = $this->db->prepare($query);
		
		$statement->bindParam(1, $name);
		$statement->bindParam(2, $price);
		if ($statement->execute()) {
			http_response_code(201);
			echo json_encode(array("message" => "Good has been created"));
		} else {
			http_response_code(503);
			echo json_encode(array("message" => "Error! Could not create a good"));
		}
	}
}
?>
