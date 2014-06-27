User Monkey
==========

###A complete user system written in PHP

Getting Started
---------------

	/* First start a session, if not already started */
	if(session_id() == '') { session_start(); } 

	/* Next include the PHP classes (see demo folder for Db class)*/
	include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class
	include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class

	/* Connect to the database */
	$db = new Db();
	$db->connect();

	/* Create an instance of the UserActions class */
	$ua = new UserActions();
	

Register New User
-----------------
	$register = new Register(); 
	$success = $register->registerUser($username,$email,$password,"standard"); 
	

Log In User
-----------
	$logIn = new Login();
	$success = $logIn->start($username, $password);
	
	
Log Out
-------
	$ua = new UserActions();
	$ua->logOut();
	
	
Reset Password
--------------
	$settings = new UserActions();
	$success = $settings->resetPassword($userId, $password);
	
	
Change Users Email Address
--------------------------
	$settings = new UserSettings();
	$success = $settings->changeEmail($userId, $password,  $email);

	
Change Users Password
---------------------
	$settings = new UserSettings();
	$success = $settings->changeUsername($userId, $password,  $username);
	
	
Delete Users Account
--------------------
	$settings = new UserSettings();
	$success = $settings->deleteAccount($userId, $password);
	
	
Send Activation Email
---------------------
	$activationObject = new VerifyAccount($userId);
	$activationObject->setUrl("http://example.com");
	$activationObject->sendActivationEmail();
	
	
Verify Users Account
--------------------
	$act = new VerifyAccount($userId);
	$success = $act->attemptActivate($code);
	
	
	
	
If $success is false, then the $object->getMessage(); method can be called that will return a short string informing why the action could not be completed.
For example:
	$register = new Register(); 
	$success = $register->registerUser($username,$email,$password,"standard"); 
	if(!$success){
		echo $register->getMessage();
	}

This will output something like "Unable to create account - username already taken"
	
	
	
	