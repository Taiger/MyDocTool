var editor = ace.edit("aceeditor");
editor.setTheme("ace/theme/twilight");
editor.getSession().setMode("ace/mode/html");

var textarea = $('textarea[name="text"]');
textarea.hide();
editor.getSession().setValue(textarea.val());
editor.getSession().on('change', function(){
  textarea.val(editor.getSession().getValue());
});



