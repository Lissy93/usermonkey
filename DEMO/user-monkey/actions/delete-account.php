
<?php

/**
 * Script to delete the users account :'(
 * @author Alicia Sykes <me@aliciasykes.com>
 */

if(session_id() == '') { session_start(); }

// Check we've got what we need and the user didn't just land here by mistake
if(!isset($_POST['password'])||
    !isset($_POST['confirm'])||
    !isset($_SESSION['user_id'])){
    $message = $_SESSION['information-message']['message'] = "There was an error with the information you provided";
    $_SESSION['information-message']['type']    =  "error";
}
else{


// Include necessary files
    include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
    include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class


// Set variables from POST parameters
    $userId = $_SESSION['user_id'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    $settings = new UserSettings();
    if($settings->deleteAccount($userId, $password)){$success = true; } else{ $success = false; }


// Prepare message
    if($success){
        $message = $_SESSION['information-message']['message'] =  "Your account has been deleted";
        $_SESSION['information-message']['type']    =  "success";
    }
    else{
        $message = $_SESSION['information-message']['message'] = "Unable to delete account: ".$settings->getMessage();
        $_SESSION['information-message']['type']    =  "error"; }

}
?>



<!DOCTYPE html>
<html lang="en"><head>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Update Username</h2><i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"  style="padding: 15px 20px;">
            <div style="display: block; width: 260px; margin: 0 auto;">
                <p><?php echo $message; ?></p>
            </div>
        </div>
    </div>
</div>

</body></html>