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
    $data['current_page'] = $page;
    $data['body_class'] = $page . '-page';
    $data['title'] = ucfirst($page);
    $data['isLoggedIn'] = $this->session->userdata('isLoggedIn');
    $data['isAdmin'] = $this->session->userdata('isAdmin');
    $data['edit_links'] = array();
    $data['edit_links']['edit'] = 'edit'. '/' .$page;

    // Code Ignitor Help Link
    if($data['isAdmin']){
      $data['edit_links']['styleguide_dev_help'] = '/user_guide';
    }

    // If an index page at guide/ or guide/tech or guide/general
    if($page == 'index') {
      // Cannot edit index pages
      unset($data['edit_links']['edit']);
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
    $data['title'] = '<br/>Add to the Information Directory';

    $this->form_validation->set_rules('text', 'text', 'required');
    $this->form_validation->set_rules('title', 'Title', 'callback_valid_filename_check'); // callback below

    if ($this->form_validation->run() === FALSE) {
      $data['scripts'] = array('ckeditor' => '/vendor/ckeditor/ckeditor.js', 'add_ckeditor' => '/js/sg-ckcustom.js');

      // Create Form
      if($this->input->post('text')){
        // make sure to repopulate the form textarea after an error (from the callback)
        $data['form_default_text'] = $this->security->xss_clean($this->input->post('text'));
      }

      $data['content'] = $this->load->view('pages/createdoc', $data, TRUE);
    // Show
      $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
      $this->load->view('templates/htmltpl', $data);
    } else {

      //$data['content'] = $this->docs_model->create($page, $type);

    // Grab the email and password from the form POST
      // Code Ignitor does not clean these by default
      $title = $this->security->xss_clean($this->input->post('title'));
      $text  = $this->security->xss_clean($this->input->post('text'));
      $type  = $this->security->xss_clean($this->input->post('type'));

      // CI function replaces spaces with dashes and makes lowercase
      $thefile = url_title(strtolower($this->security->sanitize_filename($title)), '-', TRUE);
      $filename = $thefile . '.html';

    $textcontent = $text; // RAW INPUT

    // Save
    $saved = $this->docs_model->create($textcontent, $filename, $type);
    if($saved) {
        // If saved
      // echo 'Successfully created '. $filename . ' at ' . '/docs/' . $type . '.';
     redirect('/guide/' . $type . '/' . $thefile);

   } else {
        // Otherwise show the login screen with an error message.
        //redirect('/guide');
      echo 'Not able to create ' . $filename . '. It may be permissions related.';
    }
  }
}
  public function valid_filename_check($str) {
    $invalid_filenames = array(
      'guide', 'general', 'tech',
      'index', 'create', 'createdoc', 'edit', 'editdoc', 'deletedoc',
      );

    if (in_array($str, $invalid_filenames))
    {
      $this->form_validation->set_message('valid_filename_check', '%s will not work as a path. Please try something else.');
      return FALSE;
    } elseif(empty($str)) {
      $this->form_validation->set_message('valid_filename_check', 'Oops, the title field is empty.');
      return FALSE;
    }
     else {
      return TRUE;
    }
  }
  public function editdoc($page) {
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
      /*$content, $filename, $type = 'general'*/
      // $this->docs_model->listFilesAsLinks('general')
      $data = array();

    // Show
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

    } else {
      redirect('/login');
    }
  }
  public function deletedoc($page) {



  }

}
