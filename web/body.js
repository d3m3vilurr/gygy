var editting = false;

function editBody(page_id) {
	if (editting == false) {
		editting = true;
		div = _g("body_content");
		div.style.display = "none";
		t = document.createElement("div");
		t.setAttribute("id", "body_edit_window");
		html = '<form action="#" method="post" onsubmit="return false;"><textarea class="editor">';
		html +=  div.firstChild.data;
		html += '</textarea><br />';
		html += '<input type="button" value="Save changes" onclick="return saveBody(' + page_id + ')"/>';
		html += 'or <a href="#" onclick="editBody();">Cancel</a>';
		html += '</form>';
		t.innerHTML = html;
		t.style.display = "block";
		div.parentNode.insertBefore(t, div);
	} else {
		editting = false;
		div = _g("body_edit_window");
		div.style.display = "none";
		div = _g("body_content");
		div.style.display = "block";
	}
}

function saveBody_cb(data) {
	div = _g("body_content");
	div.firstChild.data = data;
	editBody();
}

function saveBody(page_id) {
	div = _g("body_edit_window");
	x_savebody(page_id, div.firstChild.firstChild.value, saveBody_cb);
	return false;
}