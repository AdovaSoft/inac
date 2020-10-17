<h1>Factory All Stock Report</h1>
<br/>
<?php
$query = sprintf("SELECT name, factory_stock, unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");

$info = $qur->get_custom_select_query($query, 5);
$cost = 0;
echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=stock&&sub=factory_all' class='button' target='_blank'><b> Print </b></a>";
echo "<br/>Click on the names to view Particular Sales or Purchase Report of last month.<br/><br/>";
if (count($info) > 0) {
    echo "<br/><table class='rb table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>";
    echo "Name";
    echo "</th>";

    echo "<th>";
    echo "Stock";
    echo "</th>";

    echo "<th>";
    echo "Unit";
    echo "</th>";

    echo "<th>";
    echo "Price";
    echo "</th>";


    echo "<th>";
    echo "Total";
    echo "</th>";

    echo "</tr>";
    echo "</thead>";

    echo "<tbody>";
    foreach ($info as $ar) {
        echo "<tr>";
        echo "<th>";
        echo "<a href='index.php?e=" . $encptid . "&&page=product&&sub=particular_product&&id=" . $ar[4] . "'>";
        echo esc($ar[0]);
        echo "</a>";
        echo "</th>";

        echo "<td>";
        echo money($ar[1]);
        echo "</td>";

        echo "<td>";
        echo esc($ar[2]);
        echo "</td>";

        echo "<td>";
        echo money($ar[3]);
        echo "</td>";


        echo "<td>";
        $mul = $ar[3] * $ar[1];
        echo money($mul);
        $cost += $mul;
        echo "</td>";
        echo "</tr>";
    }
    echo "<tbody>";

    /* echo "<tr>";
    echo "<th colspan = '4' >";
    echo "Grand Total : ";
    echo "</th>";

    echo "<td >";
    echo $cost;
    echo "</td>";
    echo "</tr>"; */

    echo "</table><br/>";
} else {
    echo "<br/><h3>No raw materials is in stock</h3>";
}


?>
