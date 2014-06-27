<?php
if(session_id() == '') { session_start(); }

include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

$ua = new UserActions();

$loggedIn = $ua->isLoggedIn();

if($loggedIn){
    $userObj = $ua->makeUserObject();
    if(!$userObj){$loggedIn = false;}
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

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>User Monkey</h1>
        <p>A free to use, quick, complete and secure user system</p>
        <img src="img/UserMonkeyBanner.png" class="main-logo" />
        <h3>Features</h3>
        <ul>
            <li>Register</li>
            <li>Log In</li>
            <li>Forgot Password Option</li>
            <li>Stay Signed in Option</li>
            <li>Profile Pages with Gravatar Images</li>
            <li>User Settings</li>
        </ul>
        <p>
            <a class="btn btn-lg btn-primary" href="https://github.com/Lissy93/usermonkey" role="button">View docs and download from GitHub »</a>
        </p>

    </div>

</div> <!-- /container -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/notification-script.js"></script>
</body></html>