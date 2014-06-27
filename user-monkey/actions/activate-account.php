
<?php


/**
 * Script to
 * @author Alicia Sykes <me@aliciasykes.com>
 */


if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_GET['code'])||!isset($_SESSION['user_id'])){
    header("Location: "."/login.php");
    die();
}


// Include the database and user classes
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Connect to db
$db = new Db();
$db->connect();


// Get the user ID and the user inputed activation code
$code = $_GET['code'];
$userId = $_SESSION['user_id'];


// Create new verification object
$act = new VerifyAccount($userId);
if($act->attemptActivate($code)){ $success = true; }
else{ $success = false; }

// Prepare message for the user
if($success){
    $_SESSION['information-message']['type'] = "success";
    $_SESSION['information-message']['message'] = "Your account has been activated successfully";
}
else {
    $_SESSION['information-message']['type'] = "error";
    $_SESSION['information-message']['message'] = "Error: Incorrect Activation Code";
}

// Redirect the user back to their last page, or give them a link to click
header('Location: /user-monkey/profile.php');
echo 'If you are not automatically redirected, please click <a href="/user-monkey/profile.php">here</a>';

