<h1>Staff Report</h1>
<br/>
<?php
$res = $qur->get_cond_row('staff', array('idstaff', 'name', 'post'), 'status', '=', 1);
echo "<form method = 'POST' class='embossed'>";
echo "<h3 class='blue'>Select  staff</h3><br/>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
echo "<select name = 's' >";
echo "<option></option>";
if ($inp->value_pgd('s')) {
    foreach ($res as $r) {
        if ($r[0] == $inp->value_pgd('s'))
            echo "<option value = '" . $r[0] . "' selected > $r[1] ($r[2]) </option>";
        else
            echo "<option value = '" . $r[0] . "' > $r[1] ($r[2]) </option>";
    }
} else {
    foreach ($res as $r) {
        echo "<option value = '" . $r[0] . "' > $r[1] ($r[2]) </option>";
    }
}
echo "</select>";
echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
echo "</form>";


if ($inp->value_pgd('s') != null) {
    $det_query = sprintf("SELECT name,post,sallary,date,hour FROM staff LEFT JOIN staff_joning USING(idstaff) WHERE idstaff = %d;", $inp->value_pgd('s'));
    $sal_query = sprintf("SELECT id,date,sal_month,sal_year,ammount*-1 FROM (SELECT * FROM staff_sallary WHERE idstaff = %d) as staff LEFT JOIN transaction USING(id) ORDER BY  sal_year, sal_month;", $inp->value_pgd('s'));
    $bon_query = sprintf("SELECT id,date,month,year,ammount*-1 FROM (SELECT * FROM staff_bonus WHERE idstaff = %d) as staff LEFT JOIN transaction USING(id);", $inp->value_pgd('s'));
    $rep_query = sprintf("SELECT rep_month, rep_year, attended, rep_leave, absent, overtime, sallary, hour FROM staff_report s WHERE idstaff = %d ORDER BY rep_year, rep_month;", $inp->value_pgd('s'));

    if (isset($_POST['delete']) && $_POST['delete'] == "Delete" && $usertype == ADMIN) {
        $delete = $qur->delete_attendense($_POST['s'], $_POST['m'], $_POST['y']);
        if ($delete)
            echo "<br/><h3 class='green'>Attendance entry Deleted</h3>";
        else
            echo "<br/><h3 class='red'>Could not delete attendance entry</h3>";
    }

    if (isset($_POST['at_update']) && ($usertype == ADMIN)) {
        $mon = $_POST['r_m'];
        $yer = $_POST['r_y'];
        if (isset($_POST['s'])) {
            $emp[0] = $_POST['s'];
            $at[0] = $_POST['s_at'];
            $lv[0] = $_POST['s_lv'];
            $ab[0] = $_POST['s_ab'];
            $ov[0] = $_POST['s_ov'];
        }

        $flag = $qur->insert_attendance($mon, $yer, $emp, $at, $lv, $ab, $ov, 1);

        if ($flag) {
            echo "<br/><h3 class='green'>Attendance Update Successfully</h3>";
        } else {
            echo "<br/><h3 class='red'>Attendance Update Failed</h3>";
        }
    }

    if (isset($_POST['save_sal']) && ($usertype == ADMIN)) {
        $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
        if (isset($_POST['s']) && $_POST['s'] != null && isset($_POST['amnt']) && $_POST['amnt'] > 0 && isset($_POST['tt']) && $_POST['tt'] > 0) {
            $flag = true;
            if ($_POST['tt'] == 2) {
                $flag = $qur->addBonusPay($date, $_POST['s'], $_POST['m'], $_POST['y'], $_POST['amnt'], $_POST['cmnt'] . ' as Bonus');
            } elseif ($_POST['tt'] == 1) {
                $flag = $qur->add_salary_pay($date, $_POST['s'], $_POST['m'], $_POST['y'], $_POST['amnt'], $_POST['cmnt'] . ' as Salary');
            }
            if ($flag) {
                echo "<br/><h3 class='green'>Salary Update Successfully</h3>";
            } else {
                echo "<br/><h3 class='red'>Salary Update failed</h3>";
            }
        } else {
            echo "<br/><h3 class='red'>Please provide all info</h3>";
        }
    }


    $staff_det = $qur->get_custom_select_query($det_query, 5);
    $staf_sal = $qur->get_custom_select_query($sal_query, 5);
    $staf_bon = $qur->get_custom_select_query($bon_query, 5);
    $staf_rep = $qur->get_custom_select_query($rep_query, 8);

    echo "<br/><h2 class='blue'>" . strtoupper($staff_det[0][0]) . "</h2>";
    echo "<br/>Post : " . esc($staff_det[0][1]);
    echo "<br/>Sallary : " . money($staff_det[0][2]);
    echo "<br/>Duty Hours : " . esc($staff_det[0][4]);
    echo "<br/>Joining date : " . $inp->date_convert($staff_det[0][3]);
    if (count($staf_rep) <= 0) {
        echo "<br/><h3 class='blue'>No attendance record stored yet</h3>";
    } else {
        echo "<br/><h3 class='blue'>Attendance and Earned Salary report</h3>";
        echo "<br/><a href='print.php?e=" . $encptid . "&page=staff&&sub=attendance&&s=" . $inp->value_pgd('s') . "' class='button' target='_blank'><b> Print Attendance and Earned Salary Report</b></a><br/>";
        echo "<table align='center' class='rb'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Month</th>
<th>Attended</th>
<th>Leave</th>
<th>Absent</th>
<th>Overtime</th>
<th>Salary</th
><th>Duty<br/>Hours</th>
<th>Earned Salary</th>";
        if ($usertype == ADMIN) {
            echo "<th>Action</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($staf_rep as $s) {
            echo "<tr>";

            echo "<td>";
            echo $inp->print_month($s[0]) . " " . $s[1];
            echo "</td>";

            echo "<td>";
            echo $s[2];
            echo "</td>";

            echo "<td>";
            echo $s[3];
            echo "</td>";

            echo "<td>";
            echo $s[4];
            echo "</td>";

            echo "<td>";
            echo $s[5];
            echo "</td>";

            echo "<td>";
            echo $s[6];
            echo "</td>";

            echo "<td>";
            echo $s[7];
            echo "</td>";

            echo "<td>";
            $salary_amount = $s[6] * ($s[2] + $s[3] + ($s[5]) / $s[7]) / $inp->print_month_days($s[0], $s[1]);
            echo money($salary_amount);
            echo "</td>";

            if ($usertype == ADMIN) {
                echo "<td>";
                echo "<br/><form method='POST'>";
                echo "<input type='hidden' name='m' value='" . $s[0] . "'/>";
                echo "<input type='hidden' name='y' value='" . $s[1] . "'/>";
                echo "<input type='hidden' name='s' value='" . $inp->value_pgd('s') . "'/>";
                echo "<input type='submit' name='delete' value='Delete'/>";
                echo "</form>";
                echo "</td>";
            }

            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    if ($usertype == ADMIN) {
        echo "<br/><form class='embossed' method='POST'>";
        echo "Attendance For : ";
        $d = date('Y-m-d');
        $y = $d[0] . $d[1] . $d[2] . $d[3];
        $m = $d[5] . $d[6];
        $inp->select_month('r_m', $m, true);
        echo " of ";
        $inp->select_digit('r_y', 2011, 2021, $y, 1);
        echo "<table align='center' class='centeraligned'>";
        echo "<tr>";
        echo "<th>Attended</th>";
        echo "<th>Leave</th>";
        echo "<th>Absent</th>";
        echo "<th>Overtime</th>";
        echo "</tr>";
        echo "<tr>";

        echo '<td>';
        echo "<input type = 'hidden' name = 's' value ='" . $inp->value_pgd('s') . "' />";
        if (isset($_POST['s_at']))
            $inp->select_digit('s_at', 0, 31, $_POST['s_at'], 1);
        else
            $inp->select_digit('s_at', 0, 31, 0, 1);
        echo '</td>';

        echo '<td>';
        if (isset($_POST['s_lv']))
            $inp->select_digit('s_lv', 0, 31, $_POST['s_lv'], 1);
        else
            $inp->select_digit('s_lv', 0, 31, 0, 1);
        echo '</td>';

        echo '<td>';
        if (isset($_POST['s_ab']))
            $inp->select_digit('s_ab', 0, 31, $_POST['s_ab'], 1);
        else
            $inp->select_digit('s_ab', 0, 31, null, 1);
        echo '</td>';

        echo '<td>';
        if (isset($_POST['s_ov']))
            $inp->select_digit('s_ov', 0, 372, $_POST['s_ov'], 1);
        else
            $inp->select_digit('s_ov', 0, 372, 0, 1);
        echo '</td>';
        echo "</tr>";

        echo "</table>";
        echo "<br/><input type='submit' name='at_update' value='Update Attendance'>";
        echo "</form>";
    }

    if (count($staf_sal) <= 0) {
        echo "<br/><h3 class='blue'>No sallary record stored yet</h3>";
    } else {
        echo "<br/><br/><h3 class='blue'>Salary report</h3>";
        echo "<br/><a href='print.php?e=" . $encptid . "&page=staff&&sub=salary&&s=" . $inp->value_pgd('s') . "' class='button' target='_blank'><b> Print Salary Report</b></a><br/>";
        echo "<table align='center' class='rb'>";
        echo "<thead>";
        echo "<tr><td>Paying date</td><td>Salary of</td><td>Amount</td></tr>";
        echo "</thead>";
        $n = count($staf_sal);
        $salary_amount = 0;
        echo "<tbody>";
        for ($i = 0; $i < $n; $i++) {
            $salary_amount += $staf_sal[$i][4];
            echo "<tr>";
            echo "<td>";
            echo $inp->date_convert($staf_sal[$i][1]);
            echo "</td>";

            echo "<td>";
            echo $inp->print_month($staf_sal[$i][2]) . ' ' . $staf_sal[$i][3];
            echo "</td>";

            echo "<td>";
            echo money($staf_sal[$i][4]);
            echo "</td>";

            echo "</tr>";
        }
        echo "</tbody>";
        echo "<tfoot>";
        echo "<tr><td colspan = 3>Total : " . money($salary_amount) . "</td></tr>";
        echo "</tfoot>";
        echo "</table>";
    }

    if (count($staf_bon) <= 0) {
        echo "<br/><h3 class='blue'>No bonus record stored yet</h3>";
    } else {
        echo "<br/><br/><h3 class='blue'>Bonus report</h3>";
        echo "<br/><a href='print.php?e=" . $encptid . "&page=staff&&sub=bonus&&s=" . $inp->value_pgd('s') . "' class='button' target='_blank'><b> Print Bonus Report</b></a><br/>";
        echo "<table align='center' class='rb'>";
        echo "<tr><td>Paying date</td><td>Bonus of</td><td>Amount</td></tr>";
        $bon_total = 0;
        $n = count($staf_bon);
        for ($i = 0; $i < $n; $i++) {

            echo "<tr>";
            echo "<td>";
            echo $inp->date_convert($staf_bon[$i][1]);
            echo "</td>";

            echo "<td>";
            echo $inp->print_month($staf_bon[$i][2]) . ' ' . $staf_bon[$i][3];
            echo "</td>";

            echo "<td>";
            echo $staf_bon[$i][4];
            $bon_total = $bon_total + $staf_bon[$i][4];
            echo "</td>";

            echo "</tr>";

        }
        echo "<tr><td colspan = 3>Total : $bon_total</td></tr>";
        echo "</table>";
    }

    if ($usertype == ADMIN) {
        echo "<br/><form method = 'POST'   class='embossed'>";
        echo "<h3>Pay Salary or bonus</h3><br/>";
        echo "Date : ";
        $inp->input_date('d', Date('Y-m-d'));
        echo "<br/><br/>";
        echo "<input type='hidden' name='s' value='" . $inp->value_pgd('s') . "'>";
        echo "Month : ";
        $inp->select_month('m', isset($_POST['m']) ? $_POST['m'] : Date('m'));
        $inp->select_digit('y', 2000, 2050, isset($_POST['y']) ? $_POST['y'] : Date('Y'), 1);

        echo "<br/><br/>Amount : ";
        echo "<input type='number' name='amnt'/><br>";

        echo "<br/>Payment Type : ";
        echo "<select name='tt'>";
        echo "<option>Select a Option</option> ";
        echo "<option value = '1'> Salary </option> ";
        echo "<option value = '2'> Bonus </option> ";
        echo "</select>";

        echo "<input type = 'hidden' name = 'cmnt'  value = 'Paying to " . strtoupper($staff_det[0][0]) . " (" . $staff_det[0][1] . ")' />";
        echo "<br/>";
        $inp->input_submit('save_sal', 'Save');
        echo "</form>";
    }
}
?>