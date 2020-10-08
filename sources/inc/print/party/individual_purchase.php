<?php
$id = $_GET['id'];
include("sources/inc/print/double_date.php");
if ($date1 && $date2) {
    $query2 = sprintf("SELECT date, SUM(unite*rate) as purchase,discount FROM (SELECT date, idpurchase FROM purchase WHERE idparty = %d AND date BETWEEN '%s' AND '%s' ) as purchase LEFT JOIN purchase_details USING (idpurchase)  LEFT JOIN purchase_discount USING(idpurchase)  GROUP BY idpurchase;", $id, $date1, $date2);
} else {
    echo "<h3>All time report</h3>";
    $query2 = sprintf("SELECT date, SUM(unite*rate) as purchase,discount FROM (SELECT date, idpurchase FROM purchase WHERE idparty = %d) as purchase LEFT JOIN purchase_details USING (idpurchase)  LEFT JOIN purchase_discount USING(idpurchase) GROUP BY idpurchase;", $id);
}
$name = $qur->get_cond_row('party', array('name'), 'idparty', '=', $id);
$pur = $qur->get_custom_select_query($query2, 3);
$r_bill_d = $r_bill_t = $total = 0;
if (count($pur) > 0) {
    echo "<h4>Purchased from " . $name[0][0] . ": </h4>";
    echo "<table align='center' class='rb'>";
    echo "<tr>";
    echo "<td>";
    echo "Date";
    echo "</td>";

    echo "<td>";
    echo "Bill";
    echo "</td>";

    echo "<td>";
    echo "Discount";
    echo "</td>";
    echo "</tr>";
    foreach ($pur as $s) {
        echo "<tr>";
        echo "<td>" . $inp->date_convert($s[0]) . "</td>" . "<td >" . money($s[1]) . "</td>" . "<td>" . money($s[2]) . "</td>";
        $r_bill_t += $s[1];
        $r_bill_d += $s[2];
        echo "</tr>";
    }
    echo "<tr><td>Sum </td> <td>" . money($r_bill_t) . "</td><td>" . money($r_bill_d) . "</td></tr>";
    $g_total = $r_bill_t - $r_bill_d;
    echo "<tr><td> Grand Total  </td> <td colspan = '2' > <b>" .money($g_total) . "</b></td></td></tr>";
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