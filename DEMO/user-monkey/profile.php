<?php

$page_restrictions = "loggedin"; // (notloggedin || loggedin || any)

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

// This page should only be viewed by users who are registered and logged in
if(!$loggedIn){ header('Location: login.php'); }

// Check account has been verified
$activationObj = new VerifyAccount($userObj->getUserId());
if(!$activationObj->isAccountVerified()){
    $verifiedUser = false;
    header('Location: html/verify-account.php');
}

$socialmedia = $userObj->getSocialMedia();
?>



<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Alicia Sykes">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?php echo $userObj->getUsername(); ?> | Profile</title>

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
    <div class="row"><h1><?php echo $userObj->getUsername(); ?></h1></div>
    <div class="row">
        <div class="col-sm-3 part">
            <img src="<?php echo $userObj->getGravatar(); ?>" class="profile-picture"/>
            <div class="profile-buttons">
                <div class="p-button">Send Message</div>
            </div>
            <ul class="list-group">
                <li class="list-group-item text-muted">Profile</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span><?php echo $userObj->getUserJoinDate(); ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Last seen</strong></span><?php echo $userObj->getLastSeenDate(); ?></li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-heading">About<i class="fa fa-link fa-1x"></i></div>
                <div class="panel-body">Lorem Ipsum</div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Social Media</div>
                <div class="panel-body">
                    <?php if ($socialmedia!=null){  for($i = 0; $i< count($socialmedia); $i++){ ?>
                        <a href="<?php echo $socialmedia[$i]['url']; ?>">
                            <img src="/ico/sm_<?php echo $socialmedia[$i]['service']?>.png"
                                 alt="<?php echo $socialmedia[$i]['service']; ?>" class="social_icon"
                                 title="<?php echo $userObj->getUsername()." on ".$socialmedia[$i]['service']; ?>"/>
                        </a>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">Activity<i class="fa fa-link fa-1x"></i></div>
                <div class="panel-body">Lorem Ipsum</div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/notification-script.js"></script>

</body></html>