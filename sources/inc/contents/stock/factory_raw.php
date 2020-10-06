<h1>Factory Raw Materials Stock Report</h1>
<br/>
<?php
$query = sprintf("SELECT name, factory_stock, unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details WHERE purchase = 1 ) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");
$qur = new indquery();
$info = $qur->get_custom_select_query($query, 5);
$cost = 0;

echo "<br/>Click on the names to view Particular Sales or Purchase Report of last month.<br/><br/>";

if (count($info) > 0) {
    echo "<table class='rb table'>";
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
        echo $ar[0];
        echo "</a>";
        echo "</th>";

        echo "<td>";
        echo $ar[1];
        echo "</td>";

        echo "<td>";
        echo $ar[2];
        echo "</td>";

        echo "<td>";
        echo money($ar[3]);
        echo "</td>";


        echo "<td>";
        $total = $ar[3] * $ar[1];
        echo money($total);
        $cost += $ar[3] * $ar[1];
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";

    /*echo "<tr>";
    echo "<th colspan = '4' >";
    echo "Grand Total : ";
    echo "</th>";

    echo "<td >";
    echo $cost;
    echo "</td>";
    echo "</tr>";
    */

    echo "</table><br/>";
    echo "<a id='printBox'  href='print.php?e=" . $encptid . "&page=stock&&sub=factory_raw' class='button' target='_blank'><b> Print </b></a>";
} else {
    echo "No raw mattarials is in stock";
}

?>
