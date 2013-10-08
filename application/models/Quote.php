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

    static $table_name = 'quotations';

    static $belongs_to = array(
        array('user')
    );
}