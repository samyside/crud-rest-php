<?php 
// TODO Получение данных из БД по запросу
include_once $_SERVER['DOCUMENT_ROOT']. '/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/objects/good.php';

function route($method, $urlData, $formData) {
	$database = new Database();
	$connection = $database->getConnection();
	$good = new Good($connection);

	// Проверка на наличие дополнительных параметров

	// Получение инфы о товаре
	if ($method === 'GET' && count($urlData) === 0) {
		$arrayGoods = array();
		$arrayGoods = $good->getAll();
		echo json_encode($arrayGoods);
	} elseif ($method === 'GET' && count($urlData) === 1) {
		http_response_code(200);
		// Получаем id товара
		$goods = $good->getById($urlData[0]);
		echo json_encode($goods);
	} elseif ($method === 'POST' && empty($urlData)) {
		// TODO Добавляем товар в базу данных
		var_dump($formData);
		$goodData = json_decode($formData);
		$name  = $goodData->name;
		$price = $goodData->price;
		$message = json_encode($good->createGood($name, $price));
		echo $message;
	} else {
		// возвращаем ошибку
		header('HTTP/1.0 400 Bad Request');
		echo json_encode(array("error" => "Wrong HTTP-method or parameter"));
	}
}
?>