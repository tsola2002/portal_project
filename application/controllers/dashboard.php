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

    public function __construct()
    {
        parent::__construct();


    }

    function index(){
        $this->content_view = 'dashboard/dashboard';
    }

}