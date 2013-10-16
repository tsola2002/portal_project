<?php
/**
 *
 * Package: dashboard
 * Filename: login.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 16:50
 *
 */
?>

<div class="login">
    <?php $attributes = array('class' => 'form well form-horizontal', 'id' => 'login'); ?>
    <?=form_open('login', $attributes)?>
        <div class="control-group">
            <label class="control-label" for="username"><?=$this->lang->line('application_username');?></label>
            <div class="controls">
                <input class="span3" type="text" id="username" name="username" placeholder="<?=$this->lang->line('application_username');?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password"><?=$this->lang->line('application_password');?></label>
            <div class="controls">
                <input class="span3" type="password" id="password" name="password" placeholder="<?=$this->lang->line('application_password');?>">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-info"><?=$this->lang->line('application_login');?></button>
                <a class="pull-right forgotpass" href="<?=site_url("forgotpass");?>">forgot your password</a>
            </div>
        </div>

    <?=form_close()?>
</div><!--  END OF .LOGIN  -->
