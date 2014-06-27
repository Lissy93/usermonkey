
<?php

/**
 * Script to create a new user
 * @author Alicia Sykes <me@aliciasykes.com>
 */

if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_POST['username'])||
   !isset($_POST['password'])||
   !isset($_POST['confPassword'])||
   !isset($_POST['email'])){
    header("Location: "."/");
    die();
}


// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Set variables from POST parameters
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confPassword = $_POST['confPassword'];


// Register the new user
$register = new Register();
if($register->registerUser($username,$email,$password,"standard")){
      $success = true;  }
else{ $success = false; }


// Prepare message
if($success){
    $_SESSION['information-message']['message'] =  "Welcome $username, your account was created successfully";
    $_SESSION['information-message']['type']    =  "success";
}
else{
    $_SESSION['information-message']['message'] = "Unfortunately there was an error: ".$register->getMessage();
    $_SESSION['information-message']['type']    =  "error"; }


// Get the URL the user came from
if(isset($_SERVER['HTTP_REFERER'])){ $redirectTo = $_SERVER['HTTP_REFERER']; }
else{ $redirectTo = '/'; }


// Redirect the user back to their last page, or give them a link to click
header('Location: '.$redirectTo);
echo 'If you are not automatically redirected, please click <a href="'.$redirectTo.'">here</a>';




