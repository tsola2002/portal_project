<?php
/**
 *
 * Package: dashboard
 * Filename: dashboard.php
 * Author: solidstunna101
 * Date: 18/10/13
 * Time: 16:32
 *
 */

class Dashboard extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        //if its the client
        //go to subscription page
        //if not generate menu items
        //if theres a subscriptions link set access to true
        //then redirect to login
        //if not redirect to login
        if($this->client){
            redirect('csubscriptions');
        }elseif($this->user){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "subscriptions"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }else{
            redirect('login');
        }


        //create submenu array to be passed thru to the page

        $this->view_data['submenu'] = array(
            $this->lang->line('application_all') => 'subscriptions',
            $this->lang->line('application_Active') => 'subscriptions/filter/active',
            $this->lang->line('application_Inactive') => 'subscriptions/filter/inactive',
        );

    }



    function index()
    {
        //pass along subscriptions table record to view_url
        //change the pages url to subscription/all
        $this->view_data['subscriptions'] = Subscription::all();
        $this->content_view = 'subscriptions/all';
    }

    //filter function with default value of false
    //if project is active, pass along subscription records with table record of active
    //if project is inactive, pass along subscription records with table record of inactive
    //if project is not either of them, pass along all subscription records
    function filter($condition = FALSE)
    {
        switch ($condition) {
            case 'active':
                $this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ?', 'Active')));
                break;
            case 'inactive':
                $this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ?', 'Inactive')));
                break;
            default:
                $this->view_data['subscriptions'] = Subscription::all();
                break;
        }

        //change the url to subsriptions/all
        $this->content_view = 'subscriptions/all';
    }


    function create()
    {
        //retrieve post value from wysihtml5 form
        //unset values in the post array
        if($_POST){
            unset($_POST['send']);
            unset($_POST['_wysihtml5_mode']);

            //convert issue date to unix_timestamp
            //and convert frequency value to time format
            //set next payment to date format
            //create a subscription database record
            //increment reference value by one
            //access the first record
            //update table field subscription reference
            //if there are no subscription errors display error message
            //redirect to subscriptions page
            $next_payment = human_to_unix($_POST['issue_date'].' 00:00');
            $next_payment = strtotime($_POST['frequency'], $next_payment);
            $_POST['next_payment'] = date("Y-m-d", $next_payment);
            $subscription = Subscription::create($_POST);
            $new_subscription_reference = $_POST['reference']+1;
            $subscription_reference = Setting::first();
            $subscription_reference->update_attributes(array('subscription_reference' => $new_subscription_reference));
            if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_subscription_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_subscription_success'));}
            redirect('subscriptions');
        }else
        {
            //if not find the next record
            //find company records with inactive records
            //change them view to modal
            //display create subscription message
            //change content view to subscriptions/_subscriptions
            $this->view_data['next_reference'] = Subscription::last();
            $this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_subscription');
            $this->view_data['form_action'] = 'subscriptions/create';
            $this->content_view = 'subscriptions/_subscription';
        }
    }

    //retrieve post value from wysihtml5 form
    //unset values in the post array
    //store id value in variable
    //set view to false
    //if view has been set store it in a variable
    //unset the view
    //if status field in form is paid, then set paid date to current time
    //locate the subscription id
    //update the whole record thru the id
    //if its not the subscription display error message
    //if not display a sucess message to show that subscription form has been updated
    function update($id = FALSE, $getview = FALSE)
    {
        if($_POST){
            unset($_POST['send']);
            unset($_POST['_wysihtml5_mode']);
            $id = $_POST['id'];
            $view = FALSE;
            if(isset($_POST['view'])){$view = $_POST['view']; }
            unset($_POST['view']);
            if($_POST['status'] == "Paid"){ $_POST['paid_date'] = date('Y-m-d', time());}
            $subscription = Subscription::find($id);
            $subscription->update_attributes($_POST);
            if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_subscription_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_subscription_success'));}
            if($view == 'true'){redirect('subscriptions/view/'.$id);}else{redirect('subscriptions');}

        }else
        {
            //if theres no post record
            //pass along subscription record to view
            //pass along inactive records of companies table to view
            //if theres a view set get_view to true
            //change theme to modal, title to edit messgae
            //and change for action to subscription message
            $this->view_data['subscription'] = Subscription::find($id);
            $this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
            if($getview == "view"){$this->view_data['view'] = "true";}
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_subscription');
            $this->view_data['form_action'] = 'subscriptions/update';
            $this->content_view = 'subscriptions/_subscription';
        }
    }
    function view($id = FALSE)
        //function view with id set to false
        //submenu data to be passed along array is subscriptions lang line data
        //subscription id frm database to be passed along to to url
        //pass along found items frm subscription has item table in db
        //set variable for enddate field - issue date field to datedifference
        //round it up to a variable called timespan

    {
        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'subscriptions',
        );
        $this->view_data['subscription'] = Subscription::find($id);
        $this->view_data['items'] = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));

        $datediff = strtotime($this->view_data['subscription']->end_date) - strtotime($this->view_data['subscription']->issue_date);
        $timespan = floor($datediff/(60*60*24));
        //switch cases for frequecy field in subscription table based on amount of days
        // for 7days, round timespan/7 p3 =1, t3 =w
        //for 14days round timespan/14 p3 =2, t3 =w
        //for 1month round timespan/30 p3 =1, t3 =m
        //for 3months round timespan/7 p3 =3, t3 =m
        //for 6months round timespan/182 p3 =6, t3 =m
        //for ayear round timespan/365 p3 =1, t3 =y
        switch ($this->view_data['subscription']->frequency) {
            case '+7 day':
                $this->view_data['run_time'] = round($timespan/7);
                $this->view_data['p3'] = "1";
                $this->view_data['t3'] = "W";
                break;
            case '+14 day':
                $this->view_data['run_time'] = round($timespan/14);
                $this->view_data['p3'] = "2";
                $this->view_data['t3'] = "W";
                break;
            case '+1 month':
                $this->view_data['run_time'] = round($timespan/30);
                $this->view_data['p3'] = "1";
                $this->view_data['t3'] = "M";
                break;
            case '+3 month':
                $this->view_data['run_time'] = round($timespan/90);
                $this->view_data['p3'] = "3";
                $this->view_data['t3'] = "M";
                break;
            case '+6 month':
                $this->view_data['run_time'] = round($timespan/182);
                $this->view_data['p3'] = "6";
                $this->view_data['t3'] = "M";
                break;
            case '+1 year':
                $this->view_data['run_time'] = round($timespan/365);
                $this->view_data['p3'] = "1";
                $this->view_data['t3'] = "Y";
                break;
        }
        //chagng view to subscriptions/view
        $this->content_view = 'subscriptions/view';
    }

    function create_invoice($id = FALSE)
    {
        //find subscription by id
        //retrieve last invoices record & set it to a variable
        //set invoice to the last record
        //set invoice_reference to settings tables first record
        $subscription = Subscription::find($id);
        $invoice = Invoice::last();
        $invoice_reference = Setting::first();
        //if subscrption evaluates to true
        //set values from post values frm form subscriptions database table values
        //if subscription value not equals 0, set it to paid
        //set duedate to timeformat equvalent plus date equivalent for next payment date
        if($subscription){
            $_POST['subscription_id'] = $subscription->id;
            $_POST['company_id'] = $subscription->company_id;
            if($subscription->subscribed != 0){$_POST['status'] = "Paid";}else{$_POST['status'] = "Open";}
            $_POST['currency'] = $subscription->currency;
            $_POST['issue_date'] = $subscription->next_payment;
            $_POST['due_date'] = date('Y-m-d', strtotime('+3 day', strtotime ($subscription->next_payment)));
            $_POST['currency'] = $subscription->currency;
            $_POST['terms'] = $subscription->terms;
            $_POST['discount'] = $subscription->discount;
            $_POST['reference'] = $invoice_reference->invoice_reference;
            //create database record with new populated post variables
            //set invoice id variable to last record
            //set items variable to subscription has item which retrieves records based on id
            $invoice = Invoice::create($_POST);
            $invoiceid = Invoice::last();
            $items = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));
            foreach ($items as $value):
                $itemvalues = array(
                    'invoice_id' => $invoiceid->id,
                    'item_id' => $value->item_id,
                    'amount' =>  $value->amount,
                    'description' => $value->description,
                    'value' => $value->value,
                    'name' => $value->name,
                    'type' => $value->type,
                );
                //store invoice fields in array for manipulation
                //store array in invoice has item database
                InvoiceHasItem::create($itemvalues);
            endforeach;
            $invoice_reference->update_attributes(array('invoice_reference' => $invoice_reference->invoice_reference+1));
            if(!$invoice){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_invoice_error'));}
            else{	$subscription->next_payment = date('Y-m-d', strtotime($subscription->frequency, strtotime ($subscription->next_payment)));
                $subscription->save();
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_invoice_success'));}
            redirect('subscriptions/view/'.$id);
        }
    }
    //delete function which takes in id of false
    //find subscription record
    //delete it from database using active record delete function
    //change url to subscriptions/all
    //if no subscriptions, display error message, if not display success message
    //redirect back to subscriptions
    function delete($id = FALSE)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();
        $this->content_view = 'subscriptions/all';
        if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_subscription_error'));}
        else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_subscription_success'));}
        redirect('subscriptions');
    }
    //sendsubscription takes in default id of false
    //load file helper and dompdf custom helper
    //load parser library
    function sendsubscription($id = FALSE){
        $this->load->helper(array('dompdf', 'file'));
        $this->load->library('parser');


        //find subscription record by id,
        //find records frm subscriptionhasitem table by id frm url
        //find first record frm database
        //set from field to settings email field in database
        //set to field to clients email field in database thru its link to subscription
        //set subject to settings table record accounts details
        //set issuedate to settings tables date format field(wich will be converted to unixtimestamp)
        $data["subscription"] = Subscription::find($id);
        $data['items'] = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));
        $data["core_settings"] = Setting::first();
        //email
        $this->email->from($data["core_settings"]->email, $data["core_settings"]->company);
        $this->email->to($data["subscription"]->client->email);
        $this->email->subject($data["core_settings"]->subscription_mail_subject);
        $issue_date = date($data["core_settings"]->date_format, human_to_unix($data["subscription"]->issue_date.' 00:00:00'));

        //store parse_data in array for manipulation
        //this will be(contact, issuedate, subscriptionid, domain, company) all frm database
        //logo will be location of base url & same for invoice logo
        $parse_data = array(
            'client_contact' => $data["subscription"]->client->contact,
            'issue_date' => $issue_date,
            'subscription_id' => $data["subscription"]->reference,
            'client_link' => $data["core_settings"]->domain,
            'company' => $data["core_settings"]->company,
            'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
            'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
        );

        //set message to location of email email subscriptions
        //parse the above variable & store it in that location
        //set email message content
        //if email has been sent, display error message, if not display success message
        //redirect to clients/view/id frm database
        //unlink pdf file from it location
        $email_subscription = read_file('./application/views/blackline/templates/email_subscription.html');
        $message = $this->parser->parse_string($email_subscription, $parse_data);
        $this->email->message($message);
        if($this->email->send()){$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_send_subscription_success'));
            //$data["subscription"]->update_attributes(array('status' => 'Sent', 'sent_date' => date("Y-m-d")));
        }
        else{$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_send_subscription_error'));}
        unlink("files/temp/".$filename.".pdf");
        redirect('subscriptions/view/'.$id);
    }
    function item($id = FALSE)
    {
        //retrieve post values frm form
        //unset send value
        //
        //if name field frm form not empty
        //prepopulate form value, with name, value, type
        //if not find prepopulated form value in database
        //and set it to database value
        if($_POST){
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            if($_POST['name'] != ""){
                $_POST['name'] = $_POST['name'];
                $_POST['value'] = $_POST['value'];
                $_POST['type'] = $_POST['type'];
            }else{
                $itemvalue = Item::find($_POST['item_id']);
                $_POST['name'] = $itemvalue->name;
                $_POST['type'] = $itemvalue->type;
                $_POST['value'] = $itemvalue->value;
            }

            //set created subscriptionhasitem frm forms inputs post array to variable
            //if no item, display error message, if not display success message
            //redirect page to subscriptions/view/form postof subscriptionid
            $item = SubscriptionHasItem::create($_POST);
            if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_add_item_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_add_item_success'));}
            redirect('subscriptions/view/'.$_POST['subscription_id']);

        }else
        {
            //pass along the subscriptionid to url
            //pass along the items table inactive records to url
            //set them to modal
            //set message
            //set form action to subscriptions/_item
            $this->view_data['subscription'] = Subscription::find($id);
            $this->view_data['items'] = Item::find('all',array('conditions' => array('inactive=?','0')));
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_item');
            $this->view_data['form_action'] = 'subscriptions/item';
            $this->content_view = 'subscriptions/_item';
        }
    }
    function item_update($id = FALSE)
    {
        //check post array frm form fields
        //unset send field
        //wrap html elements around pst values using htmlspecialchars
        //find item frm table by id
        //update form items to the database
        //if no item display error message if not , display success message
        if($_POST){
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $item = SubscriptionHasItem::find($_POST['id']);
            $item = $item->update_attributes($_POST);
            if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));}
            redirect('subscriptions/view/'.$_POST['subscription_id']);

        }else
        {
            //if not pass along record frm subscription to the view
            //pass along change view to modal
            //add title
            //pass along for action to subscriptions/item_update
            //pass along content_view as subscriptions/_item
            $this->view_data['subscription_has_items'] = SubscriptionHasItem::find($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_item');
            $this->view_data['form_action'] = 'subscriptions/item_update';
            $this->content_view = 'subscriptions/_item';
        }
    }
    //item delete function with default values set to false
    //retrieve single record through id
    //delete the record
    //set content view url to subscriptions/view
    //if no item display error message not display success message
    //redirect to subscriptions/view/subscription id
    function item_delete($id = FALSE, $subscription_id = FALSE)
    {
        $item = SubscriptionHasItem::find($id);
        $item->delete();
        $this->content_view = 'subscriptions/view';
        if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_item_error'));}
        else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_item_success'));}
        redirect('subscriptions/view/'.$subscription_id);
    }

}