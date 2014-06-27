<?php

/**
 * Script to log the user out
 * @author Alicia Sykes <me@aliciasykes.com>
 */

// Start session and include necissary files
if(session_id() == '') { session_start(); }
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";


// Create user action object and call log out method
$ua = new UserActions();
$ua->logOut();


// Prepare message for the user
$_SESSION['information-message']['type'] = "success";
$_SESSION['information-message']['message'] = "Logged Out";



// Redirect the user back to their last page, or give them a link to click
header('Location: /user-monkey/');
echo 'If you are not automatically redirected, please click <a href="/index.php">here</a>';