<?php
class docs_model extends CI_Model {
  public function __construct() {
    parent::__construct();
  }
  /*
   * Accepts $content as clean string, $filename as 'my_file_name.html' and optional $type
   * If created returns TRUE
   * Otherwise returns FALSE
   */
  public function createItem($content, $filename, $type = 'general') {
      // only two types supported right now
      if($type != 'general' && $type != 'tech'){
        return FALSE;
      }
      // Write to file
      if (write_file('docs/' . $type . '/' . $filename, $content) == FALSE) {
        return FALSE;
      } else {
        // Try to set permissions or return FALSE
        if(!chmod('docs/' . $type . '/' . $filename, 0764)) return FALSE;
        // We are good
        return TRUE;
      }
  }
  /*
   * Accepts $item as $filename like 'my_file_name' and optional $type
   * If found returns html content of first html file found
   * Otherwise returns error message for display
   */
  public function getItem($item, $type = 'any') {
    $files = array(); // in case multiple matches
    $allfiles = array();
    $filename = $item . '.html';
    $location = 'docs/';

    // if specific type only (like Tech or General)
    if($type !== 'any'){
      $location .= $type . '/';
    }

    $allfiles = get_filenames($location, TRUE);

    // if no files are found return false
    if(empty($allfiles)){
      return 'Sorry, no files found of type '.$type.'.';
    }

    // list all child files
    foreach ($allfiles as $filepath) {
      if(preg_match('/'.$filename.'/i', $filepath)){
        $files[] = $filepath;
      }
    }
    if(empty($files)){
      return 'I am not finding ' .$filename. '. Sorry about that.';
    } else {
      // Return first match
      return htmlspecialchars_decode(read_file($files[0]));
    }

  }
  /*
   * Accepts $item like 'my_file_name'
   * If valid returns array containing already exists message and type(category)
   * Otherwise returns FALSE
   */
  public function itemExists($item) {
    $result = array();
    $filename = $item . '.html';
    $location = 'docs/';
    $allfiles = get_filenames($location, TRUE);
    foreach ($allfiles as $fullpath) {
      if(preg_match('/'.$filename.'/i', $fullpath)){
        $filepath = preg_split('/docs/i', $fullpath);
        $loc = explode('/', $filepath[1]);
        $result['message'] = 'Filename already exists at docs' . $filepath[1] . '<br>Titles must be unique regardless of category.';
        $result['type'] = $loc[1];
        $result['fullpath'] = $fullpath;
        return $result;
      }
    }
    // no docs html file with that name
    return FALSE;
  }
  /*
   * Accepts $item like 'my_file_name'
   * If deleted returns message string
   * Otherwise returns FALSE
   */
  public function itemDelete($item) {
    $exists = $this->itemExists($item);
    if($exists){
      unlink($exists['fullpath']);
      return 'Deleted '. $item . '.html';
    } else {
      return FALSE;
    }
  }
  /*
   * Accepts $type as directories under docs directory
   * Returns html list with filename and link to file
   * Otherwise returns html list with message not found
   */
  public function listFilesAsLinks($type = 'general') {
    $result = '';
    $files = array();
    $handle = opendir('docs/'.$type);
    while (false !== ($file = readdir($handle))){
      if(stristr($file,'.html')) {
        $files[] = $file;
      }
    }

    // if no files are found return false
    if(empty($files)){
      return '<li><small> No '.$type.' docs yet.</small></li>';
    }

    // Sort alphabetically
    sort($files);
    foreach ($files as $file){
      $filename = preg_replace("/\.html$/i", "", $file);
      $title = preg_replace("/\-/i", " ", $filename);
      $title = ucwords($title);
      $result .= '<li><a href="/guide/'.$filename.'">'.$title.'</a></li>' . "\n";
    }
    return $result;
  }
  /*
   * -Builds menu.
   * Accepts optional $classes_array but is a dropdown-menu by default.
   * Returns menu
   */
  public function buildMenu($classes_array = array('dropdown-menu')) {
    $classes = implode(' ', $classes_array);
    //listFilesAsLinks
    $result = '<ul class="'.$classes.'" role="menu">';
    $types = array('general','tech'); // Available doc types
    foreach($types as $type){
      $result .= $this->listFilesAsLinks($type);
    }
    $result = '</ul>';
    return $result;
  }
  /*

      $data['menus']['docs']['general_docs'] = array();
      $data['menus']['docs']['tech_docs'] = array();

      $data['menus']['patterns']['atoms'] = array();
      $data['menus']['patterns']['molecules'] = array();
      $data['menus']['patterns']['components'] = array();
      $data['menus']['patterns']['templates'] = array();
      $data['menus']['patterns']['pages'] = array();
      $data['menus']['patterns']['style_tiles'] = array();

  */
}
