<?php
if (isset($_POST['e']) || isset($_GET['e'])) {
    $encptid = isset($_POST['e']) ? $_POST['e'] : $_GET['e'];
    $pass = $_SESSION["user" . $encptid . "pass"];
    $username = $_SESSION["user" . $encptid . "username"];
    include("sources/db/login_db_fn.php");
    $checking = login_check_session($username, $pass);
    if ($checking != 0) {
        $idstaff = $_SESSION["user" . $encptid . "idstaff"];
        include("sources/db/_db_func.php");
        $qur = new indquery();
        $inp = new html();
    } else {
        header("Location:index.php");
    }
} else {
    header("Location:index.php");
}
?>