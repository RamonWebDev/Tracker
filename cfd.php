<?php
$dbhost = "localhost"; 
$dbuser = "ramonm_tracker";
$dbpassword = "n1oyf-09RH*}";
$dbdatabase = "ramonm_expenseTracker";
$config_basedir = "ramonmorales831.com/ExpenseTracker";
$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase) or die ("Error " . mysqli_error($db));
date_default_timezone_set('America/Chicago');
?>