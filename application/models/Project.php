<?php
/**
 *
 * Package: dashboard
 * Filename: Project.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 13:09
 *
 */

class Project extends ActiveRecord\Model {

    //this allows active record link projects table to companies table AKA(models/Company.php)
    static $belongs_to = array(
        array('company')
    );


    //PLURAL NAMING CONVENTION IS USED FOR HAS MANY ASSOCIATION
    //indicates that projects table has many project_has_tasks AKA(models/ProjectHasTask.php)
    //indicates that projects table has many project_has_files AKA(models/ProjectHasFile.php)
    //indicates that projects table has many projects_has_workers AKA(models/ProjectHasWorker.php)
    //indicates that projects table has many messages AKA(models/Message.php)
    static $has_many = array(
        array("project_has_tasks"),
        array('project_has_files'),
        array('project_has_workers'),
        array('messages')
    );

}