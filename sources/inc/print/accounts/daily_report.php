<h1>Accounts Daily Report</h1>
<?php

include("sources/inc/print/single_date.php");

$ob = $qur->getPrevBalance($date);
echo "<h4>Opening Balance of " . $inp->date_convert($date) . " " . $ob . " Taka</h4>";
$query = sprintf("SELECT * FROM (SELECT * FROM transaction WHERE date='%s') as tran LEFT JOIN transaction_comment USING(id) ORDER BY date DESC;", $date);
$res = $qur->get_custom_select_query($query, 5);

$in_total = 0;
$out_total = 0;

echo "<br/><table align='center' class='rb'>";
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

echo "<th width='200px'>";
echo "Comments";
echo "</th>";
echo "</tr>";
$p = 0;
$r = 0;
for ($i = 0; $i < count($res); $i++) {
    echo "<tr>";
    echo "<td>";
    echo $inp->date_convert($res[$i][1]);
    echo "</td>";


    if ($res[$i][3] > 0) {
        echo "<td>";
        $total = $res[$i][3];
        echo money($total);
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
        $toatl = $res[$i][3] * (-1);
        echo money($total);
        $out_total = $out_total + ($res[$i][3] * (-1));
        echo "</td>";

    }
    echo "<td width='100px'>";
    if (isset($res[$i][4]))
        echo $res[$i][4];
    else
        echo "-";
    echo "</td>";
    echo "</tr>";
}
$total = $in_total - $out_total;
echo "<tr><th>Total</th><th>" . money($in_total) . "</th><th>" . money($out_total) . "</th><td>Balance : " . money($total) . "</td></tr>";

echo "</table>";
?>

