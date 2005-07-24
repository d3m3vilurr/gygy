function showNotes_cb(data) 
{
  div = _g("addNoteForm");
  div.innerHTML = data;
  div.style.display = "block";
}

function showNotes(page_id)
{
  div = _g("notes_block");
  if (div.style.display == "none") {
    div.style.display = "block";
    showAddNoteDialog();
  }
}

function addNote_cb(data)
{
  window.location.reload();
}

function addNote()
{
  subject = _g("noteSubject");
  content = _g("noteContent");
  x_addnote(pageid, subject.value, content.value, addNote_cb);
}

function showAddNoteDialog()
{
  line = _g("add_note");
  dialog = _g("add_note_dialog");

  line.style.display = "none";
  dialog.style.display = "block";

  subject = _g("noteSubject");
  subject.value = "";

  content = _g("noteContent");
  content.value = "";
}

function hideAddNoteDialog()
{
  line = _g("add_note");
  dialog = _g("add_note_dialog");

  line.style.display = "block";
  dialog.style.display = "none";

  doLoad();
}

function editNote_cb(noteid)
{
}

function editNote(pageid, noteid)
{
  x_editnote(pageid, noteid, editNote_cb);
}

function delNote_cb(noteid) 
{
  note = _g("note_" + noteid);
  note.style.display = "none";
  note_count = note_count - 1;
  doLoad();
}

function delNote(pageid, noteid)
{
  x_delnote(pageid, noteid, delNote_cb);
}

function doLoad()
{
  div = _g("notes_block");
  if (0 < note_count) {
    div.style.display = "block";
  } else {
    div.style.display = "none";
  }
}

