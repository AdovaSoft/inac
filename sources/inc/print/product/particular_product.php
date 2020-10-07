<h1>Particular Product Overview</h1>
<?php
$id = $inp->value_pgd('id');
include("sources/inc/print/double_date.php");
$info = $qur->get_particular_product_overview($id, $date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
    echo "<h3>Current Stock : " . $qur->current_stock($id) . "</h3>";
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
        $total = $i[2] * $i[3];
        echo money($total);
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
}
?>