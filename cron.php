<?php
/**
 * bithdaySMS - Simple script to send happy birthday SMSs to people
 *
 * Author: SW Krueger
 * Last update: 22 December 2011
 **/

// Include dependencies
require_once('config.php');
require_once('database.php');
require_once('sender.php');

debug('Started cron.php at '.date("r"));

// Database query
$db = db_connect($dbhost, $dbuser, $dbpasswd, $dbname);

$sql = 'SELECT * FROM people WHERE ((DAY(birthday)=DAY(CURDATE())) AND (MONTH(birthday)=MONTH(CURDATE())))';

$result = db_query($db, $sql);
$cnt = 1;
while ($row = mysql_fetch_array($result)) {
    $smsmsg = $message[$row['language']];
    info(sprintf('Processing %s (%s) @ %s with birthday %s [LANG: %s]', $row['firstnames'], $row['surname'], $row['cellno'], $row['birthday'], $row['language']));

    if (!$row['firstnames']) {
        error('Record has a blank "First Name"! Skipping...');
        continue;
    }

    // Substitute name
    $smsmsg = str_replace('$name', $row['firstnames'], $smsmsg);

    // TODO: Substitute age

    sendsms($smsmsg, $row['cellno']);

    // Increment counter
    if (++$cnt>$maxsend) {
        error(sprintf('[FATAL] Exceeded maximum amount of SMS\'s (maxsend = %d)! BAILING OUT!', $maxsend));
        break;
    }
}

db_disconnect($db);
debug('Finished with cron.php at '.date("r"));

?>
