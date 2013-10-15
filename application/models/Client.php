<?php
/**
 *
 * Package: dashboard
 * Filename: Client.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 15:26
 *
 */

class Client extends ActiveRecord\Model {


    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that client table has many posts AKA(models/Project.php)
    //indicates that client table has many posts AKA(models/Invoice.php)
    static $has_many = array(
        array('projects'),
        array('invoices')
    );


    //this allows active record link client table to company table AKA(models/Company.php)
    static $belongs_to = array(
        array('company')
    );

}