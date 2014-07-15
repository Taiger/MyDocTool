<!DOCTYPE html>
<head>
<meta charset="utf-8">
  <title>Style Guide Boilerplate</title>
  <meta name="viewport" content="width=device-width">


  <!-- Drupal CSS -->
  <link rel="stylesheet" href="drupal/system/system.base.css">
  <link rel="stylesheet" href="drupal/field/field.css">

  <link rel="stylesheet" href="vendor/bootstrap-accessibility-plugin/plugins/dist/css/bootstrap-accessibility-theme.css">

  <link rel="stylesheet" href="vendor/prism/themes/prism.css">

  <!-- processed from less/style.less -->
  <link rel="stylesheet" href="dist/css/style.css">

  <!-- CLIENTSIDE PREPROCESSING: uncomment to enable  
  <link rel="stylesheet/less" type="text/css" href="less/style.less">
  <script>
  /*documentation: http://lesscss.org/usage/#using-less-in-the-browser*/
    less = {
      env: "development",
      logLevel: 2,
      async: false,
      fileAsync: false,
      poll: 1000,
      functions: {},
      dumpLineNumbers: "all"
    };
  </script>
  <script src="vendor/less.js/dist/less-1.7.3.min.js"></script>-->

 

</head>
<body>

<header id="top" class="sg-header sg-container">
  <div class="container">
<nav role="navigation" class="navbar">

        <div class="navbar-header">
          <h1 class="sg-logo"><a href="/" class="navbar-brand">STYLE <span>GUIDE</span></a></h1>

        </div>


          <ul class="nav navbar-nav navbar-right sg-header-nav">
            <li><a href="/">All</a></li>

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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Organisms <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php if(isset($organism_links)) echo $organism_links; ?>
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


<?php if(isset($pagetpl)) echo $pagetpl; ?>

  <!-- SCRIPTS -->
  <script src="vendor/jquery/dist/jquery.min.js"></script>
  <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="vendor/bootstrap-accessibility-plugin/plugins/js/bootstrap-accessibility.min.js"></script>

  <!-- Styleguide toggling -->
  <script src="js/sg-scripts.js"></script>

  <!-- syntax highlighting -->
  <script src="vendor/prism/components/prism-core.min.js"></script>
  <script src="vendor/prism/components/prism-markup.min.js"></script>

</body>
</html>