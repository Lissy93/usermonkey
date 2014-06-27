User Monkey
==========

###A complete user system written in PHP

Getting Started
---------------


`/* First start a session, if not already started */`
`if(session_id() == '') { session_start(); } `

`/* Next include the PHP classes (see demo folder for Db class)*/`
`include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/Db.class.php";         // Database Class`
`include_once $_SERVER['DOCUMENT_ROOT']."/user-monkey/php/UserActions.class.php";// User Actions Class`

`/* Connect to the database */`
`$db = new Db();`
`$db->connect();`

`/* Create an instance of the UserActions class */`
`$ua = new UserActions();`




