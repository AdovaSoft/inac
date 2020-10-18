<h2>Investment  / Drawing  Report</h2>
<?php

include("sources/inc/print/double_date.php");

$ob = $qur->getPrevBalance($date1);
echo "<h4>Opening Balance of " . $inp->date_convert($date1) . " : " . $ob . " Taka</h4>";
$query = sprintf("SELECT `transaction`.*, party.name, comment
FROM transaction 
    LEFT JOIN transaction_comment USING(id) 
    LEFT JOIN party_payment USING(id) 
    LEFT JOIN party USING(idparty) 
WHERE `transaction`.date >= '%s' AND `transaction`.date <= '%s' AND party.name IS NULL ORDER BY DATE DESC;", $date1, $date2);
$res = $qur->get_custom_select_query($query, 7);

$in_total = 0;
$out_total = 0;
echo "<br/><table align='center' class='rb'>";
echo "<thead>";
echo "<tr>";
echo "<th>";
echo "Date";
echo "</th>";

echo "<th>";
echo "Investment";
echo "</th>";

echo "<th>";
echo "Drawings";
echo "</th>";

echo "<th>";
echo "Medium";
echo "</th>";

echo "<th>";
echo "Comments";
echo "</th>";
echo "</tr>";
echo "</thead>";
$p = 0;
$r = 0;
echo "<tbody>";
if(count($res) > 0) {
    foreach ($res as $amount) {
        echo "<tr>";

        echo "<td>";
        echo $inp->date_convert($amount[1]);
        echo "</td>";

        if ($amount[3] > 0) {
            echo "<td class='text-right pr-50'>";
            echo money($amount[3]);
            $in_total += $amount[3];
            echo "</td>";
            echo "<td>";
            echo "-";
            echo "</td>";

        } else {
            echo "<td>";
            echo "-";
            echo "</td>";
            echo "<td class='text-right pr-50'>";
            $amount[3] *= (-1);
            echo money($amount[3]);
            $out_total += ($amount[3] * (-1));
            echo "</td>";

        }

        echo "<td>";
        echo ($amount[2] == 0) ? "CASH" : "BANK";
        echo "</td>";

        echo "<td class='text-left'>" . esc($amount[6]) . "</td>";

        echo "</tr>";
    }
}
echo "</tbody>";
echo "<tfoot><tr><th>Total</th><th>" . money($in_total) . "</th>
<th>" . money($out_total) . "</th>
<td class='blue' colspan='2'>";
$in_total += $out_total;
echo "<b>Balance: " . money($in_total) . "</b></td>";
echo "</tr></tfoot>";
echo "</table><br/>";
?>