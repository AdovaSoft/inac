<?php
if ($inp->value_pgd('s')) {
    $det_query = sprintf("SELECT name,post,sallary,date FROM staff LEFT JOIN staff_joning USING(idstaff) WHERE idstaff = %d;", $inp->value_pgd('s'));
    $rep_query = sprintf("SELECT rep_month, rep_year, attended, rep_leave, absent, overtime, sallary, hour FROM staff_report s WHERE idstaff = %d ORDER BY rep_year, rep_month;", $inp->value_pgd('s'));
    $staf_rep = $qur->get_custom_select_query($rep_query, 8);
    $staf_det = $qur->get_custom_select_query($det_query, 4);
    echo "<h2 class='blue'>" . strtoupper($staf_det[0][0]) . "</h2>";
    echo "Post : " . $staf_det[0][1];
    echo "<br/>Sallary : " . $staf_det[0][2];
    echo "<br/>Joining date : " . $inp->date_convert($staf_det[0][3]);
    if (count($staf_rep) <= 0) {
        echo "<h3 class='blue'>No attendece record stored yet</h3>";
    } else {
        echo "<h3 class='blue'>Attendence and Earned Salary report</h3>";
        echo "<table align='center' class='rb'>";
        echo "<tr>";
        echo "<td>Month</td><td>Attended</td><td>Leave</td><td>Absent</td><td>Overtime</td><td>Salary</td><td>Duty<br/>Hours</td><td>Earned Salary</td>";
        echo "</tr>";
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
            echo sprintf("%.2f", $s[6] * ($s[2] + $s[3] + ($s[5]) / $s[7]) / $inp->print_month_days($s[0], $s[1]));
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
    }
}
?>