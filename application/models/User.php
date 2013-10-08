<?php
/**
 *
 * Package: dashboard
 * Filename: User.php
 * Author: solidstunna101
 * Date: 08/10/13
 * Time: 12:17
 *
 */

class User extends ActiveRecord\Model {



    //declaring member variable
    //to enable us to send the password attribute from database
    var $password = FALSE;

    //if the password has been set in database
    function before_save()
    {

        if($this->password)
            $this->hashed_password = $this->hash_password($this->password);
    }

    //if the password has been set in database
    //then save it into the table
    function set_password($plaintext)
    {
        $this->hashed_password = $this->hash_password($plaintext);
    }

    //takes in password
    //generate a salt & a hash
    private function hash_password($password)
    {
        //encrypt it using mcrypt
        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        //hash catenated version of both the salt & hash combined together
        $hash = hash('sha256', $salt . $password);

        //returns 128bit string
        return $salt . $hash;
    }

    //takes in passed password & make sure its the same password as the one
    //in the database
    private function validate_password($password)
    {
        //retrieve password as database record & get the first 64characters
        $salt = substr($this->hashed_password, 0, 64);

        //retrieve last 64 characters
        $hash = substr($this->hashed_password, 64, 64);

        //hash password for comparison against database password
        $password_hash = hash('sha256', $salt . $password);

        //return a boolean of whether values are the same or not
        return $password_hash == $hash;
    }

    //pulls back user record then validate it
    public static function validate_login($username, $password)
    {
        //use phpactiverecord inbuilt find_by_username()
        //this uses reflection to do it
        $user = User::find_by_username($username);
        $client = Client::find_by_email_and_inactive($username, 0);


        //$password is compared against object found
        if($user && $user->validate_password($password) && $user->status == 'active')
        {
            //log user in
            User::login($user->id, 'user_id');
            //get the id
            $update = User::find($user->id);
            //get the login time
            $update->last_login = time();
            //save the record to the database
            $update->save();
            //return the user object
            return $user;
        }
        elseif($client && $client->password == $password && $client->inactive == '0')
        {
            //if its a client instead login with clients details
            User::login($client->id, 'client_id');
            //get the id
            $update = Client::find($client->id);
            //get the login time
            $update->last_login = time();
            //save the record to the database
            $update->save();
            //return the client object
            return $client;
        } else{
            return FALSE;
        }
    }

    public static function login($user_id, $type)
    {
        $CI =& get_instance();
        $CI->session->set_userdata($type, $user_id);
    }

    public static function logout()
    {
        $CI =& get_instance();
        $CI->session->sess_destroy();

    }
}