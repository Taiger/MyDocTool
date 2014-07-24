<?php

class Patterns extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('pattern_model');
  }

  public function view($page = 'allpatterns') {

  // Defaults
  $data = $this->wrapper_model->pageDefaults(array(), $page);
  $data['menus']['patterns']['state'] = TRUE;


  // Pattern Links
  $data['styletile_links'] = $this->pattern_model->listPatternsAsLinks('styletiles');
  $data['atom_links'] = $this->pattern_model->listPatternsAsLinks('atoms');
  $data['molecule_links'] = $this->pattern_model->listPatternsAsLinks('molecules');
  $data['component_links'] = $this->pattern_model->listPatternsAsLinks('components');
  $data['template_links'] = $this->pattern_model->listPatternsAsLinks('templates');
  $data['pagelayout_links'] = $this->pattern_model->listPatternsAsLinks('pages');
  $data['header_links'] = $data['styletile_links'] . $data['atom_links'] . $data['molecule_links'];

  // allpatterns
  if($page == 'allpatterns'){
    $data['title'] = 'Style Guide';
    $data['body_class'] = 'allpatterns-page';

    // Pattern Markup
    $data['styletiles'] = $this->pattern_model->getAllStyletiles();
    $data['atoms'] = $this->pattern_model->getAllofType('atoms');
    $data['molecules'] = $this->pattern_model->getAllofType('molecules');
    $data['components'] = $this->pattern_model->getAllofType('components');

    // Show
    $data['content'] = $this->load->view('pages/allpatterns', $data, TRUE);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  } else {
    //
    $data['title'] = 'Pattern ' . $page;
    $data['body_class'] = $page . '-page';
    $data['admin_links']['edit'] = $data['base_url'].'pattern/edit/' .$page;
    $data['admin_links']['delete'] = $data['base_url'].'pattern/delete/' .$page;

    // Show
    $data['content'] = $this->pattern_model->showItem($page);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  }


  }
/* === copied functionality from Docs controller below ===
 * TODO make into generic functionality
 */

/*
   * -Create New Pattern Page Form
   * Accepts no params. Created new pattern page. If not logged in, redirects to login page.
   * If pattern is created redirects to newly created pattern
   * Otherwise returns an error message
   */
  public function createpat() {
        // Check for session
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    $this->load->helper('form');
    $this->load->library('form_validation');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
      <span class="sr-only">Close</span></button>', '</div>');
    $this->form_validation->set_rules('text', 'text', 'required');
    $this->form_validation->set_rules('title', 'Title', 'callback_valid_filename_check'); // callback below

    // Run form validation
    if ($this->form_validation->run() === FALSE) {
      // Defaults
      $data = $this->wrapper_model->pageDefaults(array(), 'createpat');
      $data['menus']['patterns']['state'] = TRUE;
      //$data['general_links'] = $this->pattern_model->listPatternsAsLinks('atom');
      //$data['tech_links'] = $this->pattern_model->listPatternsAsLinks('component');
      $data['title'] = '<br/>Create New';
      // ACE Editor for HTML
      $data['scripts'] = array(
        'aceeditor' => '//cdn.jsdelivr.net/ace/1.1.4/min/ace.js',
        'acesyntax' => '//cdn.jsdelivr.net/ace/1.1.4/min/ext-beautify.js',
        'acesyntaxhtml' => '//cdn.jsdelivr.net/ace/1.1.4/min/mode-html.js',
        'add_aceeditor' => '/js/sg-acecustom.js');

      // Create Form
      if($this->input->post('text')){
        // make sure to repopulate the form textarea after an error (from the callback)
        $data['form_default_text'] = $this->security->xss_clean($this->input->post('text'));
      }

      // Show
      $data['content'] = $this->load->view('pages/form_create', $data, TRUE);
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);
    } else {

      // Valid POST
      // Grab the email and password from the form POST
      // Code Ignitor does not clean post data by default.
      $title = $this->security->xss_clean($this->input->post('title'));
      $text  = $this->security->xss_clean($this->input->post('text'));
      $type  = $this->security->xss_clean($this->input->post('type'));

      // CI function replaces spaces with dashes and makes lowercase
      $thefile = url_title(strtolower($this->security->sanitize_filename($title)), '-', TRUE);
      $filename = $thefile . '.html';


      // Try to save
      if($this->pattern_model->createItem($text, $filename, $type)) {
          // If saved
        // echo 'Successfully created '. $filename . ' at '  . $type . '.';
        // Just redirect to newly created page
       redirect('/' . $thefile);

     } else {
        // Permission issue
      echo '<p>Not able to create ' . $filename . '. It may be permissions related. Use the back button on your browser and save your changes to a local file.</p>';
    }
  }
  } else {
      // not logged in or not admin
      redirect('/login');
    }
}
// Callback for creating a new pattern page
// Accepts name to check for and returns TRUE or FALSE
public function valid_filename_check($thisname) {
  // Check for filenames that either exist as a path or are used another way.
  $disallowed_filenames = array(
    'guide', 'general', 'tech',
    'index', 'create', 'createdoc', 'edit', 'editdoc', 'deletedoc', 'deletedoc_yes', 'createpat', 'editpat', 'deletepat', 'deletepat_yes',
    'any',
    );

  if (in_array($thisname, $disallowed_filenames)) {
    // MESSAGE: try again
    $this->form_validation->set_message('valid_filename_check', $thisname . ' will not work as a path. Please try something else.');
    return FALSE;
  } elseif($exists = $this->pattern_model->itemExists($thisname)) {
    // MESSAGE: pattern already exists
    if(is_array($exists)) {
      $exists = $exists[0];
    }
    $this->form_validation->set_message('valid_filename_check', $thisname . ' will not work as a path. Please try something else. <br>' . $exists);
    return FALSE;
  } elseif(empty($thisname)) {
    // MESSAGE: title field is empty
    $this->form_validation->set_message('valid_filename_check', 'Oops, the title field is empty.');
    return FALSE;
  } else {
    // YES!
    return TRUE;
  }
}

/*
* -Edit a pattern html page
* Accepts $file_to_edit as 'my_file'. Redirects to login page if not logged in.
* If Pattern is edited redirects to newly created pattern
* Otherwise returns an error message
*/
public function editpat($file_to_edit) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    $this->load->library('form_validation');

      // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'editpat');
    $data['menus']['patterns']['state'] = TRUE;

    //$data['general_links'] = $this->pattern_model->listPatternsAsLinks('general');
    //$data['tech_links'] = $this->pattern_model->listPatternsAsLinks('tech');

      // Being careful.
    $item = $this->security->xss_clean($file_to_edit);
      // file exists?
    $exists = $this->pattern_model->itemExists($item);
    if($exists == FALSE) {
      // No file to edit
      show_404();
    }

    // Get type/category from filepath
    $type = $exists['type'];

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
      <span class="sr-only">Close</span></button>', '</div>');
    $this->form_validation->set_rules('text', 'text', 'required');

    // Run form validation
    if ($this->form_validation->run() === FALSE) {
      $data['file_to_edit'] = $item;
      $data['scripts'] = array(
        'aceeditor' => '//cdn.jsdelivr.net/ace/1.1.4/min/ace.js',
        'acesyntax' => '//cdn.jsdelivr.net/ace/1.1.4/min/ext-beautify.js',
        'acesyntaxhtml' => '//cdn.jsdelivr.net/ace/1.1.4/min/mode-html.js',
        'add_aceeditor' => '/js/sg-acecustom.js');

      $editing_message = 'Editing ' . $item . '.html';
      // populate the form textarea
      $data['form_default_text'] = $this->pattern_model->getItem($item);
      //die(print_r($data['form_default_text']));
      // Form
      $data['content'] = $this->load->view('pages/form_edit', $data, TRUE);
      // Show
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);

    } else {
        //Save changes
      $text  = $this->security->xss_clean($this->input->post('text'));
      $filename = $item . '.html';

      // Try to save
      $saved = $this->pattern_model->createItem($text, $filename, $type);
      if($saved == TRUE) {
        // If saved
        // echo 'Successfully created '. $filename . ' at ' /' . $type . '.';
        // Just redirect to created page
       redirect('/' . $item);

     } else {
        // Otherwise show message with message how to retain changes.
        //link back to edit page will erase changes?
        // <a class="btn btn-small" href="'.base_path().'guide/edit/' . $item.'">Return to edit page</a>
       echo '<p>Not able to edit ' . $filename . '. It may be permissions related. Use the back button on your browser and save your changes to a local file.</p>';
    }
  }

} else {
  // not logged in
  redirect('/login');
}
}
/*
* -Delete a documentation html page
* Accepts $file_to_edit as 'my_file'. Redirects to login page if not logged in.
* If pat is edited redirects to newly created pat
* Otherwise returns an error message
*/
public function deletepat($file_to_delete) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'deletepat');
    $data['menus']['patterns']['state'] = TRUE;
    $data['general_links'] = $this->pattern_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->pattern_model->listFilesAsLinks('tech');
    $data['content'] = '<div class="row"><div class="col-md-6 col-md-offset-3"><h3>Are you sure you want to delete ' . $file_to_delete . '.html permanently? </h3><a class="btn btn-sm btn-primary" href="'.base_url('/guide/deletepat_yes/'.$file_to_delete).'"> Yes </a> <a class="btn btn-sm btn-default" href="'.base_url('/guide/'.$file_to_delete).'"> No </a></div></div>';
    // Show
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);
  } else {
    // not logged in
    redirect('/login');
  }
}
/*
 * Directly delete the file. Only ran from link in delete pattern message above.
 */
public function deletepat_yes($file_to_delete) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'deletepat');
    $data['menus']['patterns']['state'] = TRUE;
    $data['general_links'] = $this->pattern_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->pattern_model->listFilesAsLinks('tech');
    // Try to delete the file
    $deleted = $this->pattern_model->itemDelete($file_to_delete);
    if($deleted){
      $data['content'] =  $deleted;
    } else {
      $data['content'] = 'Hmm, I could not delete '. $file_to_delete . ' Either its a permissions issue or it does not exist.';
    }
    $data['content'] = '<div class="row"><div class="col-md-6 col-md-offset-3">'.$data['content'].'</div></div>';
    // Show
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);
  } else {
    // not logged in
    redirect('/login');
  }
}
}
