function showList_cb(data) {
	div = _g("list_content");
	div.innerHTML = data;
	div.style.display = "block";
}

function showList(page_id) {
	div = _g("list_content");
	if (div.style.display == "block") {
		div.style.display = "none";
	} else {
		x_showlist(page_id, showList_cb);
	}
}

function addListItem_cb(data) {
	div = _g("list_content");
	div.style.display = "none";
	showList(data);
}

function addListItem(page_id) {
	input = _g("inputListItem");
	x_addlistitem(page_id, input.value, addListItem_cb);
}

function checkListItem_cb(data) {
	div = _g("list_content");
	div.style.display = "none";
	showList(data);
}

function checkListItem(page_id, item_id, status) {
	x_checklistitem(page_id, item_id, status, checkListItem_cb);
}

function showListItemInputForm_cb(data) {
	div = _g("inputListItemForm");
	if (div.firstChild != null) {
	} else {
		div.innerHTML = data;
	}
	div.style.display = "block";
	div = _g("inputFormLink");
	div.style.display = "none";
}

function showListItemInputForm(page_id) {
	x_showlistiteminputform(page_id, showListItemInputForm_cb);
}

function hideListItemInputForm() {
	div = _g("inputListItemForm");
	div.style.display = "none";
	div = _g("inputFormLink");
	div.style.display = "block";
}