<?php
/**
 *
 * Package: dashboard
 * Filename: application.php
 * Author: solidstunna101
 * Date: 18/10/13
 * Time: 16:53
 *
 */
?>


<?php
//set act uri to first segment wit a text data type
$act_uri = $this->uri->segment(1, 0);

//sets last segment to total segments
$lastsec = $this->uri->total_segments();

//submenu will be total uri segments
$act_uri_submenu = $this->uri->segment($lastsec);

//if segment uri doesn't exist set it equals to dashboard
if(!$act_uri){$act_uri= 'dashboard';}

//if submenu is not numeric, decrement it.
if(is_numeric($act_uri_submenu)){
    $lastsec = $lastsec-1;
    $act_uri_submenu = $this->uri->segment($lastsec);
}
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
