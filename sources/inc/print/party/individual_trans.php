<?php
$id = $_GET[id];
include("sources/inc/print/double_date.php");
if ($date1 && $date2) {
    $query3 = sprintf("SELECT date, ammount, comment FROM (SELECT id FROM party_payment WHERE idparty = %d) as payment LEFT JOIN transaction USING (id) LEFT JOIN transaction_comment USING(id) WHERE date BETWEEN '%s' AND '%s';", $id, $date1, $date2);
} else {
    echo "<h3>All time report</h3>";
    $query3 = sprintf("SELECT date, ammount, comment FROM (SELECT id FROM party_payment WHERE idparty = %d) as payment LEFT JOIN transaction USING (id) LEFT JOIN transaction_comment USING(id);", $id);
}
$name = $qur->get_cond_row('party', array('name'), 'idparty', '=', $id);
$tran = $qur->get_custom_select_query($query3, 3);
if (count($tran) > 0) {
    echo "<h1 class='blue'>Transaction with " . $name[0][0] . ": </h1>";
    echo "<table align='center' class='rb'>";
    echo "<tr>";
    echo "<td>";
    echo "Date";
    echo "</td>";

    echo "<td>";
    echo " Paid to " . $name[0][0];
    echo "</td>";

    echo "<td>";
    echo " Received from " . $name[0][0];
    echo "</td>";
    echo "<td>";
    echo "Comments";
    echo "</td>";
    echo "</tr>";
    foreach ($tran as $s) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($s[0]);
        echo "</td>";
        if ($s[1] > 0) {
            echo "<td align = 'center' ></td>";
            echo "<td align = 'right' >" . sprintf("%.2f", $s[1]) . "</td>";
            $recived += $s[1];
        } else {
            echo "<td align = 'right' >" . sprintf("%.2f", -$s[1]) . "</td>";
            echo "<td align = 'center' ></td>";
            $paid += $s[1];
        }

        echo "<td>";
        echo $s[2];
        echo "</td>";
        echo "</tr>";
    }
    echo "<tr><td>Total </td> <td><b>" . sprintf("%.2f", -$paid) . "</b></td><td><b>" . sprintf("%.2f", $recived) . "</b  ></td><td> - </td></tr>";
    echo "</table>";
    $total = $qur->party_adv_due($id);
    if ($total < 0) {
        echo "<h2 class='faintred'>Total Due of " . $name[0][0] . " : " . (-$total) . " taka</h2><br/>";
    } elseif ($total > 0) {
        echo "<h2 class='faintred'>Total Outstanding of " . $name[0][0] . " : " . ($total) . " taka</h2><br/>";
    } else {
        echo "<h2 class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</h2><br/>";
    }
}
?>