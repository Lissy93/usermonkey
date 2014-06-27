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

$social = $userObj->getSocialMedia();
$information = $userObj->getAdditionalInformation();
?>



<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Alicia Sykes">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title>Settings</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for template -->
    <link href="css/login-styles.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/fancybox/jquery.fancybox.css" type="text/css" media="screen" />


    <!-- Fancybox helpers -->
    <link rel="stylesheet" href="lib/fancybox/helpers/jquery.fancybox-buttons.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="lib/fancybox/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen" />

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
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Account Settings</h3><i class="fa fa-link fa-1x"></i></div>
                <ul class="list-group">
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong>
                                <a title="Change Password" class="iframlink" href="html/change-password.php?iframe">Change Password</a>
                            </strong>
                        </span>*********
                    </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>
                                <a title="Update Email Address" class="iframlink" href="html/change-email.php?iframe">Update Email Address</a>
                            </strong></span><?php echo $userObj->getEmailAddress(); ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>
                                <a title="Change Username" class="iframlink" href="html/change-username.php?iframe">Change Username</a>
                            </strong></span><?php echo $userObj->getUsername(); ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>
                                <a title="Delete Account" class="iframlink" href="html/delete-account.php?iframe">Delete Account</a>
                            </strong></span>-</li>
                </ul>

            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Social Accounts</h3><i class="fa fa-link fa-1x"></i></div>

                <?php for($i = 0; $i< count($social); $i++){ ?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong>
                                <img src="/user-monkey/ico/sm_<?php echo $social[$i]['service']; ?>.png" class="small-ico"/>
                                <a href="<?php echo $social[$i]['url']; ?>"><?php echo $social[$i]['service']; ?></a>
                            </strong>
                        </span>
                        <a class="iframlink" href="html/social-network-remove.php?iframe&id=<?php echo $social[$i]['id']?>">Remove</a></li>
                <?php } ?>
                <?php if(count($social)==0){ ?>
                <li class="list-group-item"><strong>
                            You haven't yet added any social networks to your profile yet,
                            <a class="iframlink" href="html/social-network-add.php?iframe">click here</a> to get started
                        </strong> </li>
                <?php } ?>
                <li class="list-group-item text-right"><span class="pull-left"><strong>
                            <a class="iframlink" href="html/social-network-add.php?iframe">Add New</a>
                        </strong></span>-</li>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>About You</h3><i class="fa fa-link fa-1x"></i></div>
                <?php for($i=0; $i<count($information);$i++){?>
                    <li class="list-group-item text-right">
                        <span class="pull-left"><strong>
                                <?php echo $information[$i]['type']; ?>
                            </strong>
                        </span>Edit | Remove</li>
                <?php } ?>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Add New</strong></span>-</li>

            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/notification-script.js"></script>
<script type="text/javascript" src="lib/fancybox/jquery.fancybox.js"></script>

<script type="text/javascript" src="lib/fancybox/helpers/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="lib/fancybox/helpers/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="lib/fancybox/helpers/jquery.fancybox-thumbs.js"></script>

<script>
    $(document).ready(function() {


        $("a.iframlink").fancybox({
            'type':'iframe',
            'width':500,
            'centerOnScroll': true,
            afterClose: function () {   parent.location.reload(true);   }
        });





    });
</script>

</body></html>