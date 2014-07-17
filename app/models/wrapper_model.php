<?php
/* Wrapper Model
 * contains universal methods for building page elements
 */
  class wrapper_model extends CI_Model {
      /*public function __construct() {
        parent::__construct();
      }*/
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
      $data['current_page'] = $page;
      $data['body_class'] = $page . '-page';
      $data['title'] = ucfirst($page);
      $data['isLoggedIn'] = $this->session->userdata('isLoggedIn');
      $data['isAdmin'] = $this->session->userdata('isAdmin');
      $data['admin_links'] = array();

      // Code Ignitor Help Link
      if($data['isAdmin']){
        $data['admin_links']['codeignitor_help'] = '/user_guide';
      }

      return $data;
    }

  }
