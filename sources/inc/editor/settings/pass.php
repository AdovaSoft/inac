<?php

if ($_POST['change'] && $_POST['oldpass1'] && $_POST['oldpass2'] && $_POST['newpass1'] && $_POST['newpass2']) {
    if ($_POST['oldpass1'] == $_POST['oldpass2'] && $_POST['newpass1'] == $_POST['newpass2']) {
        if (md5($_POST['oldpass1']) == $pass) {
            $qur = new indquery();
            $change = $qur->change_user_password($idstaff, md5($_POST['newpass1']));
            if ($change) {
                $_SESSION["user" . $encptid . "pass"] = md5($_POST['newpass1']);
                $extra_string = "&say=1";
            } else {
                $extra_string = "&say=2";
            }
        } else {
            $extra_string = "&say=3";
        }
    } else {
        $extra_string = "&say=4";
    }
} else {
    $extra_string = "&say=5";
}