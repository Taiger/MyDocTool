<div class="sg-body container">

  <div class="sg-info">               
    <div class="sg-about sg-section">
      <h2 class="sg-h2"><a id="sg-about" class="sg-anchor">About</a></h2>
      <p>This is the styleguide for ASP3 to be used as a foundation for other styleguides. It uses Bower for package management, Grunt for build tasks, and CodeIgnitor 2.2 for MVC routing goodness.</p>
      <p>The patterns are stored as html files inside a directory based on their pattern type. That directory is located at /patterns (<a target="_blank" href="/patterns">pattern directory</a>).
      The structure is based off of the Atomic Design system(<a target="_blank" href="http://patternlab.io/about.html">about Atomic Design</a>). There are five types of patterns in atomic design: <a target="_blank" href="http://patternlab.io/about.html#atoms">atoms</a>, <a target="_blank" href="http://patternlab.io/about.html#molecules">molecules</a>, <a target="_blank" href="http://patternlab.io/about.html#organisms">organisms</a>, <a target="_blank" href="http://patternlab.io/about.html#templates">templates</a> and <a target="_blank" href="http://patternlab.io/about.html#pages">pages</a>.
      Each site/sub-site/landing-page will also have a simplified Style Tile for color schemes, fonts and textures (<a target="_blank" href="http://styletil.es/">styletil.es</a>).</p>
    </div><!--/.sg-about-->
    
  <?php echo $styletiles; ?>

  <div class="sg-base-styles">    
    <h1 class="sg-h1">Atoms<small> - basic tags, such as form labels, inputs or buttons.</small></h1>
    <?php //showMarkup('base'); ?>
    <?php echo $atoms; ?>
  </div><!--/.sg-base-styles-->


  <div class="sg-pattern-styles">
    <h1 class="sg-h1">Molecules<small> - groups of elements that function together as a unit. For example, a form label, search input, and button atom can combine them together to form a search form molecule.</small></h1>
    <?php //showMarkup('patterns'); ?>
    <?php echo $molecules; ?>
    </div><!--/.sg-pattern-styles-->

  <div class="sg-pattern-styles">
    <h1 class="sg-h1">Organisms<small> - groups of molecules (and possibly atoms) joined together to form distinct section of an interface.</small></h1>
    <?php //showMarkup('patterns'); ?>
    <?php echo $organisms; ?>
    </div><!--/.sg-pattern-styles-->

    <?php if(isset($content)) echo $content; ?>


  </div><!--/.sg-body-->