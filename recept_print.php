<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include("sources/inc/security_o.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" href="css/receptprintstyle.css" type="text/css"/>
  <script type='text/javascript' src='js/print.js'></script>
</head>
<body onLoad="printpage()">
<?php
$vou = $_POST['vou'];
$query_det = sprintf("SELECT name,date,discount,adress FROM (SELECT * FROM selles s WHERE idselles = %d) as sell LEFT JOIN selles_discount USING (idselles) LEFT JOIN party USING (idparty) LEFT JOIN party_adress USING(idparty)", $vou);
$sell_det = $qur->get_custom_select_query($query_det, 4);
$query_pro = sprintf("SELECT idproduct, s.unite,  rate, name,  mesurment_unite.unite   FROM (SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING (idproduct)) as s LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
$sell_pro = $qur->get_custom_select_query($query_pro, 5);
$n = count($sell_pro);
$top_margin = file_get_contents("css/recept_meaurements/top.txt");
$left_margin = file_get_contents("css/recept_meaurements/left.txt");
$before_si_gap = file_get_contents("css/recept_meaurements/before_si_gap.txt");
$si_date_gap = file_get_contents("css/recept_meaurements/si_date_gap.txt");
$description_width = file_get_contents("css/recept_meaurements/description_width.txt");
$quantity_width = file_get_contents("css/recept_meaurements/quantity_width.txt");
$rate_width = file_get_contents("css/recept_meaurements/rate_width.txt");
$taka_width = file_get_contents("css/recept_meaurements/taka_width.txt");

echo "<img src='images/blank1by1.gif' alt='margin' width='100%' height='" . $top_margin . "px'/>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $left_margin . "px' class='leftmargin'/>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $before_si_gap . "' class='inline'/>";
echo "<b>" . $vou . "</b>";
echo "<img src='images/blank1by1.gif' alt='margin' width='" . $si_date_gap . "' class='inline'/>";
echo "<b>" . $inp->date_convert($sell_det[0][1]) . "</b>";
echo "<br/>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<b>" . $sell_det[0][0] . "</b>";
echo "<br/>";
echo "<br/>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<b>" . $sell_det[0][3] . "</b>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<table align='left'>";
$charges_total = 0;
for ($j = 0; $j < $n; $j++) {
    echo "<tr>";
    echo "<td align='left'>";
    echo "<b>(" . ($j + 1) . ")</b>";
    echo "</td>";
    echo "<td width='" . $description_width . "px' align='center'>";
    echo $sell_pro[$j][3];
    echo "</td>";
    echo "<td width='" . $quantity_width . "px' align='center'>";
    echo $sell_pro[$j][1];
    echo "  ";
    echo $sell_pro[$j][4];
    echo "</td>";
    echo "<td width='" . $rate_width . "px' align='center'>";
    echo $sell_pro[$j][2];
    echo "</td>";
    echo "<td width='" . $taka_width . "px' align='right'>";
    echo $sell_pro[$j][1] * $sell_pro[$j][2];
    $charges_total = $charges_total + $sell_pro[$j][1] * $sell_pro[$j][2];
    echo "</td>";
    echo "</tr>";
}
echo "<tr>";
echo "<th colspan='4' align='right'>";
echo "Total Charges";
echo "</th>";
echo "<th align='right'>";
echo $charges_total;
echo "</th>";

echo "</tr>";
echo "<tr>";
echo "<th colspan='4' align='right'>";
echo "Discount";
echo "</th>";
echo "<th align='right'>";
echo $sell_det[0][2];
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='4' align='right'>";
echo "Net Charges";
echo "</th>";
echo "<th align='right'>";
echo $charges_total - $sell_det[0][2];
echo "</th>";
echo "</tr>";
echo "</table>";
?>
</body>
</html>
