/**
 *
 * CKeditor config file
 */

 CKEDITOR.editorConfig = function( config ) {
  // disable filter. We are ensuring safe html serverside anyhow.
  config.allowedContent=true;
  // add extra plugins
  config.extraPlugins = 'showblocks';

  // Bootstrap styles
  config.stylesSet = [
  /* Add Styleguide Styles */
  { name : 'Syntax Highlighting', element : 'pre', attributes: { 'class': 'language-markup' } },
  { name : 'Default', element : 'pre', attributes: { 'class': '' } },
  /* Bootstrap Styles */
  /* Typography */
  { name : 'Paragraph Lead', element : 'p', attributes: { 'class': 'lead' } },
  /* LIST */
  {
    name : 'Unstyled List',
    element : 'ul',
    attributes :
    {
      'class' : 'list-unstyled'
    }
  },
  {
    name : 'List inline',
    element : 'ul',
    attributes :
    {
      'class' : 'list-inline'
    }
  },
  /* TABLE */
  {
    name : 'Table',
    element : 'table',
    attributes :
    {
      'class' : 'table'
    }
  },
  {
    name : 'Table Striped rows',
    element : 'table',
    attributes :
    {
      'class' : 'table table-striped'
    }
  },
  {
    name : 'Table Bordered',
    element : 'table',
    attributes :
    {
      'class' : 'table table-bordered'
    }
  },
  {
    name : 'Table Hover rows',
    element : 'table',
    attributes :
    {
      'class' : 'table table-hover'
    }
  },
  {
    name : 'Table Condensed',
    element : 'table',
    attributes :
    {
      'class' : 'table table-condensed'
    }
  },
  {
    name : 'Image shap rounded',
    element : 'table',
    attributes :
    {
      'class' : 'img-rounded'
    }
  },
  {
    name : 'Image shap circle',
    element : 'table',
    attributes :
    {
      'class' : 'img-circle'
    }
  },
  {
    name : 'Image shap thumbnail',
    element : 'table',
    attributes :
    {
      'class' : 'img-thumbnail'
    }
  },
  {
    name : 'Image float left',
    element : 'table',
    attributes :
    {
      'class' : 'pull-left'
    }
  },
  {
    name : 'Image float right',
    element : 'table',
    attributes :
    {
      'class' : 'pull-right'
    }
  }
  ];

  config.justifyClasses = [ 'text-left', 'text-center', 'text-right', 'text-justify' ];

  // Define changes to default configuration here.
  // For complete reference see:
  // http://docs.ckeditor.com/#!/api/CKEDITOR.config

  // The toolbar groups arrangement, optimized for two toolbar rows.
  config.toolbarGroups = [
  { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
  { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
  { name: 'links' },
  { name: 'insert' },
  { name: 'forms' },
  { name: 'tools' },
  { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
  { name: 'others' },
  '/',
  { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
  { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
  { name: 'styles' },
  { name: 'colors' },
  { name: 'about' },
  { name : 'span.H1', element : 'span', attributes: { 'class': 'h1' } },
  { name : 'span.H2', element : 'span', attributes: { 'class': 'h2' } },
  { name : 'span.H3', element : 'span', attributes: { 'class': 'h3' } },
  { name : 'span.H4', element : 'span', attributes: { 'class': 'h4' } },
  { name : 'span.H5', element : 'span', attributes: { 'class': 'h5' } },
  { name : 'span.H6', element : 'span', attributes: { 'class': 'h6' } },
  ];

  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  //config.removeButtons = 'Underline,Subscript,Superscript';

  // Set the most common block elements.
  //config.format_tags = 'p;h1;h2;h3;pre';

  // Simplify the dialog windows.
  //config.removeDialogTabs = 'image:advanced;link:advanced';
};


// This will remove default inline styles like a width and height from image/table configuration popup.
CKEDITOR.on('dialogDefinition', function( ev ) {
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  if(dialogName === 'table' || dialogName == 'tableProperties' ) {
    var infoTab = dialogDefinition.getContents('info');

    //remove fields
    var cellSpacing = infoTab.remove('txtCellSpace');
    var cellPadding = infoTab.remove('txtCellPad');
    var border = infoTab.remove('txtBorder');
    var width = infoTab.remove('txtWidth');
    var height = infoTab.remove('txtHeight');
    var align = infoTab.remove('cmbAlign');

  }
  if(dialogName === 'image') {
    var infoTab = dialogDefinition.getContents('info');
    dialogDefinition.removeContents( 'Link' );
        //dialogDefinition.removeContents( 'advanced' ); // leave so we can add classes
        infoTab.remove('txtWidth');
        infoTab.remove('txtHeight');
        infoTab.remove('txtBorder');
        infoTab.remove('txtHSpace');
        infoTab.remove('txtVSpace');
        infoTab.remove('ratioLock');
        infoTab.remove('cmbAlign');

      }
    });
