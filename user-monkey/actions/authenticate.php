
<?php


/**
 * Script to log user in (after checking credentials are correct)
 * @author Alicia Sykes <me@aliciasykes.com>
 */


if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_POST['username'])||!isset($_POST['password'])){
    header("Location: "."/");
    die();
}


// Include the database and user classes
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Get the username and password from form
$username = $_POST['username'];
$password = $_POST['password'];


// Create new log in object and log in
$logIn = new Login();
$success = false;
if($logIn->start($username, $password)){
    $success = true;
}


// Prepare message for the user
if($success){
    $_SESSION['information-message']['type'] = "success";
    $_SESSION['information-message']['message'] = "Successfully logged in as $username ";
}
else {
    $_SESSION['information-message']['type'] = "error";
    $_SESSION['information-message']['message'] = "Unable to log you in, please check your username and password and try again";
}


// Get the URL the user came from
if(isset($_SERVER['HTTP_REFERER'])){ $redirectTo = $_SERVER['HTTP_REFERER']; }
else{ $redirectTo = '/'; }

// Redirect the user back to their last page, or give them a link to click
header('Location: '.$redirectTo);
echo 'If you are not automatically redirected, please click <a href="'.$redirectTo.'">here</a>';

