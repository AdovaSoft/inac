<?php /*Purchase*/
$sel_info = array();

if (isset($_POST['ab'])) {

    $flag = true;

    if (isset($_POST['d']) && $_POST['pt'] && $_POST['res']) {
        $n = $_POST['num'];
        $j = 0;
        $cost = 0;
        $flag = true;

        for ($i = 0, $j = 0; $i < $n; $i++) {

            if ($_POST['pr_' . $i] && $_POST['pc_' . $i] > 0 && $_POST['co_' . $i] > 0) {
                $sel_info[$j++] = array($_POST['pr_' . $i], $_POST['pc_' . $i], $_POST['co_' . $i]);
                $cost += $_POST['co_' . $i] * $_POST['pc_' . $i];
            }
        }

        if ($_POST['d'] >= $cost) {
            $extra_string = "&say=5";
            $flag = false;
        } elseif ($j == 0) {
            $extra_string = "&say=4";
            $flag = false;
        } elseif ($_POST['t'] < 0) {
            $extra_string = "&say=8";
            $flag = false;
        }

    } else {
        $flag = false;
    }

    if ($flag) {

        $query = new indquery();

        $flag = $query->newPurchase($_POST['pt'], $inp->get_post_date('sd'), $sel_info, $_POST['d'], $_POST['res'], $_POST['t']);

        if ($flag) {
            $extra_string = "&say=1&idselles=" . $flag . "&cost=" . $cost;
        } else {
            $extra_string = "&say=2";
        }
    } elseif (!$extra_string) {
        $extra_string = "&say=3";
    } else {
        $extra_string = $extra_string;
    }
}
$extra_string .= $inp->extra_string('ab');
$extra_string .= $inp->extra_string('d');
$extra_string .= $inp->extra_string('num');
$extra_string .= $inp->extra_string('pt');
$extra_string .= $inp->extra_string('res');
$extra_string .= $inp->extra_string('sd_d');
$extra_string .= $inp->extra_string('sd_m');
$extra_string .= $inp->extra_string('sd_y');
$extra_string .= $inp->extra_string('t');
$n = $_POST['num'];
for ($i = 0, $j = 0; $i < $n; $i++) {
    $extra_string .= $inp->extra_string('pr_' . $i);
    $extra_string .= $inp->extra_string('pc_' . $i);
    $extra_string .= $inp->extra_string('co_' . $i);
}
?>