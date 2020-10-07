<h1>Accounts Report</h1>
<br/>
<?php

include("sources/inc/contents/accounts/delete.php");
include("sources/inc/double_date.php");
$ob = $qur->getPrevBalance($date1);
echo "<br/><h4>Opening Balance of " . $inp->date_convert($date1) . " : " . $ob . " Taka</h4><br/>";
$con = new indquery();
$query = sprintf("SELECT * FROM (SELECT * FROM transaction WHERE DATE BETWEEN '%s' AND '%s') as tran LEFT JOIN transaction_comment USING(id) ORDER BY DATE DESC;", $date1, $date2);
$res = $con->get_custom_select_query($query, 5);

echo "<a id='printBox'  href='print.php?e=" . $encptid . "&page=accounts&&sub=report&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";

$in_total = 0;
$out_total = 0;
echo "<br/><table align='center' class='rb table'>";
echo "<thead>";
echo "<tr>";

echo "<th>";
echo "Date";
echo "</th>";

echo "<th>";
echo "Investment / Revenue";
echo "</th>";

echo "<th>";
echo "Drawings / Expenses";
echo "</th>";

echo "<th width='100px'>";
echo "Comments";
echo "</th>";
if ($usertype == ADMIN) {
    echo "<th>";
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
    echo $inp->date_convert($res[$i][1]);
    echo "</td>";

    if ($res[$i][3] > 0) {
        echo "<td>";
        echo money($res[$i][3]);
        $in_total = $in_total + $res[$i][3];
        echo "</td>";
        echo "<td>";
        echo "-";
        echo "</td>";

    } else {
        echo "<td>";
        echo "-";
        echo "</td>";
        echo "<td>";
        $res[$i][3] *= (-1);
        echo money($res[$i][3]);
        $out_total = $out_total + ($res[$i][3] * (-1));
        echo "</td>";

    }
    echo "<td width='100px'>";
    if (isset($res[$i][4]))
        echo $res[$i][4];
    else
        echo "-";
    echo "</td>";
    if ($usertype == ADMIN) {
        echo "<td>";
        echo "<form method='POST'><br/><input type='hidden' name='tid' value='" . $res[$i][0] . "'><input type='submit' name='delete' value='Delete'></form>";
        echo "</td>";
    }
    echo "</tr>";
}
echo "</tbody>";
echo "<tfoot><tr><th>Total</th><th>" . money($in_total) . "</th>
<th>" . money($out_total) . "</th>
<td class='blue' colspan='2'>";
$in_total -= $out_total;
echo "<b>Balance: " . money($in_total) . "</b></td></tr></tfoot>";
echo "</table><br/>";

?>
