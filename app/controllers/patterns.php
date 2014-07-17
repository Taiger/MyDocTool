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


  // Pattern Links
  $data['styletile_links'] = $this->pattern_model->listPatternsAsLinks('styletiles');
  $data['atom_links'] = $this->pattern_model->listPatternsAsLinks('atoms');
  $data['molecule_links'] = $this->pattern_model->listPatternsAsLinks('molecules');
  $data['organism_links'] = $this->pattern_model->listPatternsAsLinks('components');
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

    // Apply to templates
    $data['content'] = $this->load->view('pages/allpatterns', $data, TRUE);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  } else {
    //
    $data['title'] = 'Pattern ' . $page;
    $data['body_class'] = $page . '-page';


    $data['content'] = $this->pattern_model->getItem($page);
    $data['pagetpl'] = $this->load->view('templates/pagetpl', $data, TRUE);
    $this->load->view('templates/htmltpl', $data);

  }

  
  }
}
