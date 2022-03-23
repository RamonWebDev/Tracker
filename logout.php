<?php
require("cfd.php");
session_name('tracker');
session_start();
session_destroy();
header("Location: https://ramonmorales831.com/Tracker/index.php");
?>