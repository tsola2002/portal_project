<?php
/**
 *
 * Package: dashboard
 * Filename: ProjectHasFile.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 16:28
 *
 */

class ProjectHasFile extends ActiveRecord\Model {

    //this line defines the accurate table name in the MYSQL DATABASE
    static $table_name = 'project_has_files';

    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that project_has_files table has many messages AKA(models/Message.php)
    static $has_many = array(
        array('messages', 'foreign_key' => 'media_id')
    );


    //this allows active record links project_has_files table to users table AKA(User.php)
    //this allows active record links project_has_files table to clients table AKA(Client.php)
    static $belongs_to = array(
        array('user'),
        array('client')
    );

}