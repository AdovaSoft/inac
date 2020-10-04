<?php
$idstaff = isset($idstaff) ? $idstaff : 0;
$extrastring = null;
die(var_dump($_POST));
if (isset($_POST['change'])) {
    if ($_POST['newcss'] > 0) {
        $qur = new indquery();
        $change = $qur->changecss($idstaff, $_POST['newcss']);
        if ($change) {
            $extrastring = "&&say=1";
        } else {
            $extrastring = "&&say=2";
        }
    } else {
        $extrastring = "&&say=3";
    }
} else {
    $extrastring = "&&say=2";
}
