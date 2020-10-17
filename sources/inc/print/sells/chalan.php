<h2>Delivery Chalan</h2>
<?php
$vou = $_POST['vou'];
$query_det = sprintf("SELECT name,date,discount, driver, vehicle, company  FROM (SELECT * FROM selles s WHERE idselles = %d) as sell
LEFT JOIN selles_discount USING (idselles) LEFT JOIN selles_chalan USING (idselles)  LEFT JOIN party USING (idparty);", $vou);
$sell_det = $qur->get_custom_select_query($query_det, 6);

$query_pro = sprintf("SELECT idproduct, s.unite,  rate, name,  mesurment_unite.unite   FROM (SELECT idproduct, unite,
 rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING
  (idproduct)) as s LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
$sell_pro = $qur->get_custom_select_query($query_pro, 5);

$n = count($sell_pro);
echo "<p style='padding: 5px 20px; text-align: left; margin: 0px;'>Voucher : <b class='blue'>" . $vou . "</b>";
echo "<span style='float: right;'>Date : ";
echo "<b class='blue'>" . $inp->date_convert($sell_det[0][1]) . "</b></span></p>";
echo "<p style='padding: 5px 20px; text-align: left;  margin: 0px;'>Customer Name : ";
echo "<b class='blue'>" . $sell_det[0][0] . "</b><br/></p>";
echo "<table class='rb' align='center' width='100%'>";
echo "<tr>";
echo "<th>";
echo "SI";
echo "</th>";
echo "<th>";
echo "Product";
echo "</th>";
echo "<th width='200'>";
echo "Quantity";
echo "</th>";
echo "</tr>";
$charges_total = 0;
$grand_total = 0;
for ($j = 0; $j < $n; $j++) {
    echo "<tr>";
    echo "<td style='width: 50px'>" . ($j + 1) . "</td>";
    echo "<td style='text-align: left; padding-left: 20px'>";
    echo esc($sell_pro[$j][3]);
    echo "</td>";
    echo "<td  style='text-align: right; padding-right: 20px'>";
    echo esc($sell_pro[$j][1]);
    echo "  ";
    echo esc($sell_pro[$j][4]);
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<p style='text-align: left;'><b>Driver Name: </b> " . esc($sell_det[0][3]) . "</p>"; //driver
echo "<p style='text-align: left; '><b>Vehicle No : </b> " . esc($sell_det[0][4]) . "</p>"; //vehicle
echo "<p style='text-align: left; '><b>Company :  </b> " . esc($sell_det[0][5]) . "</p>"; //company
