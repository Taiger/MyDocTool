<header id="top" class="sg-header sg-container">
  <div class="container">


    <div class="sg-navbar-header">
      <a class="sg-navbar-brand logo" href="/">
        <h1 class="sg-logo">PATTERNS &amp;<span> DOCS</span></h1>
      </a>
    </div>

    <button class="navbar-toggle sg-navbar-toggle" type="button" data-toggle="collapse" data-target="#sg-primary-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
    <nav id="sg-primary-navbar-collapse-1" role="navigation" class="navbar sg-navbar navbar-collapse collapse">



      <ul class="nav navbar-nav navbar-right sg-header-nav">


        <?php if($menus['default']['state'] == TRUE): ?>

        <li class="sg-menu-default">
          <a href="/allpatterns" >All Patterns</a>
        </li>

      <?php endif; ?>
      <?php if($menus['patterns']['state'] == TRUE): ?>


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

    <?php endif; ?>
    <?php if($menus['default']['state'] == TRUE): ?>

    <li class="sg-menu-default">
      <a href="/guide" >All Documentation</a>
    </li>

  <?php endif; ?>
  <?php if($menus['docs']['state'] == TRUE): ?>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">General Topics <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
      <?php if(isset($general_links)) echo $general_links; ?>
    </ul>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tech Topics <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
      <?php if(isset($tech_links)) echo $tech_links; ?>
    </ul>
  </li>

<?php endif; ?>
</ul>


</nav>
</div><!-- /.container -->
</header>

<div class="sg-body container">

  <?php if(isset($content)) echo $content; ?>

</div><!--/.sg-body-->

<footer class="footer sg-footer">
  <ul class="sg-admin-links nav-pills pull-right">
    <?php if(isset($admin_links) && $isLoggedIn) {

      foreach($admin_links as $name => $link) {
        $classes = 'btn btn-sm';
/**/    if (preg_match('/^create/i', $name)){
          $classes .= ' btn-success';
        } elseif(preg_match('/^edit/i', $name)) {
          $classes .= ' btn-warning';
        } elseif ($name == 'delete') {
          $classes .= ' btn-danger';
        }
        echo '<li><a class="'.$classes.'" href="'.$link.'">'.ucwords(preg_replace('/_/i', ' ', $name)).'</a></li>';
      }
    }
    ?>
      <li>
        <?php if(isset($isLoggedIn) && $isLoggedIn == TRUE) {
          echo '<a class="btn btn-sm" href="/logout">Logout</a>';
        } else {
          echo '<a class="btn btn-sm" href="/login">Login</a>';
        } ?>
      </li>
    </ul>
  </footer>
