<h2>Invoice</h2>
<?php
$vou = $_POST['vou'];
$query_det = sprintf("SELECT name,date, discount, driver, vehicle, company  
FROM (SELECT * FROM selles s WHERE idselles = %d) as sell 
LEFT JOIN selles_discount USING (idselles) 
    LEFT JOIN selles_chalan USING (idselles)  
    LEFT JOIN party USING (idparty);", $vou);
$sell_det = $qur->get_custom_select_query($query_det, 6);

$query_pro = sprintf("SELECT idproduct, s.unite,  rate, name,  mesurment_unite.unite   FROM (SELECT idproduct, unite,
 rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING
  (idproduct)) as s LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
$sell_pro = $qur->get_custom_select_query($query_pro, 5);

$n = count($sell_pro);
echo "Voucher : <b class='blue'>" . $vou . "</b>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Name : ";
echo "<b class='blue'>" . $sell_det[0][0] . "</b>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date : ";
echo "<b class='blue'>" . $inp->date_convert($sell_det[0][1]) . "</b>";
echo "<br><br>";
echo "<table class='rb' align='center' width='100%'>";
echo "<tr>";
echo "<th>";
echo "SI";
echo "</th>";
echo "<th>";
echo "Product";
echo "</th>";
echo "<th>";
echo "Quantity";
echo "</th>";
echo "<th>";
echo "Cost";
echo "</th>";
echo "<th>";
echo "Total";
echo "</th>";
echo "</tr>";
$charges_total = 0;
$grand_total = 0;
for ($j = 0; $j < $n; $j++) {
    echo "<tr>";
    echo "<td>";
    echo $j+1;
    echo "</td>";
    echo "<td>";
    echo esc($sell_pro[$j][3]);
    echo "</td>";
    echo "<td>";
    echo esc($sell_pro[$j][1]);
    echo "  ";
    echo esc($sell_pro[$j][4]);
    echo "</td>";
    echo "<td style='text-align: right; padding-right: 20px'>";
    echo money($sell_pro[$j][2]);
    echo "</td>";
    echo "<td style='text-align: right; padding-right: 20px'>";
    $total = $sell_pro[$j][1] * $sell_pro[$j][2];
    echo money($total);
    $charges_total = $charges_total + $sell_pro[$j][1] * $sell_pro[$j][2];
    echo "</td>";
    echo "</tr>";
}
echo "<tr>";
echo "<th colspan='4'>";
echo "Total Charges:";
echo "</th>";
echo "<th class='blue' style='text-align: right; padding-right: 20px'>";
echo money($charges_total);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='4' >";
echo "Discount:";
echo "</th>";
echo "<th class='blue'  style='text-align: right; padding-right: 20px'>";
echo money($sell_det[0][2]);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='4' >";
echo "Net charges:";
echo "</th>";
echo "<th class='blue' style='text-align: right; padding-right: 20px'>";
$net = $charges_total - $sell_det[0][2];
echo money($net);
$grand_total += $net;
echo "</th>";
echo "</tr>";
echo "</table>";



