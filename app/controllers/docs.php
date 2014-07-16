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
    $data['edit_links'] = array();
    $data['edit_links']['edit'] = 'edit'. '/' .$page;

    // If an index page at guide/ or guide/tech or guide/general
    if($page == 'index') {
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
  public function create() {
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
      /*$content, $filename, $type = 'general'*/

    } else {
      //show_error('message' [int $status_code= 500 ] );
      redirect('/login');
    }
  }
  public function edit($page) {
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
      /*$content, $filename, $type = 'general'*/

    } else {
      //show_error('message' [, int $status_code= 500 ] );
      redirect('/login');
    }
  }
  public function delete($page) {

  }

}
