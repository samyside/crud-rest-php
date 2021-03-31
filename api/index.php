<?php
$method = $_SERVER['REQUEST_METHOD'];
$formData = getFormData($method);

// Получение данных из тела запроса
function getFormData($method) {
    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') return $_GET;
    // if ($method === 'POST') return $_POST;
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

// Получаем значение параметра ?q=value в адресной строке
// Сохранил для примера как обрабатывать get-переменную
// $url = (isset($_GET['q'])) ? $_GET['q'] : '';

// Удаляем последний слэш если есть
$url = rtrim($url, '/');
// Получаем массив /goods/10/sort/asc...
$urls = explode('/', $url);

// Определяем роутер и url data
$router = $urls[1];
var_dump($urls);
$urlData = array_slice($urls, 2);

// Подключем файл-проутер и запускаем главную функцию
if ($router === "") {
	require $_SERVER['DOCUMENT_ROOT'] . "/index.html";
} else {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/api/' . $router . '.php';
	route($method, $urlData, $formData);
}

?>
