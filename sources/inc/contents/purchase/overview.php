<h2>Purchase Overview</h2>
<br/>
<?php
    echo "<div id='sud3'><form method = 'POST'  class='embossed'>";
    echo "<h4 class='blue'>Select Purchase Supplier Voucher</h4><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $qur->get_drop_down('purchase_recipt', 'recipt', 'idpurchase', 'id', $inp->value_pgd('id'), 'full-width');
    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form></div>";
    
    $vou = $inp->value_pgd('id');;
    $query_recept = sprintf("SELECT recipt FROM purchase_recipt WHERE idpurchase = '%s'", $vou);
    $recept = $qur->get_custom_select_query($query_recept, 1);
    $query_pro = sprintf("SELECT idproduct, p.unite, rate, name, mesurment_unite.unite FROM (SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM purchase_details WHERE idpurchase = %d) as purchase LEFT JOIN product USING (idproduct)) as p LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite);", $vou);
    $sell_pro = $qur->get_custom_select_query($query_pro, 5);
    $query_det = sprintf("SELECT name,date,discount FROM (SELECT * FROM purchase s WHERE idpurchase = %d) as purchase LEFT JOIN purchase_discount USING (idpurchase) LEFT JOIN party USING (idparty);", $vou);
    $sell_det = $qur->get_custom_select_query($query_det, 3);
    $n = count($sell_pro);
    echo "<a class='button'>";
    echo "Voucher : " . $vou;
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplier Voucher : " . $recept[0][0];
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchased From : ";
    echo "<b class='blue'>" . $sell_det[0][0] . "</b>";
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
        echo " ";
        echo esc($sell_pro[$j][4]);
        echo "</td>";
        echo "<td>";
        echo esc($sell_pro[$j][2]);
        echo "</td>";
        echo "<td>";
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
    echo "<td class='blue'>";
    echo money($charges_total);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='3'>";
    echo "Discount:";
    echo "</td>";
    echo "<td class='blue'>";
    echo money($sell_det[0][2]);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='3'>";
    echo "Net charges:";
    echo "</td>";
    echo "<td class='blue'>";
    $net = $charges_total - $sell_det[0][2];
    echo money($net);
    echo "</td>";
    echo "</tr>";
    if ($usertype == ADMIN) {
        echo "<tr>";
        echo "<td colspan='4'>";
        echo "<form method='POST'><input type='hidden' name='pur_id' value='" . $vou . "'/><input type='submit' name='delete' value='Delete'/></form> ";
        echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=purchase&&sub=return'><input type='hidden' name='v' value='" . $vou . "'/><input type='submit' name='ab' value='Edit'/></form>";
        echo "<form method='POST' action='print.php?e=" . $encptid . "&&page=purchase&&sub=purchase' target='_blank'>
                <input type='hidden' name='id' value='" . $vou . "'/>
                <input type='submit' name='ab' value='Print'/></form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "</div><br/>";