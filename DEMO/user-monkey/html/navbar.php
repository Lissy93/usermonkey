<?php

if(session_id() == '') {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

$ua = new UserActions();

$loggedIn = $ua->isLoggedIn();

if($loggedIn){
    $userObj = $ua->makeUserObject();
    if(!$userObj){$loggedIn = false;}
}

if (isset($_SESSION['information-message'])){$showMessage = true; } else{$showMessage = false; }
if(isset($page_restrictions)){
    if(($page_restrictions=="notloggedin" && $loggedIn)||($page_restrictions=="loggedin"&&!$loggedIn)){
        $showMessage = false;
    }
}
if(isset($verifiedUser)){ if(!$verifiedUser){ $showMessage = false; } }

if($showMessage){
    $message = $_SESSION['information-message']['message'];
    $type    = $_SESSION['information-message']['type'];
    unset($_SESSION['information-message']); }

?>


<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://github.com/Lissy93/usermonkey">
                <img src="/user-monkey/img/NavLogo.png" class="navbar-img"/>User Monkey</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/user-monkey/index.php">Home</a></li>
                <li><a href="https://github.com/Lissy93/usermonkey/archive/master.zip">Download</a></li>
                <li><a href="https://github.com/Lissy93/usermonkey">Documentation</a></li>
                <li><a href="http://aliciasykes.com">Author Page</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if($loggedIn){ ?>
                    <li><p class="navbar-label">Logged in as <?php echo $userObj->getUsername(); ?></p></li>
                    <li><a href="/user-monkey/profile.php">Profile</a></li>
                    <li><a href="/user-monkey/settings.php">Settings</a></li>
                    <li><a href="/user-monkey/actions/log-out.php">Log Out</a></li>
                <?php } else { ?>
                    <li><a href="/user-monkey/login.php">Log In</a></li>
                    <li><a href="/user-monkey/login.php">Sign Up</a></li>
                <?php } ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<?php if($showMessage){ ?>
    <div class="information-message" id="notification-wrapper"><div class="inner <?php echo $type; ?>">
        <p><?php echo $message; ?></p>
    </div></div>
<?php } ?>