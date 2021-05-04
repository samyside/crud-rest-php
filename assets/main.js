async function getGood() {
	const input = document.querySelector('#input');
	let url = 'http://simple-rest/api/goods/' + input.value;
	console.log(url);
	let id = document.querySelector('#id');
	let name = document.querySelector('#name');
	let price = document.querySelector('#price');
	let response = await fetch(url);
	if (response.ok && input.value != '') {
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

async function getGoodByName() {
	const input = document.querySelector('input');
	const url = 'http://simple-rest/api/goods/name/' + input.value;
	console.log(url);
	let id = document.querySelector('#id');
	let name = document.querySelector('#name');
	let price = document.querySelector('#price');
	const response = await fetch(url);
	if (response.ok) {
		const result = await response.json();
		const goods = result.goods;
		for (let i=0; i < goods.length; i++) {
			addRow(
				goods[i].id,
				goods[i].name,
				goods[i].price
			);
		}
	}
}

function addRow(id, name, price) {
	var tbodyRef = document.getElementById('table').getElementsByTagName('tbody')[0];

	// Insert a row at the end of table
	var newRow = tbodyRef.insertRow();

	// Insert a cell at the end of the row
	let cellid = newRow.insertCell();
	let cellName = newRow.insertCell();
	let cellPrice = newRow.insertCell();

	// Append a text node to the cell
	const textId = document.createTextNode(id);
	const textName = document.createTextNode(name);
	const textPrice = document.createTextNode(price);
	cellid.appendChild(textId);
	cellName.appendChild(textName);
	cellPrice.appendChild(textPrice);

}
