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