<?php
$idstaff = isset($idstaff) ? $idstaff : 0;
$extra_string = null;
die(var_dump($_POST));
if (isset($_POST['change'])) {
    if ($_POST['newcss'] > 0) {
        $qur = new indquery();
        $change = $qur->changecss($idstaff, $_POST['newcss']);
        if ($change) {
            $extra_string = "&&say=1";
        } else {
            $extra_string = "&&say=2";
        }
    } else {
        $extra_string = "&&say=3";
    }
} else {
    $extra_string = "&&say=2";
}
