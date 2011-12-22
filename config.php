<?php 
// Database settings
// Database user requires only "INSERT" privilege
$dbhost = '127.0.0.1';
$dbuser = 'user';
$dbpasswd = 'password';
$dbname = 'bday';
$dbprefix = '';

// WinSMS login settings
$username = 'me@myorg.org';
$password = 'ZePazzword';

// Message format settings
$message = Array();
$message['EN'] = '$name, on behalf of XYZ, we would like to wish you a very Happy Birthday!';
$message['AF'] = '$name, namens XYZ wil ons jou gelukwens met jou verjaarsdag!'; 

// Safety mechanism: Maximum SMS's allowed to be sent each day
$maxsend = 50;

// Dry run
// To disable the actual sending of the SMS's, set $dryryn = true
$dryrun = true;

// Show debugging output?
$debug = true;
?>
