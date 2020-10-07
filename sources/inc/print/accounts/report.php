<h1>Accounts Report</h1>
<?php

include("sources/inc/print/double_date.php");

$ob = $qur->getPrevBalance($date1);
echo "<h4>Opening Balance of " . $inp->date_convert($date1) . " : " . $ob . " Taka</h4>";
$query = sprintf("SELECT * FROM (SELECT * FROM transaction WHERE DATE BETWEEN '%s' AND '%s') as tran LEFT JOIN transaction_comment USING(id) ORDER BY DATE DESC;", $date1, $date2);
$res = $qur->get_custom_select_query($query, 5);

$in_total = 0;
$out_total = 0;

echo "<table align='center' class='rb'>";
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
    echo "</tr>";
}

echo "<tr><th>Total</th><th>" . $in_total . "</th><th>" . $out_total . "</th><td>Balance : " . ($in_total - $out_total) . "</td></tr>";

echo "</table>";
?>

