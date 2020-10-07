<?php
if ($inp->value_pgd('ab') == 'Edit') {
    $id = $_POST['v'];
    $flag = true;
    $cost = 0;
    $pro = array();
    for ($i = 0; $i < $_POST['num']; $i++) {
        if ($_POST['pr_pc_' . $i] < $_POST['pc_' . $i] || $_POST['co_' . $i] <= 0) {
            $extra_string = "&&say=5";
            $flag = false;
            break;
        } else {
            $pro[$i][0] = $_POST['pr_' . $i];
            $pro[$i][1] = $_POST['pr_pc_' . $i];
            $pro[$i][2] = $_POST['pc_' . $i];
            $pro[$i][3] = $_POST['co_' . $i];
        }
        $cost += $_POST['pr_pc_' . $i] * $_POST['co_' . $i];
    }
    $d = $_POST['d'];
    if ($flag)
        $sell_edited = $qur->sells_return($id, $pro, $d, $cost);
    if ($sell_edited) {
        $extra_string = "&&say=" . $sell_edited;
    }

}
$extra_string .= $inp->extra_string('ab');
$extra_string .= $inp->extra_string('v');
$extra_string .= "&&v_submit=Find Another";
?>