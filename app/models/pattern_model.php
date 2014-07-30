<?php
class Pattern_model extends CI_Model {
    public function __construct() {
      parent::__construct();
    }

  // Display pattern view & source by type
  public function getAllofType($type, $showsource = TRUE) {
    $result = '';
    $files = array();
    $handle = opendir('patterns/'.$type);
    while (false !== ($file = readdir($handle))){
        if(stristr($file,'.html')){
            $files[] = $file;
        }
    }

    // if no files are found return false
    if(empty($files)){
      return '<p>No '.$type.' patterns yet.</p>';
    }

    // Sort alphabetically
    sort($files);
    foreach ($files as $file) {
        $filename = preg_replace("/\.html$/i", "", $file);
        $title = preg_replace("/\-/i", " ", $filename);

        $result .= '<div class="sg-markup sg-section">';
        $result .= '<div class="sg-display">';
        $result .= '<h2 class="sg-h2"><a href="'.$filename.' "id="'.$filename.'" class="sg-anchor">'.$title.' <span class="glyphicon glyphicon-chevron-right"></a></h2>';

        // TODO Add documentation support
        //$documentation = 'doc/'.$type.'/'.$file;
        /*//
          if (file_exists($documentation)) {
          $result .= '<div class="sg-doc">';
          $result .= '<h3 class="sg-h3">Usage</h3>';
          $result .= htmlspecialchars_decode(file_get_contents($documentation));
          $result .= '</div>';
        }*/

        $result .= htmlspecialchars_decode(file_get_contents('patterns/'.$type.'/'.$file));
        $result .= '</div>';
        if($showsource) {
            $result .= '<div class="sg-markup-controls"><a class="sg-btn sg-btn--source" href="'.$filename.' ">View Source</a></div>';
            $result .= '<div class="sg-source sg-expandable">';
            $result .= '<pre class="language-markup"><code>';
            $result .= htmlspecialchars(file_get_contents('patterns/'.$type.'/'.$file));
            $result .= '</code></pre>';
          }
        $result .= '</div>';
        $result .= '</div>';
    }

    return $result;
  }

  // Display pattern view & source for single file. Used for individual pages.
  public function showItem($item, $showsource = TRUE) {

    $result = '';
    $files = array(); // in case multiple matches
    $title = preg_replace("/\-/i", " ", $item);
    $title = ucwords($title);

    $filename = $item . '.html';
    $allfiles = get_filenames('patterns', TRUE); // returns array of full file paths contained in child directories
    foreach ($allfiles as $filepath) {
      if(preg_match('/'.$filename.'/i', $filepath)){
        $files[] = $filepath;
      }
    }

    // if item is not found return message
    if(empty($files)){
      return '<p>No pattern found of the name <strong>'.$item.'</strong>.</p>';
    }

    foreach ($files as $file) {
      $result .= '<div class="sg-markup sg-section">';
      $result .= '<div class="sg-display">';
      $result .= '<h1 class="sg-h1"><a id="sg-'.$item.'" class="sg-anchor">'.$title.'</a></h1>';

      // TODO add documentation support
      //$documentation = 'doc/'.$type.'/'.$file;
      /*    if (file_exists($documentation)) {
            $result .= '<div class="sg-doc">';
            $result .= '<h3 class="sg-h3">Usage</h3>';
            $result .= htmlspecialchars_decode(file_get_contents($documentation));
            $result .= '</div>';
          }*/

      $result .= htmlspecialchars_decode(read_file($file));
      $result .= '</div>';
      $result .= '<hr>';
      if($showsource) {
          //$result .= '<div class="sg-markup-controls"><a class="sg-btn sg-btn--source" href="#">View Source</a></div>';
          $result .= '<div class="sg-source sg-animated">';
          $result .= '<pre class="language-markup linenums"><code>';
          $result .= htmlspecialchars(read_file($file));
          $result .= '</code></pre>';
          $result .= '</div>';
        }
      $result .= '</div>';
    }

    return $result;
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
    $location = 'patterns/';

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

  // Display Styletiles
  public function getAllStyletiles() {
    $result = '';
    $files = array();
    $handle = opendir('patterns/styletiles');
    while (false !== ($file = readdir($handle))){
        if(stristr($file,'.html')){
            $files[] = $file;
        }
    }
    // if no files are found return false
    if(empty($files)){
      return false;
    }

    sort($files);
    foreach ($files as $file) {
        $filename = preg_replace("/\.html$/i", "", $file);
        $title = preg_replace("/\-/i", " ", $filename);
        $documentation = 'doc/styletiles/'.$file;

        $result .= '<div class="sg-section">';
        $result .= '<div class="sg-display">';
        $result .= '<h2 class="sg-h2"><a id="sg-'.$filename.'" class="sg-anchor">'.$title.'</a></h2>';

        if (file_exists($documentation)) {
          $result .= '<div class="sg-doc">';
          $result .= '<h3 class="sg-h3">Usage</h3>';
          $result .= htmlspecialchars_decode(file_get_contents($documentation));
          $result .= '</div>';
        }

        $result .= htmlspecialchars_decode(file_get_contents('patterns/styletiles/'.$file));
        $result .= '</div>';
        $result .= '</div>';
    }

    return $result;
  }

  /*
   * -Builds links list by pattern type
   * Accepts required $type
   * Returns li with title of each pattern as a link
   */
  public function listPatternsAsLinks($type) {
    $result = '';
    $files = array();
    $handle = opendir('patterns/'.$type);
    while (false !== ($file = readdir($handle))){
        if(stristr($file,'.html')) {
            $files[] = $file;
        }
    }

    // if no files are found return false
    if(empty($files)){
      return '<li><small> No '.$type.' patterns yet.</small></li>';
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
  /*
   * -Builds menu.
   * Accepts optional $classes_array but is a dropdown-menu by default.
   * Returns menu
   */
  public function buildMenu($classes_array = array('dropdown-menu')) {
    $classes = implode(' ', $classes_array);
    //listFilesAsLinks
    $result = '<ul class="'.$classes.'" role="menu">';
    $types = array('atoms', 'molecules', 'components', 'templates', 'pages', 'style_tiles'); // Available pattern types
    foreach($types as $type){
      $result .= $this->listPatternsAsLinks($type);
    }
    $result = '</ul>';
    return $result;
  }

  /*
   * Accepts $content as clean string, $filename as 'my_file_name.html' and optional $type
   * If created returns TRUE
   * Otherwise returns FALSE
   */
  public function createItem($content, $filename, $type = 'atoms') {
      // only two types supported right now
      if(in_array($type, array('atoms','molecules','components','templates','pages'))){
        //return FALSE;
      }
      //die(print_r(array($type,$filename,$content)));
      // Write to file
      if (write_file('patterns/' . $type . '/' . $filename, $content) == FALSE) {
        return FALSE;
      } else {
        // Try to set permissions or return FALSE
        if(!chmod('patterns/' . $type . '/' . $filename, 0764)) return FALSE;
        // We are good
        return TRUE;
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
    $location = 'patterns/';
    $allfiles = get_filenames($location, TRUE);
    foreach ($allfiles as $fullpath) {
      if(preg_match('/'.$filename.'/i', $fullpath)){
        $filepath = preg_split('/patterns/i', $fullpath);
        $loc = explode('/', $filepath[1]);
        $result['message'] = 'Filename already exists at patterns' . $filepath[1] . '<br>Titles must be unique regardless of pattern type.';
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


}
