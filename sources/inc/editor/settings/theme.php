<?php
$idstaff = isset($idstaff) ? $idstaff : 0;
$extra_string = null;
if (isset($_POST['change'])) {
    if ($_POST['newcss'] > 0) {
        $qur = new indquery();
        $change = $qur->change_theme_style($idstaff, $_POST['newcss']);
        if ($change) {
            $_SESSION['theme'] = $_POST['newcss'];
            $extra_string = "&say=1";
        } else {
            $extra_string = "&say=2";
        }
    } else {
        $extra_string = "&say=3";
    }
} else {
    $extra_string = "&say=2";
}
