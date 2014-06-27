<?php

$page_restrictions = "notloggedin"; // (notloggedin || loggedin || any)

// Start session and include files, if not already done
if(session_id() == '') { session_start(); }
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

$settings = new UserSettings();
$valid = false;
if(isset($_GET['v'])&&isset($_GET['i'])){
    $userId = $_GET['i'];
    $userCode = $_GET['v'];
    if($settings->userIdValid($userId)){
        $correctCode = $settings->makePasswordResetCode($userId);
        if($userCode == $correctCode){
            $valid = true;
        }
    }
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

    <title>Reset your Password</title>

    <!-- Bootstrap -->
    <link href="/user-monkey/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for template -->
    <link href="/user-monkey/css/styles.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/user-monkey/html/navbar.php"); ?>
<?php if ($valid){ ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Password Reset</h1><i class="fa fa-link fa-1x"></i></div>
                <div class="panel-body">
                    <p>Please choose a new password, and fill out the form below</p>
                    <form action="/user-monkey/actions/reset-password.php" method="post" name="password-reset">
                        <input type="password" name="password" placeholder="Password"
                               id="suPassword" class="textbox simple-tb"/><br><br>
                        <input type="password" name="confPassword" placeholder="Confirm Password"
                               id="suConfPassword" class="textbox simple-tb"/><br /><br />
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>" />
                        <button type="submit" class=" simple-tb">Update</button>
                        <p id="#fieldDescription"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php } else {?>

    <p>You don't have permission to view this page</p>
<?php } ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/user-monkey/js/bootstrap.min.js"></script>
<script src="/user-monkey/js/notification-script.js"></script>
<script src="/user-monkey/js/login-script.js"></script>


</body></html>