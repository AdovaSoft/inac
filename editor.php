<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include("./sources/inc/security_o.php");
$editor = isset($_POST['editor']) ? $_POST['editor'] : 'settings/theme';
$returnlink = isset($_POST['returnlink']) ? $_POST['returnlink'] : 'index.php?e=' . $encptid;
if ($editor && $returnlink) {
    $path = "./sources/inc/editor/" . $editor . ".php";
    if (file_exists($path)) {
        var_dump(file_exists($path));
        include "$path";
        if (isset($_POST['more_input']) && isset($_POST['num'])) {
            $more = $_POST['num'] + 1;
            $extrastring = $extrastring . "&&num=" . $more . "&&say=input_added";
        }
        header("Location:" . $returnlink . $extrastring);
    } else {
        header("Location:" . $returnlink);
    }
} else {
    header("Location:index.php?e=' . $encptid");
}
