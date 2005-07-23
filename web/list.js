function showList_cb(data) {
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
}

function addListItem(page_id) {
	input = _g("inputListItem");
	x_addlistitem(page_id, input.value, addListItem_cb);
}