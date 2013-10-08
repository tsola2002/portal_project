<?php 
header('Content-type: text/html; charset=ISO-8859-1');
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/blackline/js/jquery.min.js"></script>
    <link rel="SHORTCUT ICON" href="../assets/blackline/img/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/jquery-ui-1.8.16.custom.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/custom.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/prettify.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/wysiwyg-color.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/fontello.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/fam-icons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/jquery.jscrollpane.css" />
    <link rel="stylesheet" type="text/css" href="../assets/blackline/css/bootstrap-toggle-buttons.css" />
      <link href="../assets/blackline/css/install.css" rel="stylesheet" type="text/css" />
      <link rel="SHORTCUT ICON" href="../assets/blackline/img/favicon.ico" />
      <script src="../assets/blackline/js/jquery.min.js"></script>
      <script type="text/javascript" src="../assets/blackline/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="../assets/blackline/js/jquery-ui-1.8.16.custom.min.js"></script>
      <script type="text/javascript" src="../assets/blackline/js/jquery.validate.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
        $("form#step3").validate();
      });

      </script>
      <style type="text/css">
      html{
        height: 100%;
      }
      body {
        padding-bottom: 40px;
        height: 100%;
        background:url("../assets/blackline/img/bg.png");
      }
      
    </style>

  <title>Freelance Cockpit 2 - Installation</title>
 </head>
 <body>
  	<div id="install-header">
  	<img src="../assets/blackline/img/logo.png" />
	</div>
    <div class="install">
      <?php 
        require("install.php");
      ?>
    </div>
        <br>
 </body>
</html>