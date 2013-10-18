<?php
/**
 *
 * Package: dashboard
 * Filename: auth.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 11:10
 *
 */

class Auth extends MY_Controller {

    function login()
    {
        //SET ERROR TO FALSE
        $this->view_data['error'] = "false";

        //SET LAYOUT TO LOGIN BECAUSE IT WAS APPLICATION PREVIOUSLY
        $this->theme_view = 'login';


        if($_POST)
        {
            $user = User::validate_login($_POST['username'], $_POST['password']);
            if($user){
                redirect('');
            }
            else {
                //set error variable to be passed along url to true

                $this->view_data['error'] = "true";
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_login_incorrect'));
                $this->view_data['message'] = 'The user/password combination does not match';
            }
        }

    }

    function logout()
    {
        User::logout();
        redirect('login');
    }

}