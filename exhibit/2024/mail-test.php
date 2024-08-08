<?php

    error_reporting(E_ALL|E_STRICT);
    ini_set('display_errors', 1);
    echo 'I am : ' . `whoami`;
    $result = mail('carey@careyestes.com','Testing 1 2 3','This is a test.');
    echo '<hr>Result was: ' . ( $result === FALSE ? 'FALSE' : 'TRUE') . $result;
    echo '<hr>';
    echo phpinfo();

?>