<h1>Individual Selles Overview</h1>
<br/>
<?php

echo "<div id='sud3'><form method = 'POST'  class='embossed'>";
echo "<h4 class='blue'>Select another Selles</h4><br/>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
$qur->get_drop_down('selles', 'idselles', 'idselles', 'id', $inp->value_pgd('id'), 'full-width');
echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
echo "</form></div>";

$vou = $inp->value_pgd('id');
$query_det = sprintf("SELECT name,date,discount FROM (SELECT * FROM selles s WHERE idselles = %d) as sell LEFT JOIN selles_discount USING (idselles) LEFT JOIN party USING (idparty);", $vou);
$sell_det = $qur->get_custom_select_query($query_det, 3);
$query_pro = sprintf("SELECT idproduct, s.unite,  rate, name,  mesurment_unite.unite   FROM (SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING (idproduct)) as s LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
$sell_pro = $qur->get_custom_select_query($query_pro, 5);
$n = count($sell_pro);

echo "<a class='button'>";
echo "Voucher : " . $vou;
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Was sold to : ";
echo "<b class='blue'>" . isset($sell_det[0][0]) ? $sell_det[0][0] : '-' . "</b>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On date : ";
echo "<b class='blue'>" . $inp->date_convert($sell_det[0][1]) . "</b>";
echo "</a>";
echo "<br/>";
echo "<div id='sud0'>";
echo "<table class='rb' align='center'>";
echo "<tr>";
echo "<th>";
echo "Product";
echo "</th>";
echo "<th>";
echo "Quantity";
echo "</th>";
echo "<th>";
echo "Rate";
echo "</th>";
echo "<th>";
echo "Total";
echo "</th>";
echo "</tr>";
$charges_total = 0;
for ($j = 0; $j < $n; $j++) {
    echo "<tr>";
    echo "<td>";
    echo esc($sell_pro[$j][3]);
    echo "</td>";
    echo "<td>";
    echo esc($sell_pro[$j][1]);
    echo "  ";
    echo esc($sell_pro[$j][4]);
    echo "</td>";
    echo "<td>";
    echo money($sell_pro[$j][2]);
    echo "</td>";
    echo "<td>";
    $mul = $sell_pro[$j][1] * $sell_pro[$j][2];
    echo money($mul);
    $charges_total += $mul;
    echo "</td>";
    echo "</tr>";
}
echo "<tr>";
echo "<th colspan='3'>";
echo "Total Charges:";
echo "</th>";
echo "<th class='blue'>";
echo money($charges_total);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='3'>";
echo "Discount:";
echo "</th>";
echo "<th class='blue'>";
echo money($sell_det[0][2]);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='3'>";
echo "Net Charges:";
echo "</th>";
echo "<th class='blue'>";
$net = $charges_total - $sell_det[0][2];
echo money($net);
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='4'>";
if ($usertype == ADMIN) {
    echo "<form method='POST'><input type='hidden' name='sell_id' value='" . $vou . "'/><input type='submit' name='delete' value='Delete'/></form> ";
    echo "<form method='POST' action='index.php?e=" . $encptid . "&page=sells&sub=return'><input type='hidden' name='v' value='" . $vou . "'/><input type='submit' name='ab' value='Edit'/></form> ";
}
echo "<form id='printBox' method='POST' action='print.php?e=" . $encptid . "&page=sells&sub=sell' target='_blank'>
    <input type='hidden' name='vou' value='" . $vou . "'/><input type='submit' name='print' value='Print Bill'/>
    </form> ";
echo "<form method='POST' action='recept_print.php?e=" . $encptid . "' target='_blank'><input type='hidden' name='vou' value='" . $vou . "'/>
<input type='submit' name='print' value='Print on Pad'/>
</form> ";
echo "<form id='printBox' method='POST' action='print.php?e=" . $encptid . "&page=sells&sub=chalan' target='_blank'>
    <input type='hidden' name='vou' value='" . $vou . "'/><input type='submit' name='print' value='Print Chalan'/>
    </form> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div><br/>";