var editor = ace.edit("aceeditor");
editor.setTheme("ace/theme/monokai");
editor.getSession().setMode("ace/mode/html");
editor.setFontSize('14px');

var textarea = $('textarea[name="text"]');
textarea.hide();
editor.getSession().setValue(textarea.val());
editor.getSession().on('change', function(){
  textarea.val(editor.getSession().getValue());
});

