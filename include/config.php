<?php

// the variables needed for the chat //

defined('USER') ?null:define('USER','root');

defined('PASS') ?null:define('PASS','');

defined('DB') ?null:define('DB','findmyjodi');

defined('HOST') ?null:define('HOST','localhost');

defined('PREF') ?null:define('PREF','');



  //////////////////////////////////////////////////////////////////////////////////////////////

 /// don't change the following unless you are not using the default authentication system ///

/////////////////////////////////////////////////////////////////////////////////////////////



//date_default_timezone_set('Asia/Kolkata');



 $useDefaultAuth=1; // use the default authentication system (1: yes / 0: no)

 $srcDB='findmyjodi'; // the database that contains your web site users

 $usersTable4setup='chat_users'; // the table that contain the users which is used to the DB setup

 $usersTable=PREF.'chat_users'; // the table that contain the users

$statueColomn='status'; // the name of the colomn that stores the user's chat statue ( if you dont have this in your existing user table install_B.php will create this for you , so just give it a name)

 $userIdColomn='id'; // the colomn name of the user's id 

 $nameColomn='name'; // the colomn name of the user's nickname

  $emailColomn='email';// the colomn name of the user's email



  ///////////////////////////////////////////////////////////////////////////

 /// Don't change this value unless this colomn was changed from the db ///

///////////////////////////////////////////////////////////////////////////



  $chatTable=PREF.'chat_data'; // the table where the chat messages are stored

?>