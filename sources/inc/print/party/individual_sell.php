<?php
$id = $_GET['id'];
include("sources/inc/print/double_date.php");
if ($date1 && $date2) {
    $query1 = sprintf("SELECT date, SUM(unite*rate) as sell,discount FROM (SELECT date, idselles FROM selles WHERE idparty = %d  AND date BETWEEN '%s' AND '%s') as selles LEFT JOIN selles_details USING (idselles)  LEFT JOIN selles_discount USING(idselles)  GROUP BY idselles;", $id, $date1, $date2);
} else {
    echo "<h3>All time report</h3>";
    $query1 = sprintf("SELECT date, SUM(unite*rate) as sell,discount FROM (SELECT date, idselles FROM selles WHERE idparty = %d) as selles LEFT JOIN selles_details USING (idselles)  LEFT JOIN selles_discount USING(idselles) GROUP BY idselles;", $id);
}
$name = $qur->get_cond_row('party', array('name'), 'idparty', '=', $id);
$sell = $qur->get_custom_select_query($query1, 3);
$bill_t = $bill_d = $total = 0 ;

if (count($sell) > 0) {
    echo "<h4>Sold to " . $name[0][0] . ": </h4>";
    echo "<table align='center' class='rb'>";
    echo "<tr>";

    echo "<td>";
    echo "SI";
    echo "</td>";
   
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
    $i = 0;
    foreach ($sell as $s) {
        echo "<tr>";

        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $inp->date_convert($s[0]) . "</td>";
        echo "<td class='text-right' >" . money($s[1]) . "</td>";
        echo "<td class='text-right' >" . money($s[2]) . "</td>";
        $bill_t += $s[1];
        $bill_d += $s[2];

        echo "</tr>";
    }
    echo "<tr>";

    echo "<td colspan='2' class='text-right' >Sum </td>";
    echo "<td class='text-right' >" . money($bill_t) . "</td>";
    echo "<td class='text-right' >" . money($bill_d) . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th colspan='2' class='text-right' > Grand Total  </th>";
    $total = ($bill_t - $bill_d);
    echo "<td colspan = '2' > <b>" . money($total)  . "</b></td>";
    echo "</tr>";
    $total += ($bill_t - $bill_d);
    echo "</table>";
    $total = $qur->party_adv_due($id);
    if ($total < 0) {
        $total *= (-1);
        echo "<h2 class='faintred'>Total Due of " . $name[0][0] . " : " . money($total) . " taka</h2><br/>";
    } 
    else if ($total > 0) {
        echo "<h2 class='faintred'>Total Outstanding of " . $name[0][0] . " : " . money($total) . " taka</h2><br/>";
    } 
    else {
        echo "<h2 class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</h2><br/>";
    }
}
?>