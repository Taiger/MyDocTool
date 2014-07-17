<?php
class docs_model extends CI_Model {

/*  public function __construct() {
    $this->load->helper('file');
  }*/

  // MENU

  public function index() {
    //
  }
  /*
   * Accepts $content as clean string, $filename as 'my_file_name.html' and optional $type
   * If valid returns filename and path if valid as a string message.
   * Otherwise returns FALSE
   */
  public function createItem($content, $filename, $type = 'general') {
    // Check for session
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
      // only two types supported right now
      if($type != 'general' && $type != 'tech'){
        return FALSE;
      }
      // Write to file
      if (write_file('docs/' . $type . '/' . $filename, $content) == FALSE) {
        return FALSE;
      } else {
        return TRUE;
      }    
    } else {
      // not logged in or not admin
      redirect('/login');
    }
  }
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
   * If valid returns filename and path if valid as a string message.
   * Otherwise returns FALSE
   */
  public function itemExists($item) {
    $filename = $item . '.html';
    $location = 'docs/';
    $allfiles = get_filenames($location, TRUE);
    foreach ($allfiles as $filepath) {
      if(preg_match('/'.$filename.'/i', $filepath)){
        $filepath = preg_split('/docs/i', $filepath);
        return 'Filename already exists at docs' . $filepath[1] . '<br>Titles must be unique regardless of category.';
      }
    }
    // no docs html file with that name
    return FALSE;
  }
  public function update($item = 'ipsum', $type = 'any') {
    //
  }
  public function delete($item = 'ipsum', $type = 'any') {
    //
  }
  // Display title of each doc file as a link
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
      $result .= '<li><a href="'.$filename.'">'.$title.'</a></li>' . "\n";
    }
    return $result;
  }
}
