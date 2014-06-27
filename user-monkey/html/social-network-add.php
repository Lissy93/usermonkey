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


?>



<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Alicia Sykes">
    <link rel="shortcut icon" href="/user-monkey/img/favicon.ico">

    <title>Add Social Network</title>

    <!-- Bootstrap -->
    <link href="/user-monkey/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for template -->
    <link href="/user-monkey/css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(isset($_GET['iframe'])){ ?> <style>body{padding-top:0;}</style> <?php } ?>
</head>

<body>

<?php
if(!isset($_GET['iframe'])){require($_SERVER['DOCUMENT_ROOT'] . "/user-monkey/html/navbar.php");} ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Add a Social Network to your Profile</h2><i class="fa fa-link fa-1x"></i></div>
                <div class="panel-body"  style="padding: 15px 20px;">
                    <div style="display: block; width: 260px; margin: 0 auto;">
                        <form action="/user-monkey/actions/modify-social-networks.php" method="post">
                            <input type="hidden" name="form-type" value="add" />
                            <select class="simple-tb" name="service">
                                <option value="unknown">--Select--</option>
                                <option value="facebook">Facebook</option>
                                <option value="pinterest">Pinterest</option>
                                <option value="twitter">Twitter</option>
                                <option value="googleplus">Google Plus</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="dribble">Dribble</option>
                                <option value="tumblr">Tumblr</option>
                                <option value="behance">Behance</option>
                                <option value="dropbox">Dropbox Directory</option>
                                <option value="soundcloud">Sound Cloud</option>
                                <option value="picassa">Picassa</option>
                                <option value="flickr">Flickr</option>
                                <option value="devinart">Devinart</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="blogger">Blogger</option>
                                <option value="instagram">Instagram</option>
                                <option value="youtube">YouTube</option>
                                <option value="groveshark">GroveShark</option>
                                <option value="digg">Digg</option>
                                <option value="wordpress">WordPress</option>
                                <option value="zerply">Zerply</option>
                                <option value="github">GitHub</option>
                            </select>
                            <br /><br />
                            <input type="url" name="txtUrl" placeholder="Paste the URL to your profile here"
                                   id="txtUrl" class="simple-tb" required="true"/><br /><br />
                            <button type="submit" class=" simple-tb">Save</button>
                            <p id="#fieldDescription"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/user-monkey/js/bootstrap.min.js"></script>
<script src="/user-monkey/js/notification-script.js"></script>


</body></html>