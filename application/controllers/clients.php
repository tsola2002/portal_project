<?php
/**
 *
 * Package: dashboard
 * Filename: clients.php
 * Author: solidstunna101
 * Date: 21/10/13
 * Time: 15:01
 *
 */

class Clients extends MY_Controller {

    //if client, redirect to projects page
    //if not, if user instead, load up menu items
    //if user got no access at redirect to login page
    function __construct()
    {
        parent::__construct();

        if($this->client){
            redirect('cprojects');
        }elseif($this->user){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "clients"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }else{
            redirect('login');
        }

    }


    //pass along company inactive records to view
    //set content view url to clients/all
    function index()
    {
        $this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
        $this->content_view = 'clients/all';
    }


    //insert function, if form has been filled in
    //set upload variables using config[] array, which is $path, ecryption, type, width, height
    //pass those details to upload library while loading it

    //if details have been uploaded
    //set data to upload data's variables
    //set userpic field to upload data/filename to which file was uploaded to
    //create error variable, if error message does not match the string
    //set error message to the string
    //then redirect to client page
    function create($company_id = FALSE)
    {
        if($_POST){
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = TRUE;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ( $this->upload->do_upload())
            {
                $data = array('upload_data' => $this->upload->data());

                $_POST['userpic'] = $data['upload_data']['file_name'];
            }else{
                $error = $this->upload->display_errors('', ' ');
                if($error != "You did not select a file to upload. "){
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect('clients');
                }
            }


            //unset send, userfile, and filename fields
            //set access form field to imploded version of the field
            //map out the whole post field
            //set company_id field too variable called company id
            //set client variable to new client
            //if not client, display error message, if not display success message
            //company variable is set to company id field frm database
            //if client id has been set, look at the last record
            //update it to new company id
            //redirect to clients/view page
            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['file-name']);
            $_POST["access"] = implode(",", $_POST["access"]);
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST["company_id"] = $company_id;
            $client = Client::create($_POST);
            if(!$client){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_client_add_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_client_add_success'));
                $company = Company::find($company_id);
                if(!isset($company->client->id)){
                    $client = Client::last();
                    $company->update_attributes(array('client_id' => $client->id));
                }
            }
            redirect('clients/view/'.$company_id);
        }else
        {
            //if not pass along client inactive records
            //as well as module table record using a sort asc based on client
            //as well as the most previous client record as next refernce variable
            //change them vie to modal
            //add title message
            //change form action to clients/create/company variable
            //change content view to clients/clients
            $this->view_data['clients'] = Client::find('all',array('conditions' => array('inactive=?','0')));
            $this->view_data['modules'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('type = ?', 'client')));
            $this->view_data['next_reference'] = Client::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_new_contact');
            $this->view_data['form_action'] = 'clients/create/'.$company_id;
            $this->content_view = 'clients/_clients';
        }
    }

    //update function with default value of false
    function update($id = FALSE, $getview = FALSE)
    {
        if($_POST){
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = TRUE;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ( $this->upload->do_upload())
            {
                $data = array('upload_data' => $this->upload->data());

                $_POST['userpic'] = $data['upload_data']['file_name'];
            }else{
                $error = $this->upload->display_errors('', ' ');
                if($error != "You did not select a file to upload. "){
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect('clients');
                }
            }


            //unset values in the post array(send, userfile, filename)
            //store id value in variable

            //if view has been set store it in a variable
            //unset the view
            //separate post array values by array map
            //if status field in form is paid, then set paid date to current time
            //locate the client id
            //update the whole record thru the id
            //if its not the client display error message
            //if not display a sucess message to show that subscription form has been updated
            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['file-name']);
            $_POST["access"] = implode(",", $_POST["access"]);
            $id = $_POST['id'];
            if(isset($_POST['view'])){
                $view = $_POST['view'];
                unset($_POST['view']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);
            $client = Client::find($id);
            $client->update_attributes($_POST);
            if(!$client){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_client_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_client_success'));}
            redirect('clients/view/'.$client->company->id);

        }else
        {
            //if theres no post record
            //pass along client record to view
            //pass along module table records using sort asc where it is relevant to the client
            //if theres a view set get_view to true
            //change theme to modal, title to edit messages
            //and change form action to clients/update
            //change content view to clients/_clients
            $this->view_data['client'] = Client::find($id);
            $this->view_data['modules'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('type = ?', 'client')));
            if($getview == "view"){$this->view_data['view'] = "true";}
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_client');
            $this->view_data['form_action'] = 'clients/update';
            $this->content_view = 'clients/_clients';
        }
    }

    //company function with default values
    //switch conditions implented based on post values from te form
    //unset the send post field
    //seperate enclose chracters using htmlspecialchars
    //create record in company table based on values frm post array
    //company id equals last record
    //increment companyreference value by one
    //access the first record
    //update table field company reference
    //if there are no subscription errors display error message, if not display succes message
    //redirect to clients/view/company id field frm database
    function company($condition = FALSE, $id = FALSE)
    {
        switch ($condition) {
            case 'create':
                if($_POST){
                    unset($_POST['send']);
                    $_POST = array_map('htmlspecialchars', $_POST);
                    $company = Company::create($_POST);
                    $companyid = Company::last();
                    $new_company_reference = $_POST['reference']+1;
                    $company_reference = Setting::first();
                    $company_reference->update_attributes(array('company_reference' => $new_company_reference));
                    if(!$company){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_company_add_error'));}
                    else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_company_add_success'));}
                    redirect('clients/view/'.$companyid->id);
                }else
                {
                    //if not find the next record
                    //find client records with inactive records
                    //add a title
                    //change them view to modal
                    //display create subscription message
                    //change content view to clients/_company
                    $this->view_data['clients'] = Company::find('all',array('conditions' => array('inactive=?','0')));
                    $this->view_data['next_reference'] = Company::last();
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_add_new_company');
                    $this->view_data['form_action'] = 'clients/company/create';
                    $this->content_view = 'clients/_company';
                }
                break;
            //unset the send post field
            //set id variable to post forms id
            //if view post form value has been set, then set to a variable, then unset it again
            //seperate enclose chracters using htmlspecialchars
            //set variable to record found by id in company table
            //update table field company with post array values frm the form


            //if there are no company errors display error message, if not display succes message
            //redirect to clients/view/company id field frm database
            case 'update':
                if($_POST){
                    unset($_POST['send']);
                    $id = $_POST['id'];
                    if(isset($_POST['view'])){
                        $view = $_POST['view'];
                        unset($_POST['view']);
                    }
                    $_POST = array_map('htmlspecialchars', $_POST);
                    $company = Company::find($id);
                    $company->update_attributes($_POST);
                    if(!$company){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_company_error'));}
                    else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_company_success'));}
                    redirect('clients/view/'.$id);

                }else
                {
                    //pass along the companyid to url
                    //set theme to modal
                    //set title message
                    //set form action to clients/company/update
                    //set content to clients/_company
                    $this->view_data['company'] = Company::find($id);
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_company');
                    $this->view_data['form_action'] = 'clients/company/update';
                    $this->content_view = 'clients/_company';
                }
                break;
            case 'delete':
                $company = Company::find($id);
                $company->inactive = '1';
                $company->save();
                foreach ($company->clients as $value) {
                    $client = Client::find($value->id);
                    $client->inactive = '1';
                    $client->save();
                }
                $this->content_view = 'clients/all';
                if(!$company){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_company_error'));}
                else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_company_success'));}
                redirect('clients');
                break;

        }

    }

    //delete function which takes in default id of false
    //find client record by id
    //set inactive field in database to 1
    //update the changes that have been made
    //change url to clients/all
    //if no clients, display error message, if not display success message
    //redirect back to clients
    function delete($id = FALSE)
    {
        $client = Client::find($id);
        $client->inactive = '1';
        $client->save();
        $this->content_view = 'clients/all';
        if(!$client){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_client_error'));}
        else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_client_success'));}
        redirect('clients');
    }
    function view($id = FALSE)
    {
        //view function ti take default value of false
        //set submenu to clients message defined in lang library
        //pass along company record found by id to url
        //change content view to clients/view
        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'clients',

        );
        $this->view_data['company'] = Company::find($id);
        $this->content_view = 'clients/view';
    }
    function credentials($id = FALSE, $email = FALSE)
    {
        //if email
        //load file helper
        //find client by id, find first record frm Settings table
        //set from field to settings email field in database
        //set to field to clinets email field in database
        //set subject to accounts details
        //load parser library
        if($email){
            $this->load->helper('file');
            $client = Client::find($id);
            $setting = Setting::first();
            $this->email->from($setting->email, $setting->company);
            $this->email->to($client->email);
            $this->email->subject($this->lang->line('application_account_details'));
            $this->load->library('parser');
            //store parse_data in array for manipulation
            //this will be(contact, domain, company, email, password) all frm database
            //logo will be location of base url
            $parse_data = array(
                'client_contact' => $client->contact,
                'client_link' => $setting->domain,
                'company' => $setting->company,
                'username' => $client->email,
                'password' => $client->password,
                'logo' => '<img src="'.base_url().''.$setting->logo.'" alt="'.$setting->company.'"/>',
                'invoice_logo' => '<img src="'.base_url().''.$setting->invoice_logo.'" alt="'.$setting->company.'"/>'
            );

            //set message to location of email credentials
            //parse the above variable & store it in that location
            //set email message content
            //if email has been sent, display error message, if not display success message
            //redirect to clients/view/id frm database
            $message = read_file('./application/views/blackline/templates/email_credentials.html');
            $message = $this->parser->parse_string($message, $parse_data);
            $this->email->message($message);
            if($this->email->send()){$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_send_login_details_success'));}
            else{$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_send_login_details_error'));}
            redirect('clients/view/'.$id);

        } else {
            //pass along client id to url
            //change theme to modal
            //pass along title
            //change for action to clients/credentials
            //change content view to clients/_credentials
            $this->view_data['client'] = Client::find($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_login_details');
            $this->view_data['form_action'] = 'clients/credentials';
            $this->content_view = 'clients/_credentials';
        }
    }

}