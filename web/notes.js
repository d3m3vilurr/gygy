function showNotes_cb(data) 
{
  div = _g("notes_content");
  div.innerHTML = data;
  div.style.display = "block";
}

function showNotes(page_id)
{
  div = _g("notes_content");
  if (div.style.display == "block") {
    div.style.display = "none";
  } else {
    x_shownotes(page_id, showNotes_cb);
  }
}

function addNote_cb(data)
{
}

function addNote()
{
  subject = _g("noteSubject");
  content = _g("noteContent");
  x_addnote(pageid, subject.value, content.value, addNote_cb);
}
