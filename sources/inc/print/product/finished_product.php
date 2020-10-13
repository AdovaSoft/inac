<h2>Finished Product Sell Overview</h2>
<?php
include("sources/inc/print/double_date.php");
$info = $qur->get_finished_product_overview($date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $totalRate = 0;
    echo "<table align='center' class='rb'>";
    echo "<tr>";
    echo "<th>";
    echo "Date";
    echo "</th>";
    echo "<th>";
    echo "Party";
    echo "</th>";
    echo "<th>";
    echo "Product";
    echo "</th>";
    echo "<th>";
    echo "Number";
    echo "</th>";
    echo "<th>";
    echo "Unit";
    echo "</th>";
    echo "<th>";
    echo "Rate";
    echo "</th>";
    echo "</tr>";
    foreach ($info as $i) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($i[0]);
        echo "</td>";

        echo "<td>";
        echo esc($i[1]);
        echo "</td>";

        echo "<td>";
        echo esc($i[2]);
        echo "</td>";
        echo "<td>";
        echo esc($i[3]);
        $qun += $i[3];
        echo "</td>";
        echo "<td>";
        echo esc($i[4]);
        echo "</td>";
        echo "<td>";
        echo money($i[5]);
        $totalRate += $i[5];
        echo "</td>";

        echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan = 3>";
    echo "Total ";
    echo "</td>";
    echo "<td ><b>";
    echo $qun;
    echo "</b></td>";
    echo "<td> </td>";
    echo "<td><b>" . money($totalRate) . "</b></td>";
    echo "</tr>";
    echo "</table>";
}
?>