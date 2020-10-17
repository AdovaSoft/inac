<?php
if ($inp->value_pgd('s')) {
    $det_query = sprintf("SELECT name,post,sallary,date FROM staff LEFT JOIN staff_joning USING(idstaff) WHERE idstaff = %d;", $inp->value_pgd('s'));
    $rep_query = sprintf("SELECT rep_month, rep_year, attended, rep_leave, absent, overtime, sallary, hour FROM staff_report s WHERE idstaff = %d ORDER BY rep_year, rep_month;", $inp->value_pgd('s'));
    $staff_report = $qur->get_custom_select_query($rep_query, 8);
    $staff_det = $qur->get_custom_select_query($det_query, 4);
    echo "<h2 class='blue'>" . strtoupper($staff_det[0][0]) . "</h2>";
    echo "Post : " . $staff_det[0][1];
    echo "<br/>Salary : " . money($staff_det[0][2]);
    echo "<br/>Joining date : " . $inp->date_convert($staff_det[0][3]);
    if (count($staff_report) <= 0) {
        echo "<h3 class='blue'>No attendance record stored yet</h3>";
    } else {
        echo "<h3 class='blue'>Attendance and Earned Salary report</h3>";
        echo "<table align='center' class='rb'>";
        echo "<tr>";

        echo "<th>SI</th>";
        echo "<th>Month</th>";
        echo "<th>Attended</th>";
        echo "<th>Leave</th>";
        echo "<th>Absent</th>";
        echo "<th>Overtime</th>";
        echo "<th>Salary</th>";
        echo "<th>Duty<br/>Hours</th>";
        echo "<th>Earned Salary</th>";
        echo "</tr>";
        $i = 1;
        foreach ($staff_report as $s) {
            echo "<tr>";

            echo "<td>" . $i++ . "</td>";
            echo "<td>";
            echo $inp->print_month($s[0]) . " " . $s[1];
            echo "</td>";

            echo "<td>";
            echo esc($s[2]);
            echo "</td>";

            echo "<td>";
            echo esc($s[3]);
            echo "</td>";

            echo "<td>";
            echo esc($s[4]);
            echo "</td>";

            echo "<td>";
            echo esc($s[5]);
            echo "</td>";

            echo "<td class='text-right' >";
            echo money($s[6]);
            echo "</td>";

            echo "<td>";
            echo esc($s[7]);
            echo "</td>";

            $salary = $s[6] * ($s[2] + $s[3] + ($s[5]) / $s[7]) / $inp->print_month_days($s[0], $s[1]);
            echo "<td class='text-right' >";
            echo money($salary);
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
    }
}
