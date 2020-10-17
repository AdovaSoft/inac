<h2>Purchase Report</h2>
<br/>
<?php
if (isset($_POST['delete'])) {
    include("sources/inc/contents/purchase/delete.php");
}
include("sources/inc/double_date.php");
$query = sprintf("SELECT idpurchase FROM purchase WHERE date BETWEEN '%s' AND '%s' ORDER BY idpurchase DESC", $date1, $date2);
$purchase_ids = $qur->get_custom_select_query($query, 1);
$grand_total = 0;
echo "<a  class='button' id='showAll' onClick='showAll()'> Expand All </a> <a  class='button' id='hideAll' onClick='hideAll()'> Minimize All </a><br/>";
foreach ($purchase_ids as $index => $purchase_id) {
    $vou = $purchase_id[0];
    $query_recept = sprintf("SELECT recipt FROM purchase_recipt WHERE idpurchase = '%s'", $vou);
    $recept = $qur->get_custom_select_query($query_recept, 1);
    $query_pro = sprintf("SELECT idproduct, p.unite, rate, name, mesurment_unite.unite FROM (SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM purchase_details WHERE idpurchase = %d) as purchase LEFT JOIN product USING (idproduct)) as p LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
    $sell_pro = $qur->get_custom_select_query($query_pro, 5);
    $query_det = sprintf("SELECT name,date,discount FROM (SELECT * FROM purchase s WHERE idpurchase = %d) as purchase LEFT JOIN purchase_discount USING (idpurchase) LEFT JOIN party USING (idparty);", $vou);
    $sell_det = $qur->get_custom_select_query($query_det, 3);
    $n = count($sell_pro);
    echo "<div>";
    echo "<a class='button' onclick='showit(" . $index . ")'>";
    echo "Voucher : " . $vou;
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplier Voucher : " . esc($recept[0][0]);
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchased From : ";
    echo "<b class='blue'>" . esc($sell_det[0][0]) . "</b>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On date : ";
    echo "<b class='blue'>" . $inp->date_convert($sell_det[0][1]) . "</b>";
    echo "</a>";
    echo "<br/>";
    echo "<div id='sud" . $index . "'>";
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
        echo " ";
        echo esc($sell_pro[$j][4]);
        echo "</td>";
        echo "<td class='text-right pr-50'>";
        echo money($sell_pro[$j][2]);
        echo "</td>";
        echo "<td class='text-right pr-50'>";
        $mul = $sell_pro[$j][1] * $sell_pro[$j][2];
        echo money($mul);
        $charges_total = $charges_total + $mul;
        echo "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan='3'>";
    echo "Total Charges:";
    echo "</td>";
    echo "<td class='blue text-right pr-50'>";
    echo money($charges_total);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='3'>";
    echo "Discount:";
    echo "</td>";
    echo "<td class='blue text-right pr-50'>";
    echo money($sell_det[0][2]);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='3'>";
    echo "Net charges:";
    echo "</td>";
    echo "<td class='blue text-right pr-50'>";
    $net = $charges_total - $sell_det[0][2];
    echo money($net);
    $grand_total = $grand_total + $net;
    echo "</td>";
    echo "</tr>";
    if ($usertype == ADMIN) {
        echo "<tr>";
        echo "<td colspan='4'>";
        echo "<form method='POST'><input type='hidden' name='pur_id' value='" . $vou . "'/><input type='submit' name='delete' value='Delete'/></form> ";
        echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=purchase&&sub=return'><input type='hidden' name='v' value='" . $vou . "'/><input type='submit' name='ab' value='Edit'/></form>";
        echo "<form method='POST' action='print.php?e=" . $encptid . "&&page=purchase&&sub=purchase' target='_blank'><input type='hidden' name='id' value='" . $vou . "'/><input type='submit' name='ab' value='Print'/></form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "<b class='blue'><big>Net charges : ";
    $net = $charges_total - $sell_det[0][2];
    echo money($net);
    echo "</big></b>";
    echo "</div><br/>";
}
echo "<h1>Grand Total : " . money($grand_total) . "</h1>";
echo "<br/><img src='images/blank1by1.gif'  alt='Blank' onload='hideAllButZero(" . count($purchase_ids) . ")' class='rightflotingnoborder'>";
echo "<a  class='button' id='showAll' onClick='showAll()'> Expand All </a> <a  class='button' id='hideAll' onClick='hideAll()'> Minimize All </a><br/>";
