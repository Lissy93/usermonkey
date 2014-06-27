<?php

$page_restrictions = "notloggedin"; // (notloggedin || loggedin || any)

// Start session and include files, if not already done
if(session_id() == '') { session_start(); }
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

$ua = new UserActions();
$loggedIn = $ua->isLoggedIn();
if($loggedIn){
    $userObj = $ua->makeUserObject();
    if(!$userObj){$loggedIn = false;}
}

// This page should only be viewed by users who are NOT logged in
if($loggedIn){
    header('Location: index.php');
}

?>



<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Alicia Sykes">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title>User Monkey</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for template -->
    <link href="css/login-styles.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/user-monkey/html/navbar.php"); ?>

<div class="container">

        <div class="monkeyLogin" id="main">
            <div id="passwordRequired">
                <div class="grid" id="logInGrid">
                    <div class="gridHead" id="logInHead">
                        <h2 id="logInTitle">Log In</h2>
                    </div>
                    <form name="logIn" action="actions/authenticate.php" method="post">
                        <br>
                        <input type="text" name="username" id="username" class="textbox"
                               placeholder="Username or Email" autocomplete="off"/><br><br>
                        <input type="password" name="password" placeholder="Password"
                               id="password" class="textbox"/><br>
                        <p class="small click forgot-lnk" id="userOps">Forgot Password?</p>
                        <input type="checkbox" name="staySignedIn"
                               style="width: 20px; position: absolute; margin: -40px 2px 2px 110px; display: none;" />
                        <br>
                        <button type="submit" class="clicky" id="logInButton">Log In</button>
                    </form>
                </div>
            </div>
            <div id="iForgotMyPassword" style="display: none;">
                <div class="grid" id="resetPasswordGrid">
                    <h2>Reset Password</h2>
                    <form name="forgetPassword" action="actions/send-password-reset.php" method="post">
                        <br><p>
                            Enter your username or email address below, and we will
                            send you a password reset email.
                        </p>
                        <input type="text" name="forgotPassword" id="usernameForget" class="textbox"
                               placeholder="Username or Email" autocomplete="off"/><br>
                        <button type="submit" id="btnResetPass" class="clicky">
                            Send Password Reset
                        </button><br>
                        <p class="small white click" id="iRememberItNow">Remembered Password?</p>
                    </form>
                </div>
            </div>
            <div class="grid" id="signUpGrid">
                <div class="gridHead" id="signUpHead">
                    <h2>Sign Up</h2>
                </div>
                <form name="signUp" action="actions/create-user.php" method="post">
                    <br>
                    <input type="text" name="username" id="suUsername" class="textbox"
                           placeholder="Username" autocomplete="off"/><br><br>
                    <input type="text" name="email" id="suEmail" class="textbox"
                           placeholder="Email" autocomplete="off"/><br><br>
                    <input type="password" name="password" placeholder="Password"
                           id="suPassword" class="textbox"/><br><br>
                    <input type="password" name="confPassword" placeholder="Confirm Password"
                           id="suConfPassword" class="textbox"/><br>
                    <div class="fd-container">
                        <p class="medium" id="fieldDescription"></p>
                    </div>
                    <button type="submit" class="clicky" id="signUpButton">Sign Up</button>
                </form>
            </div>

        </div>


    </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/login-script.js"></script>
<script src="js/notification-script.js"></script>

</body></html>