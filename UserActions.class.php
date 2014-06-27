<?php
/**
 * The main class, includes all the user actions
 *
 * PHP version 5
 *
 * @author     Alicia Sykes <me@aliciasykes.com>
 * @version    V1.0
 */


include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php"; // Include the database class for querying

/**
 * Class UserActions
 * The parent class containing methods used by subclasses
 */
class UserActions {

    protected $_dbObj;  // An instance of the Db class included above
    protected $_url;    // The URL of the domain project is hosted on

    public function __construct(){
        $this->_dbObj = new Db();
        $this->_dbObj->connect();
        $this->_url = ""; // NOTE: this must be modified in order to use it
    }

    /**
     * Logs the user out - clears sessions
     */
    public function logOut(){
        $_SESSION['user_id']='';        unset($_SESSION['user_id']);
        $_SESSION['check_user'] = '';   unset($_SESSION['check_user']);
    }


    public function isLoggedIn(){
        if(isset($_SESSION['user_id']) && isset($_SESSION['check_user'])){
            $userId = $_SESSION['user_id'];
            $checkUser = $_SESSION['check_user'];
            if($this->userIdValid($userId)){
                $newUserCheckStr = $this->makeCheckUserStr($userId);
                if($checkUser == $newUserCheckStr){
                    return true;
                }
            }
        }
        return false;
    }

    public function makeUserObject(){
        if($this->isLoggedIn()){
            $userId = $_SESSION['user_id'];
            return $this->makeUserObjectFromId($userId);
        }
        return false;
    }

    public function makeUserObjectFromId($userId){
        if($this->userIdValid($userId)){
            $userQuery = ($this->_dbObj->query("SELECT * FROM users WHERE ID = '$userId'"));
            $userObj = new User();
            $userObj->setUserId($userId);
            $userObj->setUsername($userQuery[0]['username']);
            return $userObj;
        }
        return false;
    }

    public function makePasswordResetUrl($email){
        $email = strtolower($email);
        $q = ($this->_dbObj->query("SELECT ID, salt FROM users WHERE email = '$email'"));
        if(count($q)>0){$id = $q[0]['ID']; }
        else{ $id   = ""; }
        $verificationCode = $this->makePasswordResetCode($id);
        $url = $this->_url."/html/reset-password.php?v=$verificationCode&i=$id";
        return $url;
    }

    public function makePasswordResetCode($userId){
        $db = new Db();
        if(count($db->query("SELECT ID FROM users WHERE ID = '$userId'"))>0){
            $q = ($this->_dbObj->query("SELECT ID, salt FROM users WHERE ID = '$userId'"));
            $salt = $q[0]['salt'];
        } else{$salt = ""; }
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $verificationCode = hash('sha512', $salt.$user_browser);
        return $verificationCode;
    }

    public function setUrl($url){
        $this->_url = $url;
    }



    protected function generateSalt(){
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 32; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function userIdValid($userId){
        if(count($this->_dbObj->query("SELECT * FROM users WHERE ID = '$userId'"))>0){
            return true;
        }
        return false;
    }

    protected function hashPassword($pwd, $salt){
        return hash_hmac('sha512', $pwd.$salt, "4z2nebDDIB");
    }

    protected function makeCheckUserStr($userId){
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if($this->userIdValid($userId)){
            $passwordQuery = ($this->_dbObj->query("SELECT * FROM users WHERE ID = '$userId'"));
            $password = $passwordQuery[0]['password']; }
        else{
            $password = ""; }

        $checkUserString = hash('sha512', $password . $user_browser);
        return $checkUserString;

    }

    protected function checkUsersPassword($userId, $pwd){
        if($this->userIdValid($userId)){
            $saltQuery = ($this->_dbObj->query("SELECT * FROM users WHERE ID = '$userId'"));
            $salt = $saltQuery[0]['salt'];
            $pwd = $this->hashPassword($pwd, $salt);
            if(count($this->_dbObj->query("SELECT * FROM users WHERE ID = '$userId' AND password = '$pwd'"))>0){
                return true;
            }
            return false;
        }
        else{
            return false;
        }

    }

}



class Login extends UserActions{

    public  function start($inName, $inPassword, $staySignedIn=false){

        /* Determine if username or email */
        if(filter_var($inName, FILTER_VALIDATE_EMAIL)){ $loginWith = "email"; }
        else{ $loginWith = "username"; }

        /* Format username/ email before searching for in db */
        $inName = strtolower($inName);
        if($loginWith=="username"){ $inName = preg_replace('/[^\w]+/', '', $inName);}

        /* Database */
        $dbObj = new Db();
        $dbObj->connect();

        /* Find Salt */
        if(count($dbObj->query("SELECT ID FROM users WHERE $loginWith = '$inName' "))>0){
            $saltQuery = ($this->_dbObj->query("SELECT ID, salt FROM users WHERE $loginWith = '$inName'"));
            $salt = $saltQuery[0]['salt'];
        }
        else{
            $salt = "";
        }

        /* Hash Password */
        $inPassword = $this->hashPassword($inPassword, $salt);

        /* Determine if user exists */
        $exists = false;
        $q = $dbObj->query("SELECT ID FROM users WHERE $loginWith = '$inName' AND password='$inPassword'");
        if(count($q)>0){ $exists = true; }

        /* Set the stay signed in cookie */
        if ($exists){

        }

        if($exists){
            $this->setSessions($q[0]['ID']);
            $this->recordLoginAttempt(true,$q[0]['ID']);
            return true;
        }

        if(isset($saltQuery)){$userId = $saltQuery[0]['ID']; }else{$userId = 0;}
        $this->recordLoginAttempt(false,$userId);
        return false;

    }

    protected function setSessions($userId){
        if(session_id() == '') { session_start(); }
        $_SESSION['user_id'] = $userId;
        $_SESSION['check_user'] = $this->makeCheckUserStr($userId);
    }

    protected function recordLoginAttempt($success, $userId){
        /* Get the data */
        $usersIp = $_SERVER['REMOTE_ADDR'];
        $date = new DateTime();
        $timeStamp = $date->getTimestamp();

        /* Database bit */
        $dbObj = new Db();
        $dbObj->connect();

        /* Insert */
        $dbObj->query_insert("INSERT INTO user_logins (user_id, ip, time, success) ".
            "VALUES('$userId','$usersIp','$timeStamp','$success')");
    }


}




class Register extends UserActions{
    private $_message = "";

    private $_username;
    private $_email;
    private $_password;
    private $_salt;
    private $_userType;
    private $_date;

    public function registerUser($username, $email, $password, $userType){
        /* Assign parameters to class members */
        $this->_username = $username;
        $this->_email = $email;
        $this->_password = $password;
        $this->_userType = $userType;

        /* Make data safe*/
        $this->makeDataSafe();

        /* Check all the data is valid*/
        if(!$this->checkData()){ return false;}

        /* Password hash */
        $this->encryptPassword();

        /* Get today's date */
        $today = getdate();
        $this->_date = $today['year'].'-'.$today['mon'].'-'.$today['mday'];

        /* Insert into database */
        $this->insertData();

        /* Log user in */
        $this->logUserIn($password);

        /* Send activation email */
        $verifyObj = new VerifyAccount($_SESSION['user_id']);
        $verifyObj->sendActivationEmail();

        /* Everything went smoothly - return true */
        return true;
    }

    /**
     * Puts all the data into a consistent format
     * Strips illegal special characters
     * Removes trailing space
     */
    private function makeDataSafe(){
        $this->_username = preg_replace('/[^\w]+/', '', $this->_username);
        $this->_username = strtolower($this->_username);
        $this->_email = strtolower($this->_email);
    }

    /**
     * Checks all user registration data is in a valid format
     * If not, sets the class member _message to the error
     * @return bool true if valid, false if invalid
     */
    private function checkData(){
        /* Check the username - length, and taken*/
        $un = $this->_username;
        if(strlen($un)>50){
            $this->_message = "Username is too long - must be under 50 characters";
            return false;
        }
        if(strlen($un)<3){
            $this->_message = "Username is too short - must be 3 or more characters";
            return false;
        }
        if(count($this->_dbObj->query("SELECT * FROM users WHERE username = '$un'"))>0){
            $this->_message = "Username is already taken";
            return false;
        }

        /* Check email address */
        if(!filter_var($this->_email, FILTER_VALIDATE_EMAIL)){
            $this->_message = "Email address does not appear to be valid";
            return false;
        }

        /* Check password */
        if(strlen($this->_password)>65){
            $this->_message = "Password is too long - must be under 250 characters";
            return false;
        }
        if(strlen($this->_password)<6){
            $this->_message = "Password is too short - must be 6 or more characters";
            return false;
        }

        /* Check user type */
        if($this->_userType!="standard"&&($this->_userType!="admin")){
            $this->_message = "User type is invalid";
            return false;
        }

        return true;
    }

    /**
     * Calls the hashPassword method in parent class
     */
    private function encryptPassword(){
        $this->_salt = $this->generateSalt();
        $this->_password = $this->hashPassword($this->_password, $this->_salt);
    }

    /**
     * Inserts the user data into the database
     */
    private function insertData(){
        $un = $this->_username; $pw = $this->_password; $em = $this->_email;
        $ut = $this->_userType; $st = $this->_salt; $dt = $this->_date;
        $this->_dbObj->query_insert("INSERT INTO users (username, password, salt, email, userType, dateCreated) ".
            "VALUES('$un','$pw','$st','$em', '$ut', '$dt')");
    }

    /**
     * Calls log in class
     * @param $password origional
     * @return bool true if logged in else false
     */
    private function logUserIn($password){
        $logInObj = new Login();
        if($logInObj->start($this->_username, $password)){
            return true;
        }
        return false;
    }

    /**
     * @return string the _message error message
     */
    public function getMessage(){
        return $this->_message;
    }
}


class UserSettings extends  UserActions{

    private $_message;

    public function getMessage(){
        return $this->_message;
    }

    public function changePassword($userId, $oldPassword, $newPassword){
        if($this->checkUsersPassword($userId, $oldPassword)){
            if(strlen($newPassword)<6){
                $this->_message = "Password is too short - must be 6 or more characters";
                return false;
            }
            $newSalt = $this->generateSalt();
            $newPassword = $this->hashPassword($newPassword, $newSalt);
            $this->_dbObj->query_insert("UPDATE users SET password='$newPassword', salt='$newSalt' WHERE ID='$userId'");
            $this->logOut();
            return true;
        }
        $this->_message = "Incorrect old password entered";
        return false;
    }

    public function resetPassword($userId, $newPassword){
        if(strlen($newPassword)<6){
            $this->_message = "Password is too short - must be 6 or more characters";
            return false;
        }
        $newSalt = $this->generateSalt();
        $newPassword = $this->hashPassword($newPassword, $newSalt);
        $this->_dbObj->query_insert("UPDATE users SET password='$newPassword' AND salt='$newSalt' WHERE ID='$userId'");
        return true;

    }


    public function changeUsername($userId,$pwd, $newUsername){
        if($this->checkUsersPassword($userId, $pwd)){
            if(strlen($newUsername)>50){
                $this->_message = "Username is too long - must be under 50 characters";
                return false;
            }
            if(strlen($newUsername)<3){
                $this->_message = "Username is too short - must be 3 or more characters";
                return false;
            }
            if(count($this->_dbObj->query("SELECT * FROM users WHERE username = '$newUsername'"))>0){
                $this->_message = "Username is already taken";
                return false;
            }
            $this->_dbObj->query_insert("UPDATE users SET username='$newUsername' WHERE ID='$userId'");
            return true;
        }

    }

    public function changeEmail($userId, $pwd, $newEmail){
        if($this->checkUsersPassword($userId, $pwd)){
            if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
                $this->_message = "Email address does not appear to be valid";
                return false;
            }
            $this->_dbObj->query_insert("UPDATE users SET email='$newEmail' WHERE ID='$userId'");
            return true;
        }
    }

    public function deleteAccount($userId, $pwd){
        if($this->checkUsersPassword($userId, $pwd)){
            $this->_dbObj->query_insert("DELETE FROM users WHERE ID='$userId'");
            $this->logOut();
            return true;
        }
        $this->_message = "Incorrect password entered";
        return false;
    }

    public function addSocialNetwork($service, $url){
        if($this->isLoggedIn()){
            $userId = $_SESSION['user_id'];
            $db = new Db();
            $db->query_insert("INSERT INTO user_socialmedia (user_id, service, url) VALUES ('$userId','$service','$url')");
            return true;
        }
        return false;
    }

    public function getSocialContentFronId($id){
        $db = new Db();
        $q = $db->query("SELECT id, service, url FROM user_socialmedia WHERE id = '$id'");
        if(count($q)>0){ return $q; }
        else{ return null;}
    }


    public function removeSocialMedia($id){
        $this->_dbObj->query_insert("DELETE FROM user_socialmedia WHERE id='$id'");
    }
}


class VerifyAccount extends UserActions {

    private $_userId;
    private $_db;
    private $_code;
    private $_userEmail;

    public function __construct($userId){
        $this->_userId = $userId;
        $this->db = new Db();
        $this->code = $this->getCode();
        $this->_userEmail = $this->getUsersEmailAddress();
    }

    public function isAccountVerified(){
        $uid = $this->_userId;
        $q = $this->db->query("SELECT verified FROM users WHERE ID = '$uid'");
        if(count($q)>0){ if($q[0]['verified']==1){ return true;} }
        return false;
    }

    public function attemptActivate($usersCode){
        if($usersCode==$this->code){
            $this->markAsActivated();
            return true;  }
        else{ return false; }
    }

    public function sendActivationEmail(){
        $to = $this->_userEmail;
        $subject = "Activate your Account";
        $message =  "<h1>Welcome. Just one last step to your account being ready to go</h1>";
        $message .= '<p>Please <a href="'.$this->_url.'/actions/activate-account.php?code='.$this->_code.'">click here</a> to verify your account</p>';
        $message .= "<p>Your activation code is <b>".$this->_code."</b>.";
        $message = wordwrap($message, 70);

        mail($to, $subject, $message);

    }

    private function markAsActivated(){
        $uid = $this->_userId;
        $this->db->query_insert("UPDATE users SET verified=1 WHERE ID = '$uid';");
    }

    private function getCode(){
        $uid = $this->_userId;
        $q = $this->db->query("SELECT salt FROM users WHERE ID = '$uid'");
        if(count($q)>0){ return $q[0]['salt']; }
        else{ return ""; }
    }

    private function getUsersEmailAddress(){
        $uid = $this->_userId;
        $q = $this->db->query("SELECT email FROM users WHERE ID = '$uid'");
        if(count($q)>0){ return $q[0]['email']; }
        else{ return ""; }
    }

}










class User {

    private $_username;
    private $_userId;


    public function setUserId($userId){
        $this->_userId = $userId;
    }


    public function getUserId(){
        return $this->_userId;
    }


    public function setUsername($username){
        $this->_username = $username;
    }


    public function getUsername(){
        return ucfirst($this->_username);
    }

    public function getUserJoinDate(){
        $uid = $this->_userId;
        $db = new Db();
        $q = $db->query("SELECT dateCreated FROM users WHERE ID = '$uid'");
        if(count($q)>0){
            if($q[0]['dateCreated']!='0000-00-00'){
                $mysqldate = $q[0]['dateCreated'];
                $date = $this->make_date(strtotime($mysqldate));
            }
            else{ $date = "unknown"; }
        } else{ $date = "unknown"; }
        return $date;
    }

    public function getLastSeenDate(){
        $uid = $this->_userId;
        $db = new Db();
        $q = $db->query("SELECT time FROM user_logins WHERE user_id = '$uid' AND success = 1 ORDER BY time DESC");
        if(count($q)>0){
            $timestamp = $q[0]['time'];
            $date = $this->make_date($timestamp);
        }else{ $date = "Unknown"; }
        return $date;
    }


    public function getSocialMedia(){
        $uid = $this->_userId;
        $db = new Db();
        $q = $db->query("SELECT id, service, url FROM user_socialmedia WHERE user_id = '$uid'");
        if(count($q)>0){
            return $q; }
        else{ return null; }
    }


    public function getAdditionalInformation(){
        $uid = $this->_userId;
        $db = new Db();
        $q = $db->query("SELECT type, value FROM user_information WHERE user_id = '$uid'");
        if(count($q)>0){
            return $q; }
        else{ return null; }
    }

    public function getEmailAddress(){
        $uid = $this->_userId;
        $db = new Db();
        $q = $db->query("SELECT email FROM users WHERE ID = '$uid'");
        return $q[0]['email'];
    }

    public function getGravatar($s = 200, $d = 'mm', $r = 'g'){
        $email = $this->getEmailAddress();
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        return $url;

    }


    private function make_date($ts){
        $suffix = $this->ordinal_suffix(date('j',$ts));
        $date1 = date('D j',$ts);
        $date2 = date(' F  Y',$ts);
        $date = $date1.$suffix.$date2;
        return $date;
    }

    private function ordinal_suffix($num){
        if($num < 11 || $num > 13){
            switch($num % 10){
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';
            }
        }
        return 'th';
    }



}

