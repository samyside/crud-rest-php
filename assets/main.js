async function getById() {
	// Определение переменных
	let inputID = document.querySelector('#inputID');
	const hostname = window.location.hostname;
	let url = 'http://' + hostname + '/api/goods/' + inputID.value;
	console.log(url);
	let result = {
		id: null,
		name: null,
		price: null
	};
	let price = document.querySelector('#price');
	let id = document.querySelector('#id');
	let name = document.querySelector('#name');

	// Получение массива данных
	let response = await fetch(url);
	if (response.ok) {
		result = await response.json();
	} else {
		result = {message: "Error! Could not get response."};
	}

	// Вывод первого элемента массива
	console.log('Первый элемент массива');
	console.log('  object = ' + result);
	console.log('  id = ' + result.id);
	console.log('  name = ' + result.name);
	console.log('  price = ' + result.price);

	// Вставка данных из результата в HTML-код
	if (inputID.value === '') {
		id.innerHTML = '';
		name.innerHTML = '';
		price.innerHTML = '';
	} else if (
		typeof result.id === 'undefined' &&
		typeof result.name === 'undefined' &&
		typeof result.price === 'undefined'
	) {
		id.innerHTML = inputID.value;
		name.innerHTML = 'Не найдено';
		price.innerHTML = '';
	} else {
		id.innerHTML = result.id;
		name.innerHTML = result.name;
		price.innerHTML = result.price;
	}
}

