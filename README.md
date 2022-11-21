<h1 align="center">🍌 User Monkey</h1>
<p align="center">
  <i>A complete user-management system for PHP apps</i><br>
  <img src="https://github.com/Lissy93/usermonkey/raw/master/DEMO/user-monkey/img/NavLogo.png" />
</p>

> **Warning** This repository is no longer maintained! <br>
> For more info, see [Project Update](#project-update) and [Alternatives](#alternatives) ↓

<details>
<summary><b>Contents</b></summary>

- [Intro](#about)
  - [Features](#features)
  - [Demo](#demo)
  - [Project Update](#project-update)
  - [Alternatives](#alternatives)
- [Usage Guide](#getting-started)
  - [User Registration](#register-new-user)
  - [Authentication](#log-in-user)
  - [Logging Out](#log-out)
  - [Resetting Password](#reset-password)
  - [Updating Email Address](#change-users-email-address)
  - [Updating Password](#change-users-password)
  - [Deleting Account](#delete-users-account)
  - [Sending Activation Email](#send-activation-email)
  - [Account Verification](#verify-users-account)
- [Screenshots](#frontend)
- [Contributing](#contributing)
- [License](#license)

</details>

## About

User Monkey is a plug-and-play complete user-management system written in PHP and bundled into a single file. It enables you to easily add support for features where user sign up is required, such as posts/ comments, paywalled content, saving preferences, spam reduction, etc. All the commonly required features are included as standard and there's also an optional UI.

#### Features

- Registration
- Log in / Log out
- Account Deletion
- Password Resets
- Account Verification
- Editing Account Info
- Link Social Media Accounts
- Gravatar Picture Support

There's also an optional UI, which includes the screens for all the above opperations (registration, authentication, profile page, account settings, etc)

#### Demo
~A live demo of the running project can be viewed at: [code.as93.net/user-monkey](https://web.archive.org/web/20150809214155/http://code.as93.net/user-monkey/)~ (demo no longer available)

#### Project Update
This app was developed in 2010-12, and used across several of my apps, and other peoples projects for almost 10 years after. It served it's purpose as a simple single-file user-management system, but times have moved on, and there are now some much better alternatives out there. I strongly recommend against using this project in any production application.

#### Alternatives
If your looking for a PHP-based user management system, I'd recomend either [UserFrosting](https://github.com/userfrosting/UserFrosting) or [UserSpice](https://userspice.com/). Both are widley used, fully tested, clearly documented and serve their purpose well.

---

## Usage

### Getting Started

```php
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
```
	

### Register New User

```php
$register = new Register(); 
$success = $register->registerUser($username,$email,$password,"standard"); 
```

### Log In User

```php
$logIn = new Login();
$success = $logIn->start($username, $password);
```
	
### Log Out
```php
$ua = new UserActions();
$ua->logOut();
```	
	
### Reset Password
```php
$settings = new UserActions();
$success = $settings->resetPassword($userId, $password);
```
	
### Change Users Email Address
```php
$settings = new UserSettings();
$success = $settings->changeEmail($userId, $password,  $email);
```
	
### Change Users Password
```php
$settings = new UserSettings();
$success = $settings->changeUsername($userId, $password,  $username);
```	
	
### Delete Users Account
```php
$settings = new UserSettings();
$success = $settings->deleteAccount($userId, $password);
```
	
### Send Activation Email
```php
$activationObject = new VerifyAccount($userId);
$activationObject->setUrl("http://example.com");
$activationObject->sendActivationEmail();
```	
	
### Verify Users Account
```php
$act = new VerifyAccount($userId);
$success = $act->attemptActivate($code);
```

If `$success` is false, then the `$object->getMessage();` method can be called that will return a short string informing why the action could not be completed (e.g. _"Unable to create account - username already taken"_). For example:

```php	
$register = new Register(); 
$success = $register->registerUser($username,$email,$password,"standard"); 
if(!$success){
  echo $register->getMessage();
}
```

---	
	
## Frontend

There is an optional UI included (see [source](https://github.com/Lissy93/usermonkey/tree/master/DEMO/user-monkey)). It's themable, but here's some screenshots of it running...

<p align="center">
<i>Log-in Screen</i><br>
<img width="600" src="https://i.imgur.com/PdE94tb.png" />
</p>

<p align="center">
<i>Verification Screen</i><br>
<img width="600" src="https://i.imgur.com/YYdH6na.png" />
</p>

<p align="center">
<i>Account Settings Screen</i><br>
<img width="600" src="https://i.imgur.com/cchxJgo.png" />
</p>

<p align="center">
<i>Profile Screen</i><br>
<img width="600" src="https://i.imgur.com/BtNW4Lc.png" />
</p>

---

## Contributing

Contributions are welcome :)

Changes can be submitted by opening a pull request - if you're new to GitHub, see the [documentation](https://docs.github.com/en/get-started/quickstart/contributing-to-projects) for a step-by-step guide on how to submit edits to projects. All submissions must abide by the [Contributor Covenant Code of Conduct](https://www.contributor-covenant.org/version/2/1/code_of_conduct/).

---

## License

_**[User Monkey](https://github.com/Lissy93/usermonkey)** is licensed under [MIT](https://gist.github.com/Lissy93/143d2ee01ccc5c052a17) © [Alicia Sykes](https://aliciasykes.com) 2022._ For information, see [TLDR Legal > MIT](https://tldrlegal.com/license/mit-license)

<details>
<summary>MIT License</summary>

```
The MIT License (MIT)
Copyright (c) Alicia Sykes <alicia@omg.com> 

Permission is hereby granted, free of charge, to any person obtaining a copy 
of this software and associated documentation files (the "Software"), to deal 
in the Software without restriction, including without limitation the rights 
to use, copy, modify, merge, publish, distribute, sub-license, and/or sell 
copies of the Software, and to permit persons to whom the Software is furnished 
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included install 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANT ABILITY, FITNESS FOR A
PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```

</details>

---

<!-- License + Copyright -->
<p  align="center">
  <i>© <a href="https://aliciasykes.com">Alicia Sykes</a> 2012</i><br>
  <i>Licensed under <a href="https://gist.github.com/Lissy93/143d2ee01ccc5c052a17">MIT</a></i><br>
  <a href="https://github.com/lissy93"><img src="https://i.ibb.co/4KtpYxb/octocat-clean-mini.png" /></a><br>
  <i>Thanks for visiting :)</i>
</p>

<!-- Dinosaur -->
<!-- 
                        . - ~ ~ ~ - .
      ..     _      .-~               ~-.
     //|     \ `..~                      `.
    || |      }  }              /       \  \
(\   \\ \~^..'                 |         }  \
 \`.-~  o      /       }       |        /    \
 (__          |       /        |       /      `.
  `- - ~ ~ -._|      /_ - ~ ~ ^|      /- _      `.
              |     /          |     /     ~-.     ~- _
              |_____|          |_____|         ~ - . _ _~_-_
-->
