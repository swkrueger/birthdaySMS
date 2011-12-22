<?php
/**
 * sender.php - Sends the SMSs
 *
 **/

require_once('config.php');
require_once('common.php');

function normalize_specialchars($string){
    $from = 'äëïöüáéíóúàèìòùÄËÏÖÜÁÉÍÓÚÀÈÌÒÙ';
    $to = 'aeiouaeiouaeiouAEIOUAEIOUAEIOU';
    $string = utf8_decode($string);    
    $string = strtr($string, utf8_decode($from), $to);
    return utf8_encode($string);
} 

function sendsms($message, $number) {
    // No message, no SMS
    if (!$message) {
        error('No message specified!');
        return 1;
    }

    /// Make sure the number is in the correct format

    // Remove all non-numeric characters
    $number = preg_replace('/\D/', '', $number);

    // Number shouldn't start with "0"
    if ($number[0]=="0") {
        $number = '27'.substr($number, 1);
    }

    // Check for data integrity
    if (strlen($number) != 11)  {
        error(sprintf('Number %s not 11 characters long!', $number));
        return 1;
    }

    // Make sure it is a South African mobile
    if (substr($number, 0, 2)!='27') {
        error(sprintf('Number %s does not start with "27"!', $number));
        return 1;
    }

    // Strip some special characters. They aren't specified in the GSM 03.38 
    //  character set
    $message = normalize_specialchars($message);

    debug(sprintf('Sending message "%s" to the number %s', $message, $number));

    // Encode message
    $message_enc = urlencode($message);

    global $username, $password, $dryrun;
    $url = "http://www.winsms.co.za/api/batchmessage.asp?user=$username&password=$password&message=$message_enc&Numbers=$number;";

    if ($dryrun) {
        info('.. not sending (DRY RUN)');
        return 0;
    }

    // Send the SMS!
    // API Instructions at http://www.winsms.co.za/support3x/api.htm
    // Can also use SOAP or XML, but HTTP is the easiest

    debug(sprintf('.. opening URL %s', $url));

    $fp = fopen($url, 'r');

    while(!feof($fp)){
        $line = fgets($fp, 4000);
        debug('.. [OUTPUT] '.$line);
    }
    //
    // TODO: Now Parse $line to determine if errors were encountered, and to obtain the Server ID for each message sent.

    fclose($fp);
    return 0;
}




?>
