<?php
include "sources/inc/system.php";
include "sources/inc/security_o.php";
?>
<!DOCTYPE html>
<head lang="en-US">
  <title>Recept Print</title>
  <link rel="stylesheet" href="css/receptprintstyle.css" type="text/css"/>
  <script type='text/javascript' src='js/print.js'></script>
</head>
<body onload="printpage()">
<?php
$vou = esc($_POST['vou']) ;
$query_det = sprintf("SELECT name,date,discount,adress FROM (SELECT * FROM selles s WHERE idselles = %d) as sell LEFT JOIN selles_discount USING (idselles) LEFT JOIN party USING (idparty) LEFT JOIN party_adress USING(idparty)", $vou);
$sell_det = $qur->get_custom_select_query($query_det, 4);
$query_pro = sprintf("SELECT idproduct, s.unite,  rate, name,  mesurment_unite.unite   FROM (SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING (idproduct)) as s LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
$sell_pro = $qur->get_custom_select_query($query_pro, 5);
$n = count($sell_pro);
$recept = json_decode(file_get_contents("css/recept.json"), true);
extract($recept);

echo "<div style='width: 100%; height: $top_margin;'></div>";
/*echo "<img src='images/blank1by1.gif' alt='margin' width='100%' height='" . $top_margin . "'/>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $left_margin . "' class='leftmargin'/>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $before_si_gap . "' class='inline'/>";*/
echo "<b>" . esc($vou) . "</b>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $si_date_gap . "' class='inline'/>";
echo "<b>" . $inp->date_convert(esc($sell_det[0][1])) . "</b>";
echo "<br/>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<b>" . esc($sell_det[0][0]) . "</b>";
echo "<br/>";
echo "<br/>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<b>" . esc($sell_det[0][3]) . "</b>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<table class='table'>";
echo "<thead><tr>
    <th>SI</th>
    <th>Item Description</th>
    <th>Quantity</th>
    <th>Rate</th>
    <th>Total</th>
    </tr></thead>";
$charges_total = 0;
for ($j = 0; $j < $n; $j++) {
    echo "<tr>";
    echo "<td class='text-left'>";
    echo "<b>(" . ($j + 1) . ")</b>";
    echo "</td>";
    echo "<td width='" . $description_width . "' class='text-left'>";
    echo esc($sell_pro[$j][3]);
    echo "</td>";
    echo "<td width='" . $quantity_width . "' align='center'  style=' border: 1px solid black;'>";
    echo esc($sell_pro[$j][1]);
    echo "  ";
    echo esc($sell_pro[$j][4]);
    echo "</td>";
    echo "<td width='" . $rate_width . "' align='center' style=' border: 1px solid black;'>";
    echo money($sell_pro[$j][2]);
    echo "</td>";
    echo "<td width='" . $taka_width . "' align='right'  style=' border: 1px solid black;'>";
    $money = $sell_pro[$j][1] * $sell_pro[$j][2];
    echo money($money);
    $charges_total = $charges_total + $money;
    echo "</td>";
    echo "</tr>";
}
echo "<tr>";
echo "<td colspan='4' class='text-right'>";
echo "Total Charges";
echo "</td>";
echo "<th class='text-right'>";
echo money($charges_total);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='4' class='text-right'>";
echo "Discount";
echo "</td>";
echo "<th class='text-right'>";
echo money($sell_det[0][2]);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='4' class='text-right'>";
echo "Net Charges";
echo "</td>";
echo "<th class='text-right'>";
$grand_total = $charges_total - $sell_det[0][2];
echo money($grand_total);
echo "</th>";
echo "</tr>";
echo "</table>";
?>
</body>
</html>
