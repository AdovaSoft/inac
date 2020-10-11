<?php
if ($inp->value_pgd('s')) {
    $det_query = sprintf("SELECT name,post,sallary,date FROM staff LEFT JOIN staff_joning USING(idstaff) WHERE idstaff = %d;", $inp->value_pgd('s'));
    $bon_query = sprintf("SELECT id,date,month,year,ammount*-1 FROM (SELECT * FROM staff_bonus WHERE idstaff = %d) as staff LEFT JOIN transaction USING(id);", $inp->value_pgd('s'));
    $staff_det = $qur->get_custom_select_query($det_query, 4);
    $staf_bon = $qur->get_custom_select_query($bon_query, 5);
    echo "<h2 class='blue'>" . strtoupper($staff_det[0][0]) . "</h2>";
    echo "Post : " . $staff_det[0][1];
    echo "<br/>Sallary : " . money($staff_det[0][2]);
    echo "<br/>Joining date : " . $inp->date_convert($staff_det[0][3]);

    if (count($staf_bon) <= 0) {
        echo "<h3 class='blue'>No bonus record stored yet</h3>";
    } else {
        echo "<h3 class='blue'>Bonus report</h3>";
        echo "<table align='center' class='rb'>";
        echo "<tr>";
        echo "<th>SI</th>";
        echo "<th>Paying date</th>";
        echo "<th>Bonus of</th>";
        echo "<th>Amount</th>";
        echo "</tr>";

        $bon_total = 0;
        $n = count($staf_bon);
        $j = 0;
        for ($i = 0; $i < $n; $i++) {
            echo "<tr>";

            echo "<td>" . $j++ . "</td>";

            echo "<td>";
            echo $inp->date_convert($staf_bon[$i][1]);
            echo "</td>";

            echo "<td>";
            echo $inp->print_month($staf_bon[$i][2]) . ' ' . $staf_bon[$i][3];
            echo "</td>";

            $amount = $staf_bon[$i][4];
            echo "<td  class='text-right' >";
            echo money($amount);
            echo "</td>";
            $bon_total = $bon_total + $staf_bon[$i][4];

            echo "</tr>";

        }
        echo "<tr>";
        echo "<th colspan='3' class='text-right' >Total :</th>";
        echo "<th class='text-right' >" . money($bon_total). "</th>";
        echo "</tr>";
        echo "</table>";
    }
}
?>