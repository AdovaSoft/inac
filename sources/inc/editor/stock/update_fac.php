<?php

if (isset($_POST['ab'])) {
    $flag = (isset($_POST['p']) && $_POST['p'] > 0 && isset($_POST['pr']));
    if ($flag) {
        if ($_POST['s'] < 1) {
            $extra_string = "&say=5";
            $flag = false;
        }
    }

    if ($flag) {
        $c_s = $qur->get_cond_row('stock', array('factory_stock'), 'idproduct', '=', $_POST['p']);
        //update_stock($id,$date,$st,$cur)
        if ($_POST['pr'] == -1) {
            if ($_POST['s'] > $c_s[0][0]) {
                $extra_string = "&say=3";
                $flag = false;
            } else {
                $u_s = -$_POST['s'];
            }
        } else {
            $u_s = $_POST['s'];
        }

        if ($flag) {
            $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
            $flag = $qur->update_fac_stock($_POST['p'], $date, $u_s, $c_s[0][0]);
        }


        if ($flag) {
            $extra_string = "&say=1";
        } else {
            $extra_string = "&say=2";
        }

    } else {
        $extra_string = "&say=4";
    }
}

$extra_string .= $inp->extra_string('ab');
$extra_string .= $inp->extra_string('pr');
$extra_string .= $inp->extra_string('d_y');
$extra_string .= $inp->extra_string('d_m');
$extra_string .= $inp->extra_string('d_d');
$extra_string .= $inp->extra_string('s');
?>