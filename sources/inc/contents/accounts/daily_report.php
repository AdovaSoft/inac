<h1>Accounts Daily Report</h1>
<br/>
<?php

include("sources/inc/contents/accounts/delete.php");
include("sources/inc/single_date.php");
$ob = $qur->getPrevBalance($date);
echo "<h4>Opening Balance of " . $inp->date_convert($date) . " " . $ob . " Taka</h4>";
$con = new indquery();
$query = sprintf("SELECT * FROM (SELECT * FROM transaction WHERE date='%s') as tran LEFT JOIN transaction_comment USING(id) ORDER BY date DESC;", $date);
$res = $con->get_custom_select_query($query, 5);
$in_total = 0;
$out_total = 0;
echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=accounts&&sub=daily_report&&date=" . $date . "' class='button' target='_blank'><b> Print </b></a>";

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
echo "Drawings / Expences";
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
        echo($res[$i][3]);
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
        echo($res[$i][3] * (-1));
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
echo "<tfoot><tr><th>Total</th><th>" . $in_total . "</th><th>" . $out_total . "</th><td class='blue' colspan='2'><b>Balance: " . ($in_total - $out_total) . "</b></td></tr></tfoot>";
echo "</table>";
?>

