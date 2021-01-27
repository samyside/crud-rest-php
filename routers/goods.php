<?php 
function route($method, $urlData, $formData) {
	// Получение инфы о товаре
	// GET /goods/{goodId}
	if ($method === 'GET' && count($urlData) === 1) {
		// Получаем id товара
		$goodId = $urlData[0];

		// Вытаскиваем из базы данных SQL
		// $query = "SELECT id, good, price FROM products";
		// $stmt = $database->prepare($query);
		// $stmt->bindParam(1, goodId);
		// $stmt->execute();
		// $row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo json_encode(array(
			'method' => 'GET',
			'id' => $goodId,
			'good' => 'phone',
			'price' => 1000
		));
		return;

		// Если код выше не отработал,
		// возвращаем ошибку
		header('HTTP/1.0 400 Bad Request');
		echo json_encode(array(
			'error' => 'BadRequest'
		));
	}
}
?>