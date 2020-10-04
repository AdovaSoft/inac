<h1>Particular Product Overview</h1>
<br/>
<?php
$id = $inp->value_pgd('id');
echo "<form method = 'POST'  class='embossed'>";
$product = $qur->get_custom_select_query('SELECT idproduct, name FROM product LEFT JOIN product_details USING (idproduct);', 2);
echo "<h4 class='blue'>Select Product</h4><br/>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
if (isset($id)) {
    $qur->get_dropdown_array($product, 0, 1, 'id', $id);
} else {
    $qur->get_dropdown_array($product, 0, 1, 'id', null);
}
echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
echo "</form><br/>";

if (isset($id)) {
    include("sources/inc/double_date_id.php");
    echo "<br/>";
    $info = $qur->get_particular_product_overview($id, $date1, $date2);
    $n = count($info);
    if ($n > 0) {
        $qun = 0;
        $cos = 0;
        echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=particular_product&&date1=" . $date1 . "&&date2=" . $date2 . "&&id=" . $id . "' class='button' target='_blank'><b> Print </b></a><br/>";

        echo "<h3 class='green'>Current Stock : " . $qur->current_stock($id) . "</h3>";

        echo "<br/><table align='center' class='rb'>";
        echo "<tr>";
        echo "<td>";
        echo "Date";
        echo "</td>";
        echo "<td>";
        echo "Party";
        echo "</td>";
        echo "<td>";
        echo "Quantity";
        echo "</td>";
        echo "<td>";
        echo "Price";
        echo "</td>";
        echo "<td>";
        echo "Total";
        echo "</td>";
        echo "</tr>";
        foreach ($info as $i) {
            echo "<tr>";
            echo "<td>";
            echo $inp->date_convert($i[0]);
            echo "</td>";

            echo "<td>";
            echo $i[1];
            echo "</td>";

            echo "<td>";
            echo $i[2];
            $qun += $i[2];
            echo "</td>";

            echo "<td>";
            echo money($i[3]);

            echo "</td>";

            echo "<td>";
            echo money($i[2] * $i[3]);
            $cos += $i[2] * $i[3];
            echo "</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td colspan = 2>";
        echo "Total ";
        echo "</td>";
        echo "<td ><b>";
        echo $qun;
        echo "</b></td>";
        echo "<td> </td>";
        echo "<td><b>" . money($cos) . "</b></td>";
        echo "</tr>";
        echo "</table>";
        echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=particular_product&&date1=" . $date1 . "&&date2=" . $date2 . "&&id=" . $id . "' class='button' target='_blank'><b> Print </b></a>";
    } else {
        echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
    }

}

?>