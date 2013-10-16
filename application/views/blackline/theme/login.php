<?php
/**
 *
 * Package: dashboard
 * Filename: login.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 16:58
 *
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <!--  STYLESHEETS  -->
    <link href="<?=base_url()?>assets/blackline/css/bootstrap-custom.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/blackline/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/blackline/css/style.css" rel="stylesheet">


    <!--  JAVASCRIPTS  -->
    <script src="<?=base_url()?>assets/blackline/js/jquery.2-0-2.min.js"></script>
    <script src="<?=base_url()?>assets/blackline/js/bootstrap.js"></script>

    <title></title>
    <style type="text/css">
        html{
            height: 100%;
        }
        body {
            padding-bottom: 40px;
            height: 100%;
            background:url("<?=base_url()?>/assets/blackline/img/bg.jpg");
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="span6 offset4">
            <?=$yield?>
        </div><!--  END OF .SPAN6  -->
    </div><!--  END OF .ROW  -->
</div><!--  END OF .CONTAINER  -->
</body>
</html>