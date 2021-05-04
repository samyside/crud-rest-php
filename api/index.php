<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$method = $_SERVER['REQUEST_METHOD'];
$formData = getFormData($method);

// Получение данных из тела запроса
function getFormData($method) {
    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') return $_GET;
    if ($method === 'POST') return file_get_contents("php://input");
 
    // PUT, PATCH или DELETE
    $data = array();
    $exploded = explode('&', file_get_contents('php://input'));
    foreach($exploded as $pair) {
        $item = explode('=', $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }
    return $data;
}

// Принимает параметры из строки 
// api/goods/{action}/[{parameter}]/[{additional_parameter}]
// api/goods/show/id/1
// api/goods/show/name/monitor | table
// api/goods/create
// api/goods/put
// api/goods/delete
$url = (isset($_GET['q'])) ? $_GET['q'] : '';
// Удаляем последний слэш если есть
$url = rtrim($url, '/');
// Разбивает полученную строку из адресной строки
// и преобразует в массив, где url[0] - api/
// TODO Исправить url[0]. Нулевым элементом массивом должно быть действие
$urls = explode('/', $url);

// Определяем роутер и url data
$router = $urls[1];
$urlData = array_slice($urls, 2);

// Подключем файл-проутер и запускаем главную функцию
if ($router === "") {
	require $_SERVER['DOCUMENT_ROOT'] . '/index.html';
} else {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/api/' . $router . '.php';
	route($method, $urlData, $formData);
}

?>
