<?php
class docs_model extends CI_Model {

/*  public function __construct() {
    $this->load->helper('file');
  }*/

  // MENU

  public function index() {
    //
  }
  public function create($content, $filename, $type = 'general') {
    // Check for session
    if($this->session->userdata('isLoggedIn') && $this->session->userdata('isAdmin')){
      /*$content, $filename, $type = 'general'*/
      //$thing = write_file('docs/general/madeincode.html', 'test-content');
      //return TRUE;
      if (write_file('docs/' . $type . '/' . $filename, $content) == FALSE) {
        return FALSE;
      } else {
        return TRUE;
      }    
    } else {
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
      $title = preg_replace("/\_/i", " ", $filename);
      $title = ucwords($title);
      $result .= '<li><a href="'.$filename.'">'.$title.'</a></li>' . "\n";
    }
    return $result;
  }
}
