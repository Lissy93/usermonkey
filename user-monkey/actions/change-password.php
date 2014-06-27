
<?php

/**
 * Script to create a new user
 * @author Alicia Sykes <me@aliciasykes.com>
 */

if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_POST['password'])||
    !isset($_POST['confPassword'])||
    !isset($_SESSION['user_id'])){
   //fail
}


// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Set variables from POST parameters
$userId = $_SESSION['user_id'];
$oldPassword = $_POST['oldPassword'];
$password = $_POST['password'];
$confPassword = $_POST['confPassword'];


$settings = new UserSettings();
if($settings->changePassword($userId, $oldPassword,  $password)){$success = true; } else{ $success = false; }


// Prepare message
if($success){
    $message = $_SESSION['information-message']['message'] =  "Your password has been updated successfully";
    $_SESSION['information-message']['type']    =  "success";
}
else{
    $message = $_SESSION['information-message']['message'] = "Unfortunately there was an error: ".$settings->getMessage();
    $_SESSION['information-message']['type']    =  "error"; }


?>



<!DOCTYPE html>
<html lang="en"><head>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Password Change</h2><i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"  style="padding: 15px 20px;">
            <div style="display: block; width: 260px; margin: 0 auto;">
               <p><?php echo $message; ?></p>
            </div>
        </div>
    </div>
</div>

</body></html>