<?php
session_start();
$encptid = $_GET['e'];
unset($_SESSION["user" . $encptid . "idstaff"]);
unset($_SESSION["user" . $encptid . "pass"]);
unset($_SESSION["user" . $encptid . "usertype"]);
unset($_SESSION["user" . $encptid . "csschoice"]);
unset($_SESSION["user" . $encptid . "username"]);
header("Location:index.php?logout=1");
?>