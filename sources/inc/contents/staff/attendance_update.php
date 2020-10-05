<h1>Update Attendance</h1>
<br/>
<?php

include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    $mon = $_POST['r_m'];
    $yer = $_POST['r_y'];

    for ($i = 0, $j = 0; $i < $_POST['num']; $i++) {
        if (isset($_POST['staff_' . $i])) {
            $emp[$j] = $_POST['staff_' . $i];
            $at[$j] = $_POST['s_at' . $i];
            $lv[$j] = $_POST['s_lv' . $i];
            $ab[$j] = $_POST['s_ab' . $i];
            $ov[$j] = $_POST['s_ov' . $i];
            $j++;
        }
    }

    $flag = $qur->insert_attendance($mon, $yer, $emp, $at, $lv, $ab, $ov, $j);
    if ($flag) {
        echo "<h3 class='green'>All Attendance Update Successfull</h3>";
    } else {
        echo "<h3 class='red'>All Attendance Update failed</h3>";
        unset($_POST['ab']);
    }
}
echo "<br/><form method = 'POST' class='embossed'>";
$qur->print_attendance();
$inp->input_submit('ab', 'Save');
echo "</form>";
?>