<?php
$dbhost = "localhost"; 
$dbuser = "ramonm_tracker";
$dbpassword = "n1oyf-09RH*}";
$dbdatabase = "ramonm_expenseTracker";

try{
    $db = new PDO("mysql:host={$dbhost};dbname={$dbdatabase}", $dbuser, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Trouble shoot exception
}

catch(PDOEXCEPTION $e){
    echo $e->getMessage();
}

?>