<h1>All Stock Report</h1>
<br/>
<?php
$query = sprintf("SELECT name, stock, factory_stock,unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");

$info = $qur->get_custom_select_query($query, 6);
$cost = 0;
echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=stock&sub=all' class='button' target='_blank'><b> Print </b></a>";
echo "<br/>Click on the names to view Particular Sales or Purchase Report of last month.<br/><br/>";
if (count($info) > 0) {
    echo "<br/><table class='rb table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>";
    echo "Name";
    echo "</th>";

    echo "<th>";
    echo "Godown";
    echo "</th>";


    echo "<th>";
    echo "Factory";
    echo "</th>";
    echo "<th>";
    echo "Total Stock";
    echo "</th>";

    echo "<th>";
    echo "Unit";
    echo "</th>";

    echo "<th>";
    echo "Price";
    echo "</th>";


    echo "<th>";
    echo "Total Price";
    echo "</th>";

    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($info as $product) {
        echo "<tr>";
        echo "<th>";
        echo "<a href='index.php?e=" . $encptid . "&page=product&sub=particular_product&id=" . $product[5] . "'>";
        echo esc($product[0]);
        echo "</a>";
        echo "</th>";

        echo "<td>";
        echo esc($product[1]);
        echo "</td>";


        echo "<td>";
        echo esc($product[2]);
        echo "</td>";

        echo "<td>";
        echo $product[1] + $product[2];
        echo "</td>";

        echo "<td>";
        echo esc($product[3]);
        echo "</td>";

        echo "<td class='text-right pr-50'>";
        echo money($product[4]);
        echo "</td>";


        echo "<td class='text-right pr-50'>";
        $total = (($product[1] + $product[2]) * $product[4]);
        echo money($total);
        $cost += ($product[1] + $product[2]) * $product[4];
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    /*
        echo "<tr>";
        echo "<th colspan = '6' >";
        echo "Grand Total : ";
        echo "</th>";

        echo "<td >";
        echo $cost;
        echo "</td>";
        echo "</tr>";*/

    echo "</table><br/>";
} else {
    echo "<br/><h3>No raw materials is in stock</h3>";
}


?>
