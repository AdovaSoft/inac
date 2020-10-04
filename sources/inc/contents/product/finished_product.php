<h1>Finished Product Sell Overview</h1>
<br/>
<?php
include("sources/inc/double_date_id.php");
$info = $qur->get_finished_product_overview($date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=finished_product&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a><br/>";
    echo "<table align='center' class='rb'>";
    echo "<tr>";
    echo "<td>";
    echo "Date";
    echo "</td>";
    echo "<td>";
    echo "Party";
    echo "</td>";
    echo "<td>";
    echo "Product";
    echo "</td>";
    echo "<td>";
    echo "Number";
    echo "</td>";
    echo "<td>";
    echo "Unite name";
    echo "</td>";
    echo "<td>";
    echo "Rate";
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
        echo "</td>";
        echo "<td>";
        echo $i[3];
        echo "</td>";
        echo "<td>";
        echo $i[4];
        echo "</td>";
        echo "<td>";
        echo $i[5];
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
    echo "<td><b>" . $cos . "</b></td>";
    echo "<td> </td>";
    echo "</tr>";
    echo "</table>";
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=finished_product&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";
} else {
    echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
}
?>