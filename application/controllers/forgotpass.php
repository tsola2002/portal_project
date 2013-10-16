<?php
/**
 *
 * Package: dashboard
 * Filename: forgotpass.php
 * Author: solidstunna101
 * Date: 15/10/13
 * Time: 17:48
 *
 */

class Forgotpass extends My_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function index(){

        //load database
        $this->load->database();

        //pass along url error variable of false
        $this->view_data['error'] = 'false';

        //set layout to login
        $this->theme_view = 'login';

        //sets content/includes
        $this->content_view = 'auth/forgotpass';
        $sql = "DELETE FROM pw_reset WHERE `timestamp`+ (24 * 60 * 60) < timestamp";
        //run the query
        $query = $this->db->query($sql);

        //if form field submitted
        if($_POST)
        {
            //set email input to $user variable which will be user serached field frm database
            $user = User::find_by_email($_POST['email']);

            //set variable usertrue to 1
            $usertrue = "1";

            //if field does not match userfound then user is not admin
            //then check details with client database
            if(!$user){$user = Client::find_by_email($_POST['email']); $usertrue = "0";}

            //if it a value frm database
            if($user){
                //$timestamp = current time
                $timestamp = time();

                //encrypt it using md5
                $token = md5($timestamp);

                //load libraries & helpers
                $this->load->library('parser');
                $this->load->helper('file');

                //insert values frm form in db, currenttimestamp, md5 hashedtimestamp(as token), $usertruevalue to indicate(admin or client)
                $sql = "INSERT INTO `pw_reset` (`email`, `timestamp`, `token`, `user`) VALUES ('".$user->email."', '".$timestamp."', '".$token."', '".$usertrue."');";

                //run the query
                $query = $this->db->query($sql);

                //$core settings  = core table in databse
                $data["core_settings"] = Setting::first();

                //email frm field is email field in core table with compnay name
                $this->email->from($data["core_settings"]->email, $data["core_settings"]->company);

                //going to users email field
                $this->email->to($user->email);

                //subject field
                $this->email->subject('Forgot your password');

                //parse data array with following details
                //token url link company name frm database
                //logo image
                //logo link
                $parse_data = array(
                    'link' => base_url().'forgotpass/token/'.$token,
                    'company' => $data["core_settings"]->company,
                    'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
                    'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
                );

                //reads file details
                $email = read_file('./application/views/blackline/templates/email_pw_reset_link.html');

                //convert it to a string
                $message = $this->parser->parse_string($email, $parse_data);
                //$massage string as email contents
                $this->email->message($message);
                //send the email
                $this->email->send();
            }
            //set email confirmation message
            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_password_reset_email'));
            redirect('login');
        }


    }


    function token($token = FALSE){

        //load database
        $this->load->database();

        //select record matching generated token
        $sql = "SELECT * FROM `pw_reset` WHERE token = '".$token."'";

        //run query
        $query = $this->db->query($sql);

        //get single record as result
        $result = $query->result();

        if($result){
            //add a week to curent timestamp
            $lees = $result[0]->timestamp + (24 * 60 * 60);

            //if current time is less than $lees
            if(time() < $lees){
                //generate new password
                $new_password = substr(str_shuffle(strtolower(sha1(rand() . time() . "nekdotlggjaoudlpqwejvlfk"))),0, 8);

                //if is admin
                if($result[0]->user == "1"){
                    //get the record
                    $user = User::find_by_email($result[0]->email);
                    //set new password
                    $user->set_password($new_password);
                    //update the record
                    $user->save();

                }else{
                    //else is client do the equivalent for client
                    $client = Client::find_by_email($result[0]->email);
                    $client->password = $new_password;
                    $client->save();
                }

                //delete email record
                $sql = "DELETE FROM `pw_reset` WHERE `email`='".$result[0]->email."'";
                //run query
                $query = $this->db->query($sql);

                //access core table
                $data["core_settings"] = Setting::first();

                //email frm field is email field in core table with compnay name
                $this->email->from($data["core_settings"]->email, $data["core_settings"]->company);

                //going to currently found email field
                $this->email->to($result[0]->email);

                //load libraries
                $this->load->library('parser');
                $this->load->helper('file');

                //tellin user to reset their password
                $this->email->subject('Reset of your password');

                //parse data array with following details
                //token url link company name frm database
                //logo image
                //logo link
                $parse_data = array(
                    'password' => $new_password,
                    'link' => base_url(),
                    'company' => $data["core_settings"]->company,
                    'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
                    'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
                );

                //reads file details
                $email = read_file('./application/views/blackline/templates/email_pw_reset.html');

                //convert it to a string
                $message = $this->parser->parse_string($email, $parse_data);

                //$massage string as email contents
                $this->email->message($message);

                //send the email
                $this->email->send();

                //set email confirmation message
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_password_reset'));
                redirect('login');
            }

        }else{
            //if all details are wrong send user back to login page
            redirect('login');
        }
    }

}