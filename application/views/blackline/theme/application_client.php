<?php 
        $act_uri = $this->uri->segment(1, 0);
        $lastsec = $this->uri->total_segments();
        $act_uri_submenu = $this->uri->segment($lastsec);
        if(!$act_uri){$act_uri= 'dashboard';}
        if(is_numeric($act_uri_submenu)){ 
            $lastsec = $lastsec-1; 
            $act_uri_submenu = $this->uri->segment($lastsec);
        }
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<html>
  <head> 
    <title><?=$core_settings->company;?></title>  
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?=base_url()?>assets/blackline/js/jquery.min.js"></script>
    <link rel="SHORTCUT ICON" href="<?=base_url()?>assets/blackline/img/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/jquery-ui-1.8.16.custom.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/custom.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/prettify.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/wysiwyg-color.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/fontello.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/fam-icons.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/jquery.jscrollpane.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/user.css"/>  
    <style type="text/css">
      html{
        height: 100%;
      }
      body {
        padding-bottom: 40px;
        height: 100%;
      }  
    </style>
        <!--[if gte IE 8]>
      <style type="text/css">
        #file, #file2{ display:block !important; width:470px;}
        .dummyfile{ display: none !important;}
      </style>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blackline/css/bootstrap-responsive.css"/>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
  <body>
      <div class="container-fluid">

      <div class="row-fluid">
        <div id="sidebar" class="span2">
          <div class="full_sidebarbg span2 hidden-phone"></div>
          <div class="sidebar-nav">
            <div class="logo"><img src="<?=base_url()?><?=$core_settings->logo;?>" alt="<?=$core_settings->company;?>"/></div>

            <div class="agent-info ">
              <div class="agent-pic shadow"><img src="
               <?php 
                if($this->client->userpic != 'no-pic.png'){
                  echo base_url()."files/media/".$this->client->userpic;
                }else{
                  echo get_gravatar($this->client->email);
                }
                 ?>
                " /></div>
              <div class="username">
                <a href="<?=site_url("agent");?>" class="user" data-toggle="modal"><?php echo $this->client->firstname." ".$this->client->lastname;?></a> 
                <br/><small><?=$this->client->company->name;?></small>
                <a href="#" id="openmenu" class="visible-phone visible-tablet pull-right" ></a>
              </div>
              

            </div>
            
            <ul class="nav dark nav-list clear hidden-phone hidden-tablet" id="menu">
            
              <?php foreach ($menu as $key => $value) { ?>
               <li id="<?=strtolower($value->name);?>"><a href="<?=site_url($value->link);?>"><i class="icon-white <?=$value->icon;?>"></i> <?php echo $this->lang->line('application_'.$value->link);?>
                <?php if(strtolower($value->name) == "messages" && $messages_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$messages_new[0]->amount;?></span><?php } ?>
                <?php if(strtolower($value->name) == "quotations" && $quotations_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$quotations_new[0]->amount;?></span><?php } ?>
                <?php if(strtolower($value->name) == "tickets" && $tickets_new[0]->amount != "0"){ ?><span class="badge badge-important badge-new shadow pull-right"><?=$tickets_new[0]->amount;?></span><?php } ?>
               </a> </li>
              <?php } ?>
              </ul>
          </div><!--/.well -->

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
        <p><?=$core_settings->company;?> <small>powered by Freelance Cockpit v.<?=$core_settings->version;?></small></p>
      </footer>
      </div><!--/span-->
      </div><!--/row-->

    </div><!--/.fluid-container-->
    <div id="response_modal" class="modal hide fade"></div>

    <?php if($this->session->flashdata('message')) { $exp = explode(':', $this->session->flashdata('message'))?>
      <div class="notification notification-<?=$exp[0]?>"><div><span><?=$exp[1]?></span></div></div>
    <?php } ?>
 
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/jquery-ui-1.8.16.custom.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/jquery.datatables.min.js"></script>   
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/jquery.validate.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/ckeditor/ckeditor.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/chosen.jquery.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/wysihtml5-0.3.0.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/prettify.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/bootstrap-wysihtml5.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/bootstrap-datepicker.js"></script> 
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/jquery.switch.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/jquery.screwdefaultbuttons.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/blackline/js/custom.js"></script>

      <script type="text/javascript" charset="utf-8">
      $(document).ready(function(){
        $("#menu li a, .submenu li a").removeClass("active");
        if("" == "<?php echo $act_uri_submenu; ?>"){$("#sidebar li a").first().addClass("active");}  
        <?php if($act_uri_submenu != "0"){ ?>$(".submenu li a#<?php echo $act_uri_submenu; ?>").parent().addClass("active");<?php } ?>
        $("#menu li#<?php echo $act_uri; ?>").addClass("active");

      });
      $('.textarea').wysihtml5();
      $(prettyPrint);
      </script>


 </body>
</html>
