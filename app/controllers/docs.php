<?php

// DOCS
class Docs extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('docs_model');
  }

  public function view($page = 'index', $type = 'any') {
    // Type could be third url

    // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), $page);
    $data['admin_links']['edit'] = 'edit'. '/' .$page;

    // If an index page at guide/ or guide/tech or guide/general
    if($page == 'index') {
      // Cannot edit index pages
      unset($data['admin_links']['edit']);
      $data['general_links'] = $this->docs_model->listFilesAsLinks('general');
      $data['tech_links'] = $this->docs_model->listFilesAsLinks('tech');
      $data['content'] = $this->load->view('pages/guideindex', $data, TRUE);
    } else {
      // Load a single page
      $data['content'] = $this->docs_model->getItem($page, $type);
    }
    
    // Show
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  }

  public function createdoc() {
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
      $data = $this->wrapper_model->pageDefaults(array(), $page);
      $data['title'] = '<br/>Add to the Information Directory';
      $data['scripts'] = array('ckeditor' => '/vendor/ckeditor/ckeditor.js', 'add_ckeditor' => '/js/sg-ckcustom.js');

      // Create Form
      if($this->input->post('text')){
        // make sure to repopulate the form textarea after an error (from the callback)
        $data['form_default_text'] = $this->security->xss_clean($this->input->post('text'));
      }

      $data['content'] = $this->load->view('pages/form_doc_create', $data, TRUE);
    // Show
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
      $saved = $this->docs_model->createItem($text, $filename, $type);
      if($saved) {
          // If saved
        // echo 'Successfully created '. $filename . ' at ' . '/docs/' . $type . '.';
        // Just redirect to created page
       redirect('/guide/' . $type . '/' . $thefile);

     } else {
        // Otherwise show the login screen with an error message.
        //redirect('/guide');
      echo 'Not able to create ' . $filename . '. It may be permissions related.';
    }
  }
}
public function valid_filename_check($thisname) {
  $invalid_filenames = array(
    'guide', 'general', 'tech',
    'index', 'create', 'createdoc', 'edit', 'editdoc', 'deletedoc',
    );

  if (in_array($thisname, $invalid_filenames)) {
    $this->form_validation->set_message('valid_filename_check', '%s will not work as a path. Please try something else.');
    return FALSE;
  } elseif($exists = $this->docs_model->itemExists($thisname)) {
      // doc already exists
    $this->form_validation->set_message('valid_filename_check', '%s will not work as a path. Please try something else. <br>' . $exists[0]); 
    return FALSE;
  } elseif(empty($thisname)) {
    $this->form_validation->set_message('valid_filename_check', 'Oops, the title field is empty.');
    return FALSE;
  }
  else {
    return TRUE;
  }
}
public function editdoc($file_to_edit) {
    // Loggedin admin?
  if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
    $this->load->library('form_validation');

      // Defaults
    $data = $this->wrapper_model->pageDefaults(array(), 'editdoc');
      // Being careful.
    $item = $this->security->xss_clean($file_to_edit);
      // file exists?
    $exists = $this->docs_model->itemExists($item);
    if($exists == FALSE) {
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
      if($saved) {
        // If saved
        // echo 'Successfully created '. $filename . ' at ' . '/docs/' . $type . '.';
        // Just redirect to created page
       redirect('/guide/' . $type . '/' . $thefile);

     } else {
        // Otherwise show the login screen with an error message.
        //redirect('/guide');
       echo 'Not able to create ' . $filename . '. It may be permissions related.';
    }
  }

} else {
  redirect('/login');
}
}
public function deletedoc($page) {



}

}
