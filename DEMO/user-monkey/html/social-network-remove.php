<?php

$page_restrictions = "loggedin"; // (notloggedin || loggedin || any)
if(session_id() == '') { session_start(); }
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

$ua = new UserActions();
$loggedIn = $ua->isLoggedIn();
if($loggedIn){
    $userObj = $ua->makeUserObject();
    if(!$userObj){$loggedIn = false;} }
if(!$loggedIn){ header('Location: login.php'); }
if(isset($_GET['id'])){$socialContentId = $_GET['id'];} else{ $socialContentId = 0; }
$settings = new UserSettings();
$account = $settings->getSocialContentFronId($socialContentId);
$settings->removeSocialMedia($socialContentId);
?>



<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Remove Network</title>
    <link href="/user-monkey/css/bootstrap.min.css" rel="stylesheet">
    <link href="/user-monkey/css/styles.css" rel="stylesheet">
    <?php if(isset($_GET['iframe'])){ ?> <style>body{padding-top:0;}</style> <?php } ?>
</head>

<body>
<?php if(!isset($_GET['iframe'])){require($_SERVER['DOCUMENT_ROOT'] . "/user-monkey/html/navbar.php");} ?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Remove Social Network</h2><i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"  style="padding: 15px 20px;">
            <p style="text-align: center; "><img src="/ico/sm_<?php echo $account[0]['service']; ?>.png" width="20" style="border-radius: 3px;"/>
                <?php echo 'Your <b><a href="'.$account[0]['url'].'">'.$account[0]['service'].'</a></b> account has been removed from your profile.'; ?></p>
            <br />
            <a href="/user-monkey/html/social-network-add.php?iframe">
                <div class="p-button">
                    Add a Social Network
                </div>
            </a>
            <a href="/user-monkey/settings.php" target="_parent">
                <div class="p-button">
                    Back to Settings
                </div>
            </a>
            <a href="/user-monkey/index.php" target="_parent">
                <div class="p-button">
                    Return to Homepage
                </div>
            </a>
        </div>
    </div>

</div>

</body></html>