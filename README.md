# User Monkey


> A complete user system written in PHP

> [Click here](http://code.as93.net/user-monkey/ "Live Demo") to view a live demo.

---------------

## **Please Note: This repository is no longer maintained!** 
I built this back in 2012, (in the days when PHP was cool!). I used it accross most of my small scale PHP applications, and so did a few other people. It did serve it's purpose, and worked fine, but the scene has moved on, and there are now some much better alternatives out there. 

If your looking for a PHP-based user management system, I'd recomend either [UserFrosting](https://github.com/userfrosting/UserFrosting) or [UserSpice](https://userspice.com/). Both are widley used, fully tested, clearly documented and serve their purpose well.


---------------


## Usage



### Getting Started

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
	

### Register New User

	$register = new Register(); 
	$success = $register->registerUser($username,$email,$password,"standard"); 
	

### Log In User

	$logIn = new Login();
	$success = $logIn->start($username, $password);
	
	
### Log Out

	$ua = new UserActions();
	$ua->logOut();
	
	
### Reset Password

	$settings = new UserActions();
	$success = $settings->resetPassword($userId, $password);
	
	
### Change Users Email Address


	$settings = new UserSettings();
	$success = $settings->changeEmail($userId, $password,  $email);

	
### Change Users Password

	$settings = new UserSettings();
	$success = $settings->changeUsername($userId, $password,  $username);
	
	
### Delete Users Account

	$settings = new UserSettings();
	$success = $settings->deleteAccount($userId, $password);
	
	
### Send Activation Email

	$activationObject = new VerifyAccount($userId);
	$activationObject->setUrl("http://example.com");
	$activationObject->sendActivationEmail();
	
	
### Verify Users Account

	$act = new VerifyAccount($userId);
	$success = $act->attemptActivate($code);
	
	
	
	
If $success is false, then the $object->getMessage(); method can be called that will return a short string informing why the action could not be completed. For example:
	
	$register = new Register(); 
	$success = $register->registerUser($username,$email,$password,"standard"); 
	if(!$success){
		echo $register->getMessage();
	}

This will output something like "Unable to create account - username already taken"

-------------------------
	
	
## Screen Shots

There is an optional UI included, it is customisable, but by defualt looks like this:


![Login Screen](https://i.imgur.com/PdE94tb.png "Login Screen")

![Verification Screen](https://i.imgur.com/YYdH6na.png "Verification Screen")

![Account Settings Screen](https://i.imgur.com/cchxJgo.png "iAccount Settings Screen")	

![Profile Screen](https://i.imgur.com/BtNW4Lc.png "Profile Screen")	


