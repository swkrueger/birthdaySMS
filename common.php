<?php
function error($msg) {
    echo '[ERROR] '.$msg."\n";
}

function debug($msg) {
    global $debug;
    if ($debug)
        echo '[DEBUG] '.$msg."\n";
}

function info($msg) {
    echo '[INFO] '.$msg."\n";
}
?>
