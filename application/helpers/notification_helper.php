<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Notification Helper
 */
function send_notification( $email, $subject, $text ) {
	$instance =& get_instance();
	$instance->load->helper('file');
	$instance->load->library('parser');
	$data["core_settings"] = Setting::first();
    $instance->email->from($data["core_settings"]->email, $data["core_settings"]->company);
			$instance->email->to($email); 
			$instance->email->subject($subject); 
  			//Set parse values
  			$parse_data = array(
            					'company' => $data["core_settings"]->company,
            					'link' => base_url(),
            					'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
            					'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>',
            					'message' => $text
            					);
  			$email_invoice = read_file('./application/views/blackline/templates/email_notification.html');
  			$message = $instance->parser->parse_string($email_invoice, $parse_data);
			$instance->email->message($message);
			$instance->email->send();

}
