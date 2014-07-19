<?php
/* Wrapper Model
 * contains universal methods for building page elements
 */
  class wrapper_model extends CI_Model {
      public function __construct() {
        parent::__construct();
      }

    // Build out $data variable that is used in page templates. Accepts
    public function pageDefaults($data = array(), $page = 'unknown') {

      if($page == 'unknown'){
        $page = explode('/', 'test');
        $last = count($page);
        $page = $page[$last];
      }
      if(empty($data)){
        $data = array();
      }

      $data['base_url'] = base_url(); // includes ending slash
      $data['current_page'] = $page;
      $data['body_class'] = $page . '-page';
      $data['title'] = ucfirst($page);
      $data['isLoggedIn'] = $this->session->userdata('isLoggedIn');
      $data['isAdmin'] = $this->session->userdata('isAdmin');
      $data['admin_links'] = array();

      // Code Ignitor Help Link
      if($data['isAdmin']){
        $data['admin_links']['create_doc'] = $data['base_url'].'guide/create';
        $data['admin_links']['codeignitor_help'] = '/user_guide';
      }

      // MENUS
      $data['menus'] = array();
      $data['menus']['default'] = array();
      $data['menus']['default']['all_patterns'] = $data['base_url'] . 'allpatterns';
      $data['menus']['default']['all_documentation'] = $data['base_url'] . 'guide';
      // DOCS
      $data['menus']['docs'] = array();
      // PATTERNS
      $data['menus']['patterns'] = array();

      return $data;
    }
  /*
   * -Builds menu. 
   * Accepts optional $classes_array but is a dropdown-menu by default.
   * Returns menu
   */
  public function buildMenu($classes_array = array('nav','navbar-nav','navbar-right','sg-header-nav'), $menu_array) {
    $classes = implode(' ', $classes_array);
    //listFilesAsLinks
    $result = '<ul class="'.$classes.'" role="menu">';
    $types = array('general','tech'); // Available doc types
    foreach($types as $type){
      $result .= '<li><a href="'.$filename.'">'.$title.'</a></li>' . "\n";
    }
    $result = '</ul>';
    return $result;
  }
  }
