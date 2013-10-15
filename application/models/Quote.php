<?php
/**
 *
 * Package: dashboard
 * Filename: Quote.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 13:12
 *
 */

class Quote extends ActiveRecord\Model {

    //this line defines the accurate table name in the MYSQL DATABASE
    static $table_name = 'quotations';

    //this allows active record link the quotations table to users table AKA(models/Quote.php)
    static $belongs_to = array(
        array('user')
    );
}