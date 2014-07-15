  <?php
  class Markup_model extends CI_Model {

  public function __construct() {
    $this->load->helper('file');
  }

  // MENU
  // Display title of each markup samples as a link
  public function listMarkupAsLinks($type) {
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

  // Display markup view & source by type
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

  // Display markup view & source for single file. Used for individual pages.
  public function getItem($item, $showsource = TRUE) {

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
      if($showsource) {
          //$result .= '<div class="sg-markup-controls"><a class="sg-btn sg-btn--source" href="#">View Source</a></div>';
          $result .= '<div class="sg-source sg-animated">';
          $result .= '<pre class="language-markup linenums"><code>';
          $result .= htmlspecialchars(read_file($file));
          $result .= '</code></pre>';
        }
      $result .= '</div>';
      $result .= '</div>';
    }

    return $result;
  }


  // Display markup view & source
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

}