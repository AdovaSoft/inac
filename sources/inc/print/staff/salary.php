<?php
if ($inp->value_pgd('s')) {
    $det_query = sprintf("SELECT name,post,sallary,date FROM staff LEFT JOIN staff_joning USING(idstaff) WHERE idstaff = %d;", $inp->value_pgd('s'));
    $sal_query = sprintf("SELECT id,date,sal_month,sal_year,ammount*-1 FROM (SELECT * FROM staff_sallary WHERE idstaff = %d) as staff LEFT JOIN transaction USING(id) ORDER BY sal_year,sal_month;", $inp->value_pgd('s'));
    $staf_det = $qur->get_custom_select_query($det_query, 4);
    $staf_sal = $qur->get_custom_select_query($sal_query, 5);
    echo "<h2 class='blue'>" . strtoupper($staf_det[0][0]) . "</h2>";
    echo "Post : " . $staf_det[0][1];
    echo "<br/>Sallary : " . $staf_det[0][2];
    echo "<br/>Joining date : " . $inp->date_convert($staf_det[0][3]);

    if (count($staf_sal) <= 0) {
        echo "<h3 class='blue'>No sallary record stored yet</h3>";
    } else {
        echo "<h3 class='blue'>Sallary report</h3>";

        echo "<table align='center' class='rb'>";
        echo "<tr><td>Paying date</td><td>Sallary of</td><td>Ammount</td></tr>";
        $n = count($staf_sal);
        $amnt = 0;
        $samnt = NULL;
        for ($i = 0; $i < $n; $i++) {
            $samnt += $staf_sal[$i][4];
            echo "<tr>";
            echo "<td>";
            echo $inp->date_convert($staf_sal[$i][1]);
            echo "</td>";

            echo "<td>";
            echo $inp->print_month($staf_sal[$i][2]) . ' ' . $staf_sal[$i][3];
            echo "</td>";

            echo "<td>";
            echo $staf_sal[$i][4];
            echo "</td>";

            echo "</tr>";
        }
        echo "<tr><td colspan = 3>Total : $samnt</td></tr>";
        echo "</table>";
    }
}
?>