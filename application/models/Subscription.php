<?php
/**
 *
 * Package: dashboard
 * Filename: Subscription.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 16:31
 *
 */

class Subscription extends ActiveRecord\Model{

    //this allows active record link the subscriptions table to company table AKA(models/Company.php)
    static $belongs_to = array(
        array('company')
    );

    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that subscriptions table has many subscription_has_items AKA(models/Subscription_Has_Item.php)
    //indicates that subscriptions table has many invoices AKA(models/Invoice.php)
    static $has_many = array(
        array('subscription_has_items'),
        array('invoices')
    );


}