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

	/*
	* api/goods
	* Получение всех товаров
	*/
	public function getAll() {
		$result = array(
			'error' => false,
			'message' => '',
			'count' => 0,
			'goods' => array()
		);
		$count = 0;
		$queryGoods = 'SELECT id, name, price FROM goods';
		$statement = $this->db->prepare($queryGoods);
		$statement->execute();
		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				http_response_code(200);
				extract($row);
				$lastRow = array(
					'id' => $id,
					'name' => $name,
					'price' => $price
				);
				array_push($result['goods'], $lastRow);
				// $count++;
			}
			$result['count'] = $statement->rowCount();
			$result['message'] = 'success';
		} else {
			return array(
				http_response_code(404),
				'error' => true,
				'message' => 'goods not found',
				'count' => 0,
				'goods' => NULL
			);
		}
		http_response_code(200);
		return $result;
	}

	/*
	* api/goods/{id}
	* Получение одного товара по номеру id
	*/
	public function getById($id) {
		$query = "SELECT id, name, price FROM goods WHERE id=?";
		$statement = $this->db->prepare($query);
		$statement->bindValue(1, $id);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);

		// Обработка пустого ответа
		if (
			!is_null($row['name']) &&
			!is_null($row['price'])
		) {
			$goods = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"price" => $row['price']
			);
			http_response_code(200);
		} else {
			http_response_code(404);
			$goods = array('message' => 'no matches found');
		}
		return $goods;
	}

	/*
	* api/goods/name/{string}
	* Получение массива товаров по названию (name).
	*/
	public function getByName($name='') {
		$result = array(
			'error' => true,
			'message' => 'unknown error',
			'count' => 0,
			'goods' => array()
		);
		$query = 'SELECT id, name, price FROM goods WHERE name LIKE ?';
		$statement = $this->db->prepare($query);
		$statement->bindValue(1, "%${name}%");
		$statement->execute();

		// Обработка пустого ответа
		if ($statement->rowCount() > 0) {
			$result['error'] = false;
			$result['message'] = 'success';
			$result['count'] = $statement->rowCount();
			while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				extract($row);
				$lastRow = array(
					'id' => $id,
					'name' => $name,
					'price' => $price
				);
				array_push($result['goods'], $lastRow);
			}
			http_response_code(200);
		} else {
			$result['message'] = 'no matches found';
			http_response_code(404);
		}
		return $result;
	}

	/*
	* [POST] api/goods
	* Создание новой записи. Отправляется JSON формата:
	* {"name": "item", "price": 1.99}
	*/
	public function createGood($name, $price) {
		$goods = array();
		$query = "INSERT INTO goods (name, price) VALUES (?, ?)";
		$statement = $this->db->prepare($query);
		
		$statement->bindParam(1, $name);
		$statement->bindParam(2, $price);
		if ($statement->execute()) {
			http_response_code(201);
			return json_encode(array("message" => "Good has been created"));
		} else {
			http_response_code(409);
			return json_encode(array("message" => "Error! Could not create a good"));
		}
	}
}
?>
