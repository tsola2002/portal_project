<?php
/**
 *
 * Package: dashboard
 * Filename: Company.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 16:03
 *
 */

class Company extends ActiveRecord\Model {

    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that company table has many clients AKA(models/Client.php)
    //indicates that company table has many invoices AKA(models/Invoice.php)
    //indicates that company table has many projects AKA(models/Project.php)
    //indicates that company table has many subscriptions AKA(models/Subscription)
    static $has_many = array(
        array('clients', 'conditions' => 'inactive != 1'),
        array('invoices'),
        array('projects'),
        array('subscriptions')
    );


    //this allows active record link company table to client table AKA(models/Client.php)
    static $belongs_to = array(
        array('client', 'conditions' => 'inactive != 1')
    );

}