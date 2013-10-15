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
<?php $attributes = array('class' => 'form well form-horizontal', 'id' => 'login'); ?>
<?=form_open('login', $attributes)?>
    <div class="control-group">
        <label class="control-label" for="username">Username</label>
        <div class="controls">
            <input class="span3" type="text" id="username" name="username" placeholder="username">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
            <input class="span3" type="password" id="password" name="password" placeholder="password">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-info">Sign in</button>
            <a href="<?=site_url("forgotpass");?>">forgot your password</a>
        </div>
    </div>

<?=form_close()?>