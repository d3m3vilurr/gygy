function showLink_cb(data) {
	div = _g("link_content");
	div.innerHTML = data;
	div.style.display = "block";
}

function showLink(page_id) {
	div = _g("link_content");
	if (div.style.display == "block") {
		div.style.display = "none";
	} else {
		x_showlink(page_id, showLink_cb);
	}
}

function addLinkItem_cb(data) {
	alert(data);
	div = _g("link_content");
	div.style.display = "none";
	showLink(data);
}

function addLinkItem(page_id) {
/*	input = _g("inputLinkItem"); */
	input = _g("existLinkItem");
	x_addlinkitem(page_id, input.value, addLinkItem_cb);
}

function showLinkItemInputForm_cb(data) {
	div = _g("inputLinkItemForm");
	if (div.firstChild != null) {
	} else {
		div.innerHTML = data;
	}
	div.style.display = "block";
	div = _g("inputFormLink");
	div.style.display = "none";
}

function showLinkItemInputForm(page_id) {
	x_showlinkiteminputform(page_id, showLinkItemInputForm_cb);
}

function hideLinkItemInputForm() {
	form = _g("inputLinkItemForm");
	form.style.display = "none";
	div = _g("inputFormLink");
	if (div != null) {
		div.style.display = "block";
	} else {
		c = _g("link_content");
		c.style.display = "none";
	}
}