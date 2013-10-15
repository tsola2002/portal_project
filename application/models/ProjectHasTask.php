<?php
/**
 *
 * Package: dashboard
 * Filename: ProjectHasTask.php
 * Author: solidstunna101
 * Date: 14/10/13
 * Time: 16:30
 *
 */

class ProjectHasTask extends ActiveRecord\Model {

    //this line defines the accurate table name in the MYSQL DATABASE
    static $table_name = 'project_has_tasks';

    //this allows active record link project_has_tasks table to users table AKA(models/User.php)
    static $belongs_to = array(
        array('user')
    );

}