<?php /*SEll*/
if (isset($_POST['ab'])) {
    $flag = true;
    if (isset($_POST['d']) && $_POST['d'] >= 0 && $_POST['d'] != null && $_POST['pt'] != null) {
        $n = $_POST['num'];
        $j = 0;
        $cost = 0;
        $flag = true;
        for ($i = 0, $j = 0; $i < $n; $i++) {
            if ($_POST['pr_' . $i] && $_POST['pc_' . $i] && $_POST['co_' . $i] > 0) {
                $sel_info[$j++] = array($_POST['pr_' . $i], $_POST['pc_' . $i], $_POST['co_' . $i]);
                $cost += ($_POST['co_' . $i] * $_POST['pc_' . $i]);
            }
        }

        if ($_POST['d'] >= $cost && $_POST['d'] != 0) {
            $extrastring = "&say=5";
            $flag = false;
        } elseif ($j == 0) {
            $extrastring = "&say=4";
            $flag = false;
        } elseif ($_POST['t'] < 0) {
            $extrastring = "&say=8";
            $flag = false;
        } else {
            $flag = true;
        }

        if ($flag) {
            $flag = $qur->newSelles($_POST['pt'], $inp->get_post_date('sd'), $sel_info, $_POST['d'], $_POST['t']);
            if ($flag) {
                if ($flag == (-2)) {
                    $extrastring = "&say=6";
                } elseif ($flag == (-1)) {
                    $extrastring = "&say=7";
                } else {
                    $extrastring = "&say=1&idselles=" . $flag . "&cost=" . $cost;
                }
            } else {
                $extrastring = "&say=2";
            }
        }
    } else {
        $extrastring = "&say=3";
    }
}

$extrastring .= $inp->extra_string('ab');
$extrastring .= $inp->extra_string('d');
$extrastring .= $inp->extra_string('num');
$extrastring .= $inp->extra_string('pt');
$extrastring .= $inp->extra_string('sd_d');
$extrastring .= $inp->extra_string('sd_m');
$extrastring .= $inp->extra_string('sd_y');
$extrastring .= $inp->extra_string('t');
$n = $_POST['num'];
for ($i = 0; $i < $n; $i++) {
    $extrastring .= $inp->extra_string('pr_' . $i);
    $extrastring .= $inp->extra_string('pc_' . $i);
    $extrastring .= $inp->extra_string('co_' . $i);
}