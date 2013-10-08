<?php

/**
 * @author	Luxsys
 * @package FC2
 * @subpackage install
**/

$installFile = "../INSTALL_TRUE";
$DBconfigFile = "../application/config/database.php";
if (is_file($installFile)) { 

function remote_get_contents($url)
{
        if (function_exists('curl_get_contents') AND function_exists('curl_init'))
        {
                return curl_get_contents($url);
        }
        else
        {
                return file_get_contents($url);
        }
}

function curl_get_contents($url)
{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
}



switch($_GET['step']){
	default: ?>
		<ul class="steps">
		<li class="active firstone">System Check</li>
		<li>Purchase Check</li>
		<li>Database</li>
		<li>Basic Settings</li>
		<li class="last">Done!</li>
		</ul>
		<h3>System Check</h3>
		<?php 
			$error = FALSE;
			if(phpversion() < "5.3"){$error = TRUE; echo "<div class='alert alert-error'>Your PHP version is ".phpversion()."! PHP 5.3 or higher required!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> You are running PHP ".phpversion()."</div>";} 
			if(!extension_loaded('mcrypt')){$error = TRUE; echo "<div class='alert alert-error'>Mcrypt PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> Mcrypt PHP exention loaded!</div>";}
			if(!extension_loaded('mysql')){$error = TRUE; echo "<div class='alert alert-error'>Mysql PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> Mysql PHP exention loaded!</div>";}
			if(!extension_loaded('mbstring')){$error = TRUE; echo "<div class='alert alert-error'>MBString PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> MBString PHP exention loaded!</div>";}
			if(!extension_loaded('gd')){echo "<div class='alert alert-error'>GD PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> GD PHP exention loaded!</div>";}
			if(!extension_loaded('pdo')){$error = TRUE; echo "<div class='alert alert-error'>PDO PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> PDO PHP exention loaded!</div>";}
			if(!extension_loaded('dom')){echo "<div class='alert alert-error'>DOM PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> DOM PHP exention loaded!</div>";}
			if(!extension_loaded('curl')){$error = TRUE; echo "<div class='alert alert-error'>CURL PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> CURL PHP exention loaded!</div>";}
			if(!is_writeable($DBconfigFile)){$error = TRUE; echo "<div class='alert alert-error'>Database File (application/config/database.php) is not writeable!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> Database file is writeable!</div>";}
			if(!is_writeable("../files")){echo "<div class='alert alert-error'><img src='../assets/img/error.png' /> /files folder is not writeable!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> /files folder is writeable!</div>";}
			if(ini_get('allow_url_fopen') != "1"){echo "<div class='alert alert-warning'><img src='../assets/img/warning.png' /> Allow_url_fopen is not enabled!</div>";}else{echo "<div class='alert alert-success'><img src='../assets/blackline/img/success.png' /> Allow_url_fopen is enabled!</div>";}
?>      
		<div class="bottom">
			<?php if($error){ ?>
			<a href="#" class="btn btn-primary disabled">Next Step</a>
			<?php }else{ ?>
			<a href="?step=0" class="btn btn-primary">Next Step</a>
			<?php } ?>
		</div>

<?php
	break;
	case "0": ?>
	<ul class="steps">
		<li class="firstone"><i class="icon icon-ok"></i> System Check</li>
		<li class="active">Purchase Check</li>
		<li>Database</li>
		<li>Basic Settings</li>
		<li class="last">Done!</li>
		</ul>
	<h3>Purchase Code Check</h3>
	<?php
		if($_POST){
			$code = $_POST["code"];
			$object = remote_get_contents('http://fc2.luxsys-apps.com/check/xml.php?code='.$code);
			$object = json_decode($object);
		if ($object->error != TRUE) {
		    ?>
		    <div class="alert alert-error"><img src='../assets/blackline/img/error.png' /> <?php echo $object->error; ?></div>
		    <form action="?step=0" method="POST">
		<p>
		        <label for="code">Item Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="fam-information"></i></a></label>
		        <input id="code" type="text" name="code" />
		</p>
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Check"/>
		</div>
		</form>

		    <?php
		}else{ ?>
			<form action="?step=1" method="POST">
		<p>
		<div class="alert alert-success"><img src='../assets/blackline/img/success.png' /> Your purchase code is valid!</div>   
		</p><input id="code" type="hidden" name="code" value="<?php echo $code; ?>" />
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Next Step"/>
		</div>
		</form><?php
		}
		}else{	?>
	<p>Please enter your item purchase code of Freelance Cockpit 2</p><br>
		<form action="?step=0" method="POST">
		<p>
		        <label for="code">Item Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="fam-information"></i></a></label>
		        <input id="code" type="text" name="code" />
		</p>
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Check"/>
		</div>
		</form>
	<?php }
	break;
	case "1": ?>
	<ul class="steps">
		<li class="firstone"><i class="icon icon-ok"></i> System Check</li>
		<li><i class="icon icon-ok"></i> Purchase Check</li>
		<li class="active">Database</li>
		<li>Basic Settings</li>
		<li class="last">Done!</li>
		</ul>
	<?php if($_POST){ ?>
	<h3>Database Config</h3>
	<p>If the database does not exist the system will try to create it.</p>
		<form action="?step=2" method="POST">
		<p>
		        <label for="host">Host *</label>
		        <input id="host" type="text" name="host" class="required span5" value="localhost" />
		</p>
		<p>
		        <label for="username">Username *</label>
		        <input id="username" type="text" name="username" class="required" />
		</p>
		<p>
		        <label for="password">Password *</label>
		        <input id="password" type="password" name="password" />
		</p>
		<p>
		        <label for="dbname">Database Name *</label>
		        <input id="dbname" type="text" name="dbname" value="FC2" />
		</p>
		<input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
		<div class="bottom">
			<input type="submit" class="btn btn-blue" value="Next Step"/>
		</div>
		</form>
	<?php }
	break;
	case "2":
	?>
	<ul class="steps">
		<li class="firstone"><i class="icon icon-ok"></i> System Check</li>
		<li><i class="icon icon-ok"></i> Purchase Check</li>
		<li class="active">Database</li>
		<li>Basic Settings</li>
		<li class="last">Done!</li>
		</ul>
	<h3>Saving database config</h3>
	<?php
		if($_POST){
			$host = $_POST["host"];
			$username = $_POST["username"];
			$password = $_POST["password"];
			$dbname = $_POST["dbname"];
			$code = $_POST["code"];
			$link = @mysql_connect($host, $username, $password);
		if (!$link) {
		    echo "<div class='alert alert-error'>Could not connect to MYSQL!</div>";
		}else{
			echo '<div class="alert alert-success">Connection to MYSQL successful!</div>';
			
			$db_selected = @mysql_select_db($dbname, $link);
			if (!$db_selected) {
				if(!mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` /*!40100 CHARACTER SET utf8 COLLATE 'utf8_general_ci' */")){
					echo "<div class='alert alert-error'>Database ".$dbname." does not exist and could not be created. Please create the Database manually and retry this step.</div>";
					$res = mysql_query("SHOW DATABASES");
					echo "The following databases are available:<br>";
					while ($row = mysql_fetch_assoc($res)) {
						    echo $row['Database'] . "<br>";
						}
					return FALSE;
				}else{ echo "<div class='alert alert-success'>Database ".$dbname." created</div>";}
			}
				mysql_select_db($dbname);
				define("BASEPATH", "install/");
		
		function write_dbconfig($host, $username, $password,$dbname, $DBconfigFile){

			$newcontent = '<?php  if ( !defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
							/*
							| -------------------------------------------------------------------
							| DATABASE CONNECTIVITY SETTINGS
							| -------------------------------------------------------------------
							| This file will contain the settings needed to access your database.
							|
							| For complete instructions please consult the \'Database Connection\'
							| page of the User Guide.
							|
							*/

							$active_group = \'default\';
							$active_record = TRUE;

							$db[\'default\'][\'hostname\'] = \''.$host.'\';
							$db[\'default\'][\'username\'] = \''.$username.'\';
							$db[\'default\'][\'password\'] = \''.$password.'\';
							$db[\'default\'][\'database\'] = \''.$dbname.'\';
							$db[\'default\'][\'dbdriver\'] = \'mysql\';
							$db[\'default\'][\'dbprefix\'] = \'\';
							$db[\'default\'][\'pconnect\'] = TRUE;
							$db[\'default\'][\'db_debug\'] = TRUE;
							$db[\'default\'][\'cache_on\'] = FALSE;
							$db[\'default\'][\'cachedir\'] = \'\';
							$db[\'default\'][\'char_set\'] = \'utf8\';
							$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
							$db[\'default\'][\'swap_pre\'] = \'\';
							$db[\'default\'][\'autoinit\'] = TRUE;
							$db[\'default\'][\'stricton\'] = FALSE;


							/* End of file database.php */
							/* Location: ./application/config/database.php */
							';


			$file_contents = file_get_contents($DBconfigFile);
			$fh = fopen($DBconfigFile, "w");
			$file_contents = $newcontent;
			if(fwrite($fh, $file_contents)){
				return true;
			}
			fclose($fh);

		}
		if(!write_dbconfig($host,$username,$password,$dbname,$DBconfigFile)){
				echo "<div class='alert alert-error'>Failed to write config to ".$DBconfigFile."</div>";
		}else{ echo "<div class='alert alert-success'>Database config written to the database file.</div>"; }
		}
		}else{echo "<div class='alert alert-success'>Nothing to do...</div>";}
		?>
		<div class="bottom">
			<form action="?step=1" method="POST">
		    <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
			<input type="submit" class="btn pull-left" value="Previous Step"/>
			</form>
			<form action="?step=3" method="POST">
		    <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
			<input type="submit" class="btn btn-primary pull-right" value="Next Step">
			</form>
			<br clear="all">
		</div>
		<?php
	break;
	case "3":
	?>
		<ul class="steps">
		<li class="firstone"><i class="icon icon-ok"></i> System Check</li>
		<li><i class="icon icon-ok"></i> Purchase Check</li>
		<li><i class="icon icon-ok"></i> Database</li>
		<li class="active">Basic Settings</li>
		<li class="last">Done!</li>
		</ul>
		<?php if($_POST){ ?>
		<form id="step3" action="?step=4" method="POST">
		<p>
		        <label for="company">Company Name *</label>
		        <input type="text" name="company" class="required" value="">
		</p>
		<p>
		        <label for="invoice_address">Contact Name *</label>
		        <input type="text" name="invoice_contact" class="required" value="" />
		</p>
		<p>
		        <label for="invoice_address">Address *</label>
		        <input type="text" name="invoice_address" class="required" value="" />
		</p>
		<p>
		        <label for="invoice_city">City *</label>
		        <input type="text" name="invoice_city" class="required" value="" />
		</p>
		<p>
		        <label for="invoice_tel">Phone</label>
		        <input type="text" name="invoice_tel" value="" />
		</p>
		<p>
		        <label for="domain">Domain *</label>
		        <input type="text" name="domain" class="required" value="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -15); ?>" />
		</p>
		<p>
		        <label for="email">Email *</label>
		        <input type="text" name="email" class="required email" value="" />
		</p>
		<p>
		        <label for="tax">Tax (%)</label>
		        <input type="text" name="tax" class="number" value="" />
		</p>
		<p>
		        <label for="currency">Default Currency</label>
		        <input type="text" name="currency" value="$" />
		</p>
		<p>
		        <label for="invoice_reference">Invoice Reference *</label>
		        <input type="text" name="invoice_reference" class="required number" value="31001" />
		</p>
		<p>
		        <label for="company_reference">Company Reference *</label>
		        <input type="text" name="company_reference" class="required number" value="41001" />
		</p>
		<p>
		        <label for="project_reference">Project Reference *</label> 
		        <input type="text" name="project_reference" class="required number" value="51001" />
		</p>
		<p>
		        <label for="subscription_reference">Subscription Reference *</label> 
		        <input type="text" name="subscription_reference" class="required number" value="61001" />
		</p>
		<input type="hidden" name="pc" value="<?php echo $_POST['code']; ?>" />
		<div class="bottom">
			<a href="?step=2" class="btn pull-left">Previous Step</a>
			<input type="submit" class="btn btn-primary" value="Next Step"/>
		</div>
		</form>
		<?php } ?>


	<?php
	break;
	case "4": ?>
		<ul class="steps">
		<li class="firstone"><i class="icon icon-ok"></i> System Check</li>
		<li><i class="icon icon-ok"></i> Purchase Check</li>
		<li><i class="icon icon-ok"></i> Database</li>
		<li><i class="icon icon-ok"></i> Basic Settings</li>
		<li  class="active">Done!</li>
	</ul>

	<?php if($_POST){
		$domain = $_POST['domain'];
		$email = $_POST['email'];
		$company = $_POST['company'];
		if(!empty($tax)){$tax = $_POST['tax'];}else{$tax = "0";} 
		$currency = $_POST['currency']; 
		$company_reference = $_POST['company_reference']; 
		$project_reference = $_POST['project_reference']; 
		$invoice_reference = $_POST['invoice_reference'];
		$subscription_reference = $_POST['subscription_reference'];
		$invoice_address = $_POST['invoice_address'];
		$invoice_city = $_POST['invoice_city'];
		$invoice_contact = $_POST['invoice_contact'];
		$invoice_tel = $_POST['invoice_tel'];
		$pc = $_POST['pc'];
		define("BASEPATH", "install/");
		include("../application/config/database.php");
		mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
		mysql_select_db($db['default']['database']);

			$object = remote_get_contents('http://fc2.luxsys-apps.com/check/xml.php?code='.$pc);
			$object = json_decode($object);
		if ($object->error != TRUE) {
			echo "<div class='alert alert-error'>Error while validating your purchase code!</div>";
		}else{
			foreach ($object->database as $key => $value) {
				mysql_query($value) or die(mysql_error());
			}
		}

$insert = mysql_query("INSERT INTO core (`id`, `version`, `domain`, `email`, `company`, `tax`, `currency`, `autobackup`, 
`cronjob`, `last_cronjob`, `last_autobackup`, `invoice_terms`, `company_reference`, `project_reference`, 
`invoice_reference`, `subscription_reference`, `ticket_reference`, `date_format`, `date_time_format`, `invoice_mail_subject`, 
`pw_reset_mail_subject`, `pw_reset_link_mail_subject`, `credentials_mail_subject`, `notification_mail_subject`, 
`language`, `invoice_address`, `invoice_city`, `invoice_contact`, `invoice_tel`, `subscription_mail_subject`, `logo`, 
`template`, `paypal`, `paypal_currency`, `paypal_account`, `invoice_logo`, `pc`) 
VALUES (1, '2.0.0', '$domain', '$email', '$company', '$tax', '$currency', '1', '1', '', '', 
'Thank you for your business. We do expect payment within {due_date}, so please process this invoice within that time.', 
'$company_reference', '$project_reference', '$invoice_reference', '$subscription_reference', '10000', 
'Y/m/d', 'g:i A', 'New Invoice', 'Password Reset', 'Password Reset', 'Login Details', 'Notification', 'english', 
'$invoice_address', '$invoice_city', '$invoice_contact', '$invoice_tel', 'New Subscription', 'assets/blackline/img/logo.png', 'blackline', '0', 'USD', 
'', 'assets/blackline/img/invoice_logo.png', '$pc');");

$check_user = mysql_query("SELECT count(*) as val from users where username = 'Admin'");
$check_user = @mysql_fetch_assoc($check_user);
if($check_user['val'] == 0){
mysql_query("INSERT INTO `users` (`username`, `firstname`, `lastname`, `hashed_password`, `email`, `status`, `admin`, `created`, `userpic`, `title`, `access`, `last_active`, `last_login`) VALUES ('Admin', 'John', 'Doe', '785ea3511702420413df674029fe58d69692b3a0a571c0ba30177c7808db69ea22a8596b1cc5777403d4374dafaa708445a9926d6ead9a262e37cb0d78db1fe5', 'local@localhost', 'active', '1', '2013-01-01 00:00:00', 'no-pic.png', 'Administrator', '1,2,3,4,5,8,6,7,9,10,11', '', '')");

}else{
  mysql_query("UPDATE users SET `hashed_password` = '785ea3511702420413df674029fe58d69692b3a0a571c0ba30177c7808db69ea22a8596b1cc5777403d4374dafaa708445a9926d6ead9a262e37cb0d78db1fe5' WHERE username = 'Admin'");
}
			if(!$insert){echo "<div class='alert alert-error'>Error while saving settings to database!</div>";}else{
				echo "<h3>Installation successful!</h3>";
				if(!@unlink('../INSTALL_TRUE')){
					echo "<div class='alert alert-warning'>Please remove the INSTALL_TRUE file from the main folder in order to disable the installation tool!</div>";
					}
				
	$subfolder = substr($_SERVER["REQUEST_URI"], 0, -15);
	$subfoldercheck = substr($_SERVER["REQUEST_URI"], 0, -16);
	if(!empty($subfoldercheck)){
					
$input = 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteBase '.$subfolder.'
RewriteRule ^(.*)$ index.php/$1 [L]';
$current = @file_put_contents('../.htaccess', $input);
	}
				} 
			} ?>
			<br>
			<div class="alert alert-info">You can login using the following credentials: <br>Username: <b>Admin</b> <br>Password: </b>password</b></div>
			<div class="alert alert-warning">Important! Change your password after login.</div>
					<div class="bottom">
					<a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -15); ?>" class="btn btn-blue">Go to Login</a>
				</div>
			
	<?php	
	}

}else{
			echo "<div class='alert alert-error'>Installation tool not active! Just create a file named \"INSTALL_TRUE\" within the main folder.</div>";
		}
?>

 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">How to find your purchase code</h3>
  </div>
  <div class="modal-body">
    <p><img src="purchaseCode.png"></p>
  </div>
</div>