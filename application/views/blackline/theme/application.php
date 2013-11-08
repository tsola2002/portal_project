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
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row-fluid">
            <div id="sidebar" class="span2">
                <div class="full_sidebarbg span2 hidden-phone"></div>
                <div class="sidebar-nav">
                    <div class="logo"><img src="<?=base_url()?><?=$core_settings->logo;?>" alt="<?=$core_settings->company;?>"/></div>

                    <div class="agent-info ">
                        <div class="agent-pic shadow"><img src="
               <?php
                            //if user pic is no nopic.png
                            //then spit out correct user pic
                            if($this->user->userpic != 'no-pic.png'){
                                echo base_url()."files/media/".$this->user->userpic;
                            }else{
                                //use gravatar pic instead
                                echo get_gravatar($this->user->email);

                            }
                            ?>
                " /></div>
                        <div class="username">
                            <a href="<?=site_url("agent");?>" class="user" data-toggle="modal"><?php echo $this->user->firstname." ".$this->user->lastname;?></a>
                            <br/><small><?=$this->user->title;?></small>
                            <a href="#" id="openmenu" class="visible-phone visible-tablet pull-right" ></a>
                        </div><!--END OF USERNAME-->


                    </div><!--END OF AGENT-INFO-->

                    <ul class="nav dark nav-list clear hidden-phone hidden-tablet" id="menu">

                        <?php foreach ($menu as $key => $value) { ?>
                            <li id="<?=strtolower($value->name);?>"><a href="<?=site_url($value->link);?>"><i class="<?=$value->icon;?>"></i> <?php echo $this->lang->line('application_'.$value->link);?>
                                    <?php if(strtolower($value->name) == "messages" && $messages_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$messages_new[0]->amount;?></span><?php } ?>
                                    <?php if(strtolower($value->name) == "quotations" && $quotations_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$quotations_new[0]->amount;?></span><?php } ?>
                                    <?php if(strtolower($value->name) == "tickets" && $tickets_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$tickets_new[0]->amount;?></span><?php } ?>
                                </a> </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php
                foreach ($widgets as $key => $val) {

                    if($sticky && $val->link == "quickaccess"){ ?>
                        <div class="widget hidden-phone hidden-tablet">
                            <h6><?=$this->lang->line('application_quick_access');?></h6>
                            <?php foreach ($sticky as $value): ?>
                                <small><a href="<?=base_url()?>projects/view/<?=$value->id;?>"><?=character_limiter($value->name, 15);?></a></small>
                                <span class="label pull-right tt <?php if(empty($value->tracking)){ echo ' label-light " title="'.$this->lang->line("application_start_timer").'" ';}else{echo 'label-info" title="'.$this->lang->line("application_stop_timer").'" ';} ?>" rel="tooltip" data-placement="right"><a href="<?=base_url()?>projects/tracking/<?=$value->id;?>" id="<?=$value->id;?>"><i class="icon-time icon-white"></i></a></span>
                                <div class="progress progress-striped active <?php if($value->progress== "100"){ echo "progress-success"; } ?>">
                                    <div class="bar" style="width:<?=$value->progress;?>%"></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php }

                    if($user_online && $val->link == "useronline"){ ?>
                        <div class="widget hidden-phone hidden-tablet">
                            <h6><?=$this->lang->line('application_user_online');?></h6>
                            <ul class="user-list">
                                <?php foreach ($user_online as $value): ?>
                                    <li> <img width="18px" class="userpic shadow" src="
               <?php
                                        if($value->userpic != 'no-pic.png'){
                                            echo base_url()."files/media/".$value->userpic;
                                        }else{
                                            echo get_gravatar($value->email);
                                        }
                                        ?>
                " /> <?php echo $value->firstname." ".$value->lastname;?> <span class="pull-right"><img src="<?=base_url()?>assets/blackline/img/<?php if($value->last_active+(15 * 60) > time()){ echo "online";}else{echo "away";} ?>.png"/></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        </div>
                    <?php } } ?>

            </div><!--/span-->

            <ul class="span10 breadcrumb">
                <li class="hidden-phone"><span class="divider">You are here:</span></li>
                <li class="hidden-phone"><a href="<?=site_url();?>">Home</a> <span class="divider hidden-phone">></i></span></li>
                <li><a href="<?=site_url($act_uri);?>"><?=ucwords($this->lang->line('application_'.$act_uri));?></a></li>
                <?php if($act_uri_submenu != $act_uri && $act_uri_submenu != ""){ ?><li class="active"><span class="divider">></span> <?=ucwords($act_uri_submenu);?></li><?php } ?>
                <li class="pull-right"><a href="<?=site_url("logout");?>" class="btn btn-mini"><i class="icon-off"></i></a></li>
                <li class="pull-right" >

                    <div class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                            <img src="<?=base_url()?>assets/blackline/img/<?php if($this->input->cookie('language') != ""){echo $this->input->cookie('language');}else{echo "english";} ?>.png" style="margin-top:-1px" align="middle">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                            <?php if ($handle = opendir('application/language/')) {

                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != "..") {
                                        ?><li><a href="<?=base_url()?>agent/language/<?=$entry;?>"><img src="<?=base_url()?>assets/blackline/img/<?=$entry;?>.png" class="language-img"><?=ucwords($entry);?></a></li><?php
                                    }
                                }

                                closedir($handle);
                            }
                            ?>

                        </ul>
                    </div>

                </li>
            </ul>
            <div class="span10 white">

                <?=$yield?>


                <hr>
                <footer>
                    <p><?=$core_settings->company;?> <small>Made by omatsola isaac sobotie v.<?=$core_settings->version;?></small></p>
                </footer>
            </div><!--/span-->
        </div><!--/row-->
            <?=$yield?>

    </div><!--  END OF .ROW  -->
</div><!--  END OF .CONTAINER  -->
</body>
</html>
