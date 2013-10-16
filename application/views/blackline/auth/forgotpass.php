<?php
/**
 *
 * Package: dashboard
 * Filename: forgotpass.php
 * Author: solidstunna101
 * Date: 15/10/13
 * Time: 17:44
 *
 */
?>

<div class="login">
    <?php $attributes = array('class' => 'form well form-horizontal', 'id' => 'login'); ?>
    <?=form_open('forgotpass', $attributes)?>
    <p><?=$this->lang->line('application_identify_account');?></p>
    <div class="control-group">
        <label class="control-label" for="email"><?=$this->lang->line('application_email');?></label>
        <div class="controls">
            <input class="span3" type="text" id="email" name="email" placeholder="<?=$this->lang->line('application_email');?>">
        </div>
    </div>

    <div class="controls">
        <button type="submit" class="btn btn-info"><?=$this->lang->line('application_reset_password');?></button>
        <a href="<?=site_url("login");?>" class="pull-right forgotpass"><?=$this->lang->line('application_go_to_login');?></a>
    </div>

    <?=form_close()?>
</div><!--  END OF .LOGIN  -->



