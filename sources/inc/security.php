<?php
$username = isset($_POST['username']) ? htmlentities($_POST['username']) : NULL;
$userpass = isset($_POST['userpass']) ? htmlentities($_POST['userpass']) : NULL;

if (isset($_GET['e'])) {
    $encptid = $_GET['e'];
    $pass = isset($_SESSION["user" . $encptid . "pass"]) ? $_SESSION["user" . $encptid . "pass"] : null;
    $username = isset($_SESSION["user" . $encptid . "username"]) ? $_SESSION["user" . $encptid . "username"] : null;
    include("sources/db/login_db_fn.php");

    $checkingdata = login_check_session($username, $pass);

    if ($checkingdata != 0) {
        $csschoice = $checkingdata[0];
        $idstaff = $_SESSION["user" . $encptid . "idstaff"];
        $usertype = $_SESSION["user" . $encptid . "usertype"];
        include("sources/db/_db_func.php");
        $inp = new html();
        $qur = new indquery();
    } else {
        $loginmessage = "<h2 class='blue'>Please Login.</h2>";
        include("sources/inc/loginform.php");
    }
} elseif (isset($username) && isset($userpass) && isset($_POST['submit'])) {
    include("sources/db/login_db_fn.php");
    $checkingdata = login_check($username, $_POST['userpass']);
    if ($checkingdata != 0) {
        $idstaff = $checkingdata[0];
        $pass = $checkingdata[1];

        $usertype = $checkingdata[2];
        $csschoice = $checkingdata[3];

        $username = $_POST['username'];

        $encptid = md5($idstaff);

        $_SESSION["user" . $encptid . "idstaff"] = $idstaff;
        $_SESSION["user" . $encptid . "pass"] = $pass;
        $_SESSION["user" . $encptid . "usertype"] = $usertype;
        $_SESSION["user" . $encptid . "username"] = $username;

        include("sources/db/_db_func.php");
        /*$inp = new html();
        $qur = new indquery();
        */
        header("Location: index.php?e=" . $encptid);
    } else {
        $loginmessage = "<h2 class='red'>Wrong ID or Password.</h2>";
        include("sources/inc/loginform.php");
    }
} elseif ((!isset($username) || !isset($userpass)) && isset($_POST['submit'])) {
    $loginmessage = "<h2 class='red'>Please fill all fields.</h2>";
    include("sources/inc/loginform.php");
} elseif (isset($_GET['logout'])) {
    $loginmessage = "<h2 class='green'>Logged out successfully.</h2>";
    include("sources/inc/loginform.php");
} else {
    $loginmessage = "<h2 class='blue'>Please login.</h2>";
    include("sources/inc/loginform.php");
}