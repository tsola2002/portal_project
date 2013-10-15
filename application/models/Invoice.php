<?php
/**
 *
 * Package: dashboard
 * Filename: Invoice.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 16:36
 *
 */

class Invoice extends ActiveRecord\Model {

    //this allows active record link invoice table to companies table AKA(models/Company.php)
    static $belongs_to = array(
        array('company')
    );

    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that invoice table has many invoice_has_items AKA(models/InvoiceHasItem.php)
    //indicates that invoice table has many items AKA(models/Item)
    static $has_many = array(
        array('invoice_has_items'),
        array('items', 'through' => 'invoice_has_items')
    );



}


class InvoiceHasItem extends ActiveRecord\Model {

    //this allows active record link invoice table to invoice_has_items table AKA(models/InvoiceHasItems.php)
    //this allows active record link items table to invoice_has_items table AKA(models/InvoiceHasItems.php)
    static $belongs_to = array(
        array('invoice'),
        array('item')
    );
}


class Item extends ActiveRecord\Model {
    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that items table has many invoice_has_items AKA(models/InvoiceHasItem.php)
    static $has_many = array(
        array('invoice_has_items')
    );
}