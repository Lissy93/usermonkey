
<?php


/**
 * Script to resend the activation email
 * @author Alicia Sykes <me@aliciasykes.com>
 */


if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_SESSION['user_id'])){
    header("Location: "."/login.php");
    die();
}


// Include the database and user classes
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Get the user ID
$userId = $_SESSION['user_id'];

//Connect to the database
$db = new Db();
$db->connect();


// Create new verifying object
$activationObject = new VerifyAccount($userId);

// Set domain
$activationObject->setUrl("http://localhost:8080");

// Resend email
$activationObject->sendActivationEmail();

$success = true;


// Prepare message for the user
if($success){
    $_SESSION['information-message']['type'] = "success";
    $_SESSION['information-message']['message'] = "Activation email has been resent";
}
else {
    $_SESSION['information-message']['type'] = "error";
    $_SESSION['information-message']['message'] = "Unable to send email, check that your logged in, and your email is correct, then contact customer support";
}


// Redirect the user back to their last page, or give them a link to click
//header('Location: /html/verify-account.php');
echo 'If you are not automatically redirected, please click <a href="/html/verify-account.php">here</a>';

