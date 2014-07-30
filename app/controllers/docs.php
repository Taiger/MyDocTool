<?php

// DOCS
class Docs extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('docs_model');
  }
  /*
   * Accepts $page as string and optional $type as string
   * If $page == index returns doc index page
   * Otherwise returns page loaded with html
   */
  public function view($page = 'index', $type = 'any') {
    // Type could be third url param

    // Use cache. Time is in minutes.
    $this->output->cache(30);

    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), $page);
    $data['menus']['docs']['state'] = TRUE;
    $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');

    // If an index page at guide/ or guide/tech or guide/general
    if($page == 'index') {
      //$data['general_links'] = $this->docs_model->listFilesAsLinks('general');
      //$data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
      // Load in nodetpl
      $data['nodetpl'] = $this->load->view('pages/guideindex', $data, TRUE);
    } else {
      $data['admin_links']['edit'] = $data['base_url'].'guide/edit/' .$page;
      $data['admin_links']['delete'] = $data['base_url'].'guide/delete/' .$page;
      // Load a single page in a nodetpl
      $data['nodetpl'] = $this->docs_model->getItem($page, $type);
    }

    // Show in nodetpl template
    $data['content'] = $this->load->view('templates/node12tpl', $data, TRUE);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  }
  /*
   * -Create New Documentation Page Form
   * Accepts no params. Created new documentation page. If not logged in, redirects to login page.
   * If Doc is created redirects to newly created doc
   * Otherwise returns an error message
   */
  public function createdoc() {
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
      $data = $this->wrapper_model->pageDefaults(array(), 'createdoc');
      $data['menus']['docs']['state'] = TRUE;
      $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
      $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
      $data['title'] = '<br/>Add to the Information Directory';
      $data['scripts'] = array('ckeditor' => '/vendor/ckeditor/ckeditor.js', 'add_ckeditor' => '/js/sg-ckcustom.js');

      // Create Form
      if($this->input->post('text')){
        // make sure to repopulate the form textarea after an error (from the callback)
        $data['form_default_text'] = $this->security->xss_clean($this->input->post('text'));
      }

      // Show
      $data['content'] = $this->load->view('pages/form_doc_create', $data, TRUE);
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
      if($this->docs_model->createItem($text, $filename, $type)) {
        // IF SAVED
        // Silently clear cache
        $this->wrapper_model->clearCache();
        // Just redirect to newly created page
       redirect('/guide/' . $type . '/' . $thefile);

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
// Callback for creating a new documentation page
// Accepts name to check for and returns TRUE or FALSE
public function valid_filename_check($thisname = FALSE) {
  if($thisname == FALSE){
    $this->form_validation->set_message('valid_filename_check', 'Oops, the title field is empty.');
    return FALSE;
  }
  // Check for filenames that either exist as a path or are used another way.
  $disallowed_filenames = array(
    'guide', 'general', 'tech',
    'index', 'create', 'createdoc', 'edit', 'editdoc', 'deletedoc', 'deletedoc_yes',
    'any',
    );

  if (in_array($thisname, $disallowed_filenames)) {
    // MESSAGE: try again
    $this->form_validation->set_message('valid_filename_check', $thisname . ' will not work as a path. Please try something else.');
    return FALSE;
  } elseif($exists = $this->docs_model->itemExists($thisname)) {
    // MESSAGE: pattern already exists
      $exists = implode(' ',$exists);
    $this->form_validation->set_message('valid_filename_check', $thisname . ' will not work as a path. Please try something else. <br>' . $exists);
    return FALSE;
  } else {
    // YES!
    return TRUE;
  }
}

/*
* -Edit a documentation html page
* Accepts $file_to_edit as 'my_file'. Redirects to login page if not logged in.
* If Doc is edited redirects to newly created doc
* Otherwise returns an error message
*/
public function editdoc($file_to_edit) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    $this->load->library('form_validation');

      // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'editdoc');
    $data['menus']['docs']['state'] = TRUE;
    $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
      // Being careful.
    $item = $this->security->xss_clean($file_to_edit);
      // file exists?
    $exists = $this->docs_model->itemExists($item);
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
      $data['scripts'] = array('ckeditor' => '/vendor/ckeditor/ckeditor.js', 'add_ckeditor' => '/js/sg-ckcustom.js');
      $editing_message = 'Editing ' . $item . '.html';
      // populate the form textarea
      $data['form_default_text'] = $this->docs_model->getItem($item);
      // Form
      $data['content'] = $this->load->view('pages/form_doc_edit', $data, TRUE);
      // Show
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);

    } else {
        //Save changes
      $text  = $this->security->xss_clean($this->input->post('text'));
      $filename = $item . '.html';

      // Try to save
      $saved = $this->docs_model->createItem($text, $filename, $type);
      if($saved == TRUE) {
        // Silently clear cache
        $this->wrapper_model->clearCache();
        // Redirect to created page
       redirect('/guide/' . $type . '/' . $item);

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
* If Doc is edited redirects to newly created doc
* Otherwise returns an error message
*/
public function deletedoc($file_to_delete) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'deletedoc');
    $data['menus']['docs']['state'] = TRUE;
    $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
    $data['content'] = '<div class="row"><div class="col-md-6 col-md-offset-3"><h3>Are you sure you want to delete ' . $file_to_delete . '.html permanently? </h3><a class="btn btn-sm btn-primary" href="'.base_url('/guide/deletedoc_yes/'.$file_to_delete).'"> Yes </a> <a class="btn btn-sm btn-default" href="'.base_url('/guide/'.$file_to_delete).'"> No </a></div></div>';

    // Show
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);
  } else {
    // not logged in
    redirect('/login');
  }
}
/*
 * Directly delete the file. Only ran from link in deletedoc message above.
 */
public function deletedoc_yes($file_to_delete) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'deletedoc');
    $data['menus']['docs']['state'] = TRUE;
    $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
    $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
    // Try to delete the file
    $deleted = $this->docs_model->itemDelete($file_to_delete);
    if($deleted){
      $data['content'] =  $deleted;
    } else {
      $data['content'] = 'Hmm, I could not delete '. $file_to_delete . ' Either its a permissions issue or it does not exist.';
    }
    // Silently clear cache
    $this->wrapper_model->clearCache();


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
