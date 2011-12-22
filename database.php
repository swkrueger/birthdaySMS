<?php
// TODO: Code / get proper database wrapper

require_once('config.php');
require_once('common.php');

function db_connect($dbhost, $dbuser, $dbpasswd, $dbname) {
    $db = mysql_connect($dbhost,$dbuser,$dbpasswd);
    mysql_select_db($dbname, $db);
    return $db;
}

function db_query($db, $query) {
    if ($db==NULL) {
        error('DB not open!');
    }
    
    $result = mysql_query($query, $db);
    
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        error($message);
        return false;
    }
    
    return $result;
}

function db_disconnect($db) {
    if ($db==NULL) {
        error('DB not open!');
    }
    mysql_close($db);
}


?>
