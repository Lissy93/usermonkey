
<?php


/**
 * Script to send the password reset link
 * @author Alicia Sykes <me@aliciasykes.com>
 */


if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_POST['forgotPassword'])){
    header("Location: "."/login.php");
    die();
}


// Include the database and user classes
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Get the user in name (email or password)
$email = $_POST['forgotPassword'];

//Connect to the database
$db = new Db();
$db->connect();


// Create new user actions  object
$ua = new UserActions();

// Set domain
$ua->setUrl("http://localhost:8080");

// Get URL
$link = $ua->makePasswordResetUrl($email);

//Prepare the message
$to = $email;
$subject = "Password Reset Link";
$message = 'Please follow this link to reset your password: <a href="'.$link.'">RESET PASSWORD LINK</a>';


// Send the message
if(mail($to, $subject, $message)){ $success = true; }
else{$success = false; }

// Prepare message for the user
if($success){
    $_SESSION['information-message']['type'] = "success";
    $_SESSION['information-message']['message'] = "A password reset link has been sent to $email";
}
else {
    $_SESSION['information-message']['type'] = "error";
    $_SESSION['information-message']['message'] = "Error sending email, please contact customer support";
}


// Redirect the user back to their last page, or give them a link to click
//header('Location: /login.php');
echo 'If you are not automatically redirected, please click <a href="/login.php">here</a>';

