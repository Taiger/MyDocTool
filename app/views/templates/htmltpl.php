<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.png?v1" />

  <title>Documentation and Style Guide | <?php echo $title; ?></title>

  <!-- Drupal CSS -->
  <link rel="stylesheet" href="/drupal/system/system.base.css?v1">
  <link rel="stylesheet" href="/drupal/field/field.css?v1">

  <!-- <link rel="stylesheet" href="/vendor/bootstrap-accessibility-plugin/plugins/dist/css/bootstrap-accessibility-theme.css?v1"> -->

  <link rel="stylesheet" href="/vendor/prism/themes/prism.css?v1">

  <!-- processed from less/style.less -->
  <link rel="stylesheet" href="/dist/css/style.css?v1">

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

<?php if(isset($pagetpl)) echo $pagetpl; ?>

  <!-- SCRIPTS -->
  <script src="/vendor/jquery/dist/jquery.min.js?v1"></script>
  <script src="/vendor/bootstrap/dist/js/bootstrap.min.js?v1"></script>
  <script src="/vendor/bootstrap-accessibility-plugin/plugins/js/bootstrap-accessibility.min.js?v1"></script>

  <!-- Styleguide toggling -->
  <script src="/js/sg-scripts.js"></script>

  <!-- syntax highlighting -->
  <script src="/vendor/prism/components/prism-core.min.js?v1"></script>
  <script src="/vendor/prism/components/prism-markup.min.js?v1"></script>

<script src="//asp-sg.eggdude.dev:35729/livereload.js"></script>


  <!-- extra scripts -->
  <?php if(isset($scripts)) {
    foreach($scripts as $script){
      echo '<script src="' . $script . '"></script>';
        };
      }
  ?>

</body>
</html>
