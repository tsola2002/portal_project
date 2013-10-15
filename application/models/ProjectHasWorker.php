<?php
/**
 *
 * Package: dashboard
 * Filename: ProjectHasWorker.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 20:15
 *
 */

class ProjectHasWorker extends ActiveRecord\Model {
    //this line defines the accurate table name in the MYSQL DATABASE
    static $table_name = 'project_has_workers';

    //this allows active record link the project_has_tasks table to users table AKA(models/User.php)
    static $belongs_to = array(
        array('user')
    );
}