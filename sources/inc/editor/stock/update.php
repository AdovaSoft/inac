<?php
if (isset($_POST['ab'])) {
    $flag = (isset($_POST['p']) && $_POST['p'] > 0 && isset($_POST['pr']));
    if ($flag) {
        if ($_POST['s'] < 1) {
            $extrastring = "&say=5";
            $flag = false;
        }
    }

    if ($flag) {
        $c_s = $qur->get_cond_row('stock', array('stock'), 'idproduct', '=', $_POST['p']);
        //update_stock($id,$date,$st,$cur)
        if ($_POST['pr'] == -1) {
            if ($_POST['s'] > $c_s[0][0]) {
                $extrastring = "&say=3";
                $flag = false;
            } else {
                $u_s = -$_POST['s'];
            }
        } else {
            $u_s = $_POST['s'];
        }

        if ($flag) {
            $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
            $flag = $qur->update_stock($_POST['p'], $date, $u_s, $c_s[0][0]);
        }


        if ($flag) {
            $extrastring = "&say=1";
        } else {
            $extrastring = "&say=2";
        }

    } else {
        $extrastring = "&say=4";
    }
}

$extrastring = $extrastring . $inp->extra_string('ab');
$extrastring = $extrastring . $inp->extra_string('pr');
$extrastring = $extrastring . $inp->extra_string('d_y');
$extrastring = $extrastring . $inp->extra_string('d_m');
$extrastring = $extrastring . $inp->extra_string('d_d');
$extrastring = $extrastring . $inp->extra_string('s');
?>