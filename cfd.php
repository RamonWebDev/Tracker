<?php
$dbhost = "localhost"; //changed to protect database info
$dbuser = "";
$dbpassword = "";
$dbdatabase = "";

try{
    $db = new PDO("mysql:host={$dbhost};dbname={$dbdatabase}", $dbuser, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Trouble shoot exception
}

catch(PDOEXCEPTION $e){
    echo $e->getMessage();
}

?>
