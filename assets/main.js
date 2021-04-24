
async function getGood() {
	const inputId = document.querySelector('#inputId');
	const url = 'http://simple-rest/api/goods/' + inputId.value;
	let id = document.querySelector('#id');
	console.log(id.value);
	let name = document.querySelector('#name');
	let price = document.querySelector('#price');
	let response = await fetch(url);
	if (response.ok) {
		const result = await response.json();
		console.log(result);
		id.innerText = result.id;
		name.innerText = result.name;
		price.innerText = result.price;
	} else {
		id.innerText = '';
		name.innerText = 'Не найдено';
		price.innerText = '';
	}
}