<header id="top" class="sg-header sg-container">
  <div class="container">
        <div class="navbar-header">
          <h1 class="sg-logo"><a href="/" class="navbar-brand">PATTERNS &amp;<span> DOCS</span></a></h1>

        </div>
        <button class="navbar-toggle sg-navbar-toggle" type="button" data-toggle="collapse" data-target="#sg-primary-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
<nav id="sg-primary-navbar-collapse-1" role="navigation" class="navbar navbar-collapse collapse">

        
          <ul class="nav navbar-nav navbar-right sg-header-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">General Docs<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/">Coming soon</a></li>
                  <?php //if(isset($atom_links)) echo $atom_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tech Docs<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/">Coming soon</a></li>
                  <?php //if(isset($atom_links)) echo $atom_links; ?>
                </ul>
            </li>

            <li><a href="/">All Patterns</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Atoms <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($atom_links)) echo $atom_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Molecules <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($molecule_links)) echo $molecule_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Components <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($component_links)) echo $component_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Templates <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($template_links)) echo $template_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($pagelayout_links)) echo $pagelayout_links; ?>
                </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Style Tiles <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($styletile_links)) echo $styletile_links; ?>
                </ul>
            </li>

          </ul>
        
     
    </nav>
  </div><!-- /.container -->
</header>

<div class="sg-body container">

    <?php if(isset($content)) echo $content; ?>

  </div><!--/.sg-body-->

  <footer class="footer sg-footer">
    <ul class="nav nav-pills pull-right">
      <li>
        <?php if(isset($isLoggedIn) && $isLoggedIn == TRUE) {
          echo '<a href="/logout">Logout</a>';
        } else {
          echo '<a href="/login">Login</a>';
        } ?>
      </li>
    </ul>
  </footer>