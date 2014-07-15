<?php


class Pages extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('markup_model');
  }

  public function view($page = 'home')
  {

  // Defaults
  $data['current_page'] = $page;
  $data['body_class'] = $page . '-page';
  $data['title'] = ucfirst($page);
  $data['styles'] = array();

  // Pattern Links
  $data['styletile_links'] = $this->markup_model->listMarkupAsLinks('styletiles');
  $data['atom_links'] = $this->markup_model->listMarkupAsLinks('atoms');
  $data['molecule_links'] = $this->markup_model->listMarkupAsLinks('molecules');
  $data['organism_links'] = $this->markup_model->listMarkupAsLinks('components');
  $data['template_links'] = $this->markup_model->listMarkupAsLinks('templates');
  $data['pagelayout_links'] = $this->markup_model->listMarkupAsLinks('pages');
  $data['header_links'] = $data['styletile_links'] . $data['atom_links'] . $data['molecule_links'];

  // home
  if($page == 'home'){
    $data['title'] = 'Style Guide';
    $data['body_class'] = 'home-page';
    
    // Pattern Markup
    $data['styletiles'] = $this->markup_model->getAllStyletiles();
    $data['atoms'] = $this->markup_model->getAllofType('atoms');
    $data['molecules'] = $this->markup_model->getAllofType('molecules');
    $data['components'] = $this->markup_model->getAllofType('components');

    // Apply to templates
    $data['content'] = $this->load->view('pages/home', $data, TRUE);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  } else {
    //
    $data['title'] = 'Pattern ' . $page;
    $data['body_class'] = $page . '-page';


    $data['content'] = $this->markup_model->getItem($page);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  }

  
  }
}
