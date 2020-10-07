<h1>Godown All Stock Report</h1>
<?php
$query = sprintf("SELECT name, stock, unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");

$info = $qur->get_custom_select_query($query, 5);
$cost = 0;
if (count($info) > 0) {
    echo "<table class='rb'>";
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

    foreach ($info as $ar) {
        echo "<tr>";
        echo "<th>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
        echo $ar[0];
        echo "</a>";
        echo "</th>";

        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
        echo $ar[1];
        echo "</a>";
        echo "</td>";

        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
        echo $ar[2];
        echo "</a>";
        echo "</td>";

        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
        echo money($ar[3]);
        echo "</a>";
        echo "</td>";


        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
        $total = $ar[3] * $ar[1];
        echo money($total);
        $cost += $ar[3] * $ar[1];
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "<tr>";
    echo "<th colspan = '4' >";
    echo "Grand Total : ";
    echo "</th>";

    echo "<td >";
    echo money($cost);
    echo "</td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "<br/><h3>No raw materials is in stock</h3>";
}

?>