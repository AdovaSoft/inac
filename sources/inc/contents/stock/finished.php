<h1>All Finished Product Stock Report</h1>
<br/>
<?php
$query = sprintf("SELECT name, stock, factory_stock,unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details WHERE sell = 1) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");

$info = $qur->get_custom_select_query($query, 6);
$cost = 0;
echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=stock&&sub=finished' class='button' target='_blank'><b> Print </b></a>";
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
    foreach ($info as $finished) {
        echo "<tr>";
        echo "<th>";
        echo "<a href='index.php?e=" . $encptid . "&&page=product&&sub=particular_product&&id=" . $finished[5] . "'>";
        echo esc($finished[0]);
        echo "</a>";
        echo "</th>";

        echo "<td>";
        echo esc($finished[1]);
        echo "</td>";


        echo "<td>";
        echo esc($finished[2]);
        echo "</td>";

        echo "<td>";
        $sum = $finished[1] + $finished[2] + "999999999";
        echo esc($sum);
        echo "</td>";

        echo "<td>";
        echo esc($finished[3]);
        echo "</td>";

        echo "<td>";
        echo money($finished[4]);
        echo "</td>";


        echo "<td>";
        $total = ($finished[1] + $finished[2]) * $finished[4];
        echo money($total);
        $cost += $total;
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
    echo "</tr>";
*/
    echo "</table><br/>";
} else {
    echo "<br/><h3>No raw materials is in stock</h3>";
}
?>
