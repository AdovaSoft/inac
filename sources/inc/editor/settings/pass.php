<?php

if ($_POST['change'] && $_POST['oldpass1'] && $_POST['oldpass2'] && $_POST['newpass1'] && $_POST['newpass2']) {
    if ($_POST['oldpass1'] == $_POST['oldpass2'] && $_POST['newpass1'] == $_POST['newpass2']) {
        if (md5($_POST['oldpass1']) == $pass) {
            $qur = new indquery();
            $change = $qur->changepass($idstaff, md5($_POST['newpass1']));
            if ($change) {
                $_SESSION["user" . $encptid . "pass"] = md5($_POST['newpass1']);
                $extrastring = "&&say=1";
            } else {
                $extrastring = "&&say=2";
            }
        } else {
            $extrastring = "&&say=3";
        }
    } else {
        $extrastring = "&&say=4";
    }
} else {
    $extrastring = "&&say=5";
}