<?php
/* Wrapper Model
 * contains universal methods for building page elements
 */
  class wrapper_model extends CI_Model {
      public function __construct() {
        parent::__construct();
      }

    // Build out $data arrays used in page templates.
    // Accepts $passed_data array to be merged with defaults and $page as a string
    //
    public function pageDefaults(array $passed_data, $page) {
      // $passed_data array is merged with $data defaults at the end of this method
      $data = array();
      // Make sure $page is a string
      $page = (string)$page;

      $data['base_url'] = base_url(); // includes ending slash
      $data['current_page'] = $page;
      $data['body_class'] = $page . '-page';
      $data['title'] = ucfirst($page);
      $data['isLoggedIn'] = $this->session->userdata('isLoggedIn');
      $data['isAdmin'] = $this->session->userdata('isAdmin');
      $data['body_class'] .= ($data['isAdmin'])? ' user-admin': '';
      $data['admin_links'] = array();

      // Code Ignitor Help Link
      if($data['isAdmin']){
        $this->load->helper('url');

        $data['admin_links']['create_doc'] = $data['base_url'].'guide/create';
        $data['admin_links']['create_pattern'] = $data['base_url'].'pattern/create';
        $data['admin_links']['codeignitor_help'] = '/user_guide';
        $data['admin_links']['clear_cache'] = $data['base_url'] . 'clearcache/' . uri_string();
        // clearCacheRedirect

      }

      // LINKS FOR DEFAULT MENU
      $default_menu_links = array(
        'all_documentation' => $data['base_url'] . '/guide',
        'all_patterns' => $data['base_url'] . '/pattern',
        );
      // DEFAULT MENUS
      $data['menus'] = array(
        array(
          'default' => array($this->buildMenu($default_menu_links)),
          'docs' => array(),
          'patterns' => array(),
          ));

      // MENU STATE DEFAULTS (menus shown conditionally in pagetpl.php)
      $data['menus']['default']['state'] = TRUE;
      $data['menus']['docs']['state'] = FALSE;
      $data['menus']['patterns']['state'] = FALSE;

      // MERGE WITH PASSED DATA
      if(!empty($passed_data)){
        $data = array_merge($data, $passed_data);
      }

      return $data;
    }
  /*
   * -Builds menu.
   * Accepts $links array as $linkname => $href and Accepts optional second param as array of classes for ul element
   * Returns full menu
   */
  public function buildMenu( array $links, $classes_array = array('nav','navbar-nav')) {
    $classes = implode(' ', $classes_array);
    $result = '<ul class="'.$classes.'" role="menu">';
    foreach($links as $linkname => $link){
      $result .= '<li><a href="'.$linkname.'">'.$link.'</a></li>' . "\n";
    }
    $result .= '</ul>';
    return $result;
  }
  /*
   * Clears the cache
   * If anything deleted returns TRUE
   * If only index.html exists but nothing else, returns string 'Already_Empty'
   * Returns FALSE If deleting a file fails for some reason
   */

  public function clearCache() {
    $result = array('Already_Empty');
    $location = 'app/cache/';
    $allCacheFiles = get_filenames($location, TRUE);

    foreach ($allCacheFiles as $fullpath) {
      // don't delete index.html
      if(preg_match('/index\.html$/i', $fullpath) == FALSE) {
        //delete everything else
        $result[] = unlink($fullpath);
      }
    }
    // fail if we can't delete a cache file
    if(in_array(FALSE, $result)) return FALSE;
    return $result;
  }

  // END CLASS
}
