<h1>Investment and Drawing Report</h1>
<br/>
<?php

include("sources/inc/contents/accounts/delete.php");
include("sources/inc/double_date.php");
$ob = $qur->getPrevBalance($date1);
echo "<br/><h4>Opening Balance of " . $inp->date_convert($date1) . " : " . money($ob) . " Taka</h4><br/>";
$con = new indquery();
$query = sprintf("SELECT `transaction`.*, party.name 
FROM transaction 
    LEFT JOIN transaction_comment USING(id) 
    LEFT JOIN party_payment USING(id) 
    LEFT JOIN party USING(idparty) 
WHERE `transaction`.date >= '%s' AND `transaction`.date <= '%s' AND party.name IS NULL ORDER BY DATE DESC;", $date1, $date2);
$res = $con->get_custom_select_query($query, 7);
echo "<a id='printBox'  href='print.php?e=$encptid&page=accounts&&sub=report&&date1=$date1&&date2=$date2' class='button' target='_blank'><b> Print </b></a>";

$in_total = 0;
$out_total = 0;
echo "<br/><table align='center' class='rb table'>";
echo "<thead>";
echo "<tr>";
echo "<th>";
echo "Trans. ID";
echo "</th>";

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
echo "<th>";
echo "Trans. Date/Time";
echo "</th>";
if ($usertype == ADMIN) {
    echo "<th width='100px'>";
    echo "Delete Buttons";
    echo "</th>";
}
echo "</tr>";
echo "</thead>";
$p = 0;
$r = 0;
echo "<tbody>";
for ($i = 0; $i < count($res); $i++) {
    echo "<tr>";

    echo "<td>";
    echo esc($res[$i][0]);
    echo "</td>";
    echo "<td>";
    echo $inp->date_convert($res[$i][1]);
    echo "</td>";

    if ($res[$i][4] > 0) {
        echo "<td class='text-right pr-50'>";
        echo money($res[$i][4]);
        $in_total += $res[$i][4];
        echo "</td>";
        echo "<td>";
        echo "-";
        echo "</td>";

    } else {
        echo "<td>";
        echo "-";
        echo "</td>";
        echo "<td class='text-right pr-50'>";
        $res[$i][4] *= (-1);
        echo money($res[$i][4]);
        $out_total += ($res[$i][4] * (-1));
        echo "</td>";

    }

    echo "<td>";
    echo ($res[$i][2] == 0) ? "CASH" : "BANK";
    echo "</td>";

    echo "<td class='text-left'>" . esc($res[$i][6]) . "</td>";

    echo "<td>";
    if (isset($res[$i][5]))
        echo date('d F, Y h:i:s A', strtotime($res[$i][5]));
    else
        echo "-";
    echo "</td>";

    if ($usertype == ADMIN) {
        echo "<td>";
        echo "<form method='POST'><br/>
<input type='hidden' name='tid' value='" . $res[$i][0] . "'>
<input type='submit' name='delete' value='Delete'></form>";
        echo "</td>";
    }
    echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr><th colspan='2'>Total</th><th>" . money($in_total) . "</th>
<th>" . money($out_total) . "</th>
<td class='blue' colspan='3'>";
$in_total -= $out_total;
echo "<b>Balance: " . money($in_total) . "</b></td>";

if ($usertype == ADMIN)
    echo "<td></td>";

echo "</tr></tfoot>";
echo "</table><br/>";

?>
