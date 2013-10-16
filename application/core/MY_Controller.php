<?php

class My_Controller extends CI_Controller
{

    //VARIABLE FOR USE WITH DATABASE
    var $user = FALSE;
    var $client = FALSE;
    var $core_settings = FALSE;


    protected $theme_view = 'application';

    //content/includes
    protected $content_view = '';

    //data to be passes along url
    protected $view_data  = array();

    function __construct()
    {
        parent::__construct();

        $this->view_data['core_settings'] = Setting::first();
        //checking to set the default language
        //if its not empty, set variable language to cookies setting in browser
        //if not if its been passed along the data variable then set it to view_data[]'s value
        //if not language should be set to english
        if($this->input->cookie('language') != ""){ $language = $this->input->cookie('language');}else{ if(isset($this->view_data['language'])){$language = $this->view_data['language'];}else{$language = "english";}}

       //LANGUAGE SETTINGS
        //load the language settings in the language folder
        //load application(application_lang.php)
        //load messages(messages_lang.php)
        $this->lang->load('application', $language);
        $this->lang->load('messages', $language);

        //CHECKING CLIENT & USER DETAILS
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;
        $this->client = $this->session->userdata('client_id') ? Client::find_by_id($this->session->userdata('client_id')) : FALSE;

        //CHECK WHETHER FOR USER OR CLIENT TO SET LOGIN & PASS MORE INFO TO THE URL LIKE DATE, STICKY
        if($this->client){ $this->theme_view = 'application_client'; }
        $this->view_data['datetime'] = date('Y-m-d H:i', time());
        $this->view_data['sticky'] = Project::all(array('conditions' => 'sticky = 1'));
        $this->view_data['quotations_new'] = Quote::find_by_sql("select count(id) as amount from quotations where status='New'");


        if($this->user || $this->client){
            //SETTING UP USER ACCESS DEPENDING ON USER OR CLIENT
            $access = $this->user ? $this->user->access : $this->client->access;
            $access = explode(",", $access);
            if($this->user){
                //PASS ALONG MODULE TYPE TO BE USED IN DATABASE
                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'main')));
                $this->view_data['widgets'] = Module::find('all', array('conditions' => array('id in (?) AND type = ?', $access, 'widget')));
            }else{
                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'client')));
            }

            //IF USER FIND ID & INSERT LOGIN TIME
            //IF EMAIL BELONGS TO USER SET IT AS USER EMAIL OR CLIENT EMAIL
            if($this->user){
                $update = User::find($this->user->id);
                $this->view_data['user_online'] = User::all(array('conditions' => array('last_active+(30 * 60) > ?', time())));
            }else{
                $update = Client::find($this->client->id);
            }
            $update->last_active = time();
            $update->save();

            //CHECK FOR EMAILS
            $email = $this->user ? $this->user->email : $this->client->email;
            $this->view_data['messages_new'] = Privatemessage::find_by_sql("select count(id) as amount from privatemessages where `status`='New' AND recipient = '".$email."'");
        }


    }
	
	public function _output($output)
	{
		// set the default content view
		if($this->content_view !== FALSE && empty($this->content_view)) $this->content_view = $this->router->class . '/' . $this->router->method;


		//render the content view
        // this renders path to the application slash views slash
        //check file exist if not set yield to false
		$yield = file_exists(APPPATH . 'views/' . $this->view_data['core_settings']->template . '/' . $this->content_view . EXT) ? $this->load->view($this->view_data['core_settings']->template . '/' . $this->content_view, $this->view_data, TRUE) : FALSE;

		//render the theme
        // this renders path to the application slash views slash
        //spit out database core.template value
		if($this->theme_view)
			echo $this->load->view($this->view_data['core_settings']->template . '/' .'theme/' . $this->theme_view, array('yield' => $yield), TRUE);
		else 
			echo $yield;
		
		echo $output;
	}
}
