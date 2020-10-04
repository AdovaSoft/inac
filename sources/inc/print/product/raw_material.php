<h1>Raw Material Purchase Overview</h1>
<?php
include("sources/inc/print/double_date.php");
$info = $qur->get_raw_product_overview($date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
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
    echo "Unit";
    echo "</td>";
    echo "<td>";
    echo "Rate";
    echo "</td>";
    echo "<td>";
    echo "Total";
    echo "</td>";
    echo "</tr>";
    foreach ($info as $item) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($item[0]);
        echo "</td>";
        echo "<td>";
        echo isset($item[1]) ? $item[1] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[2]) ? $item[2] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[3]) ? $item[3] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[4]) ? $item[4] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[5]) ? money($item[5]) : '-';
        echo "</td>";
        echo "<td>";
        if (isset($item[5]) && isset($item[3])) {
            $temp = $item[5] * $item[3];
            $cos += $temp;
            echo money($temp);
        } else
            echo '-';

        echo "</td>";
        echo "</tr>";

    }
    echo "<tr>";
    echo "<td colspan ='3'>";
    echo "Total ";
    echo "</td>";
    echo "<td><b>";
    echo $qun;
    echo "</b></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>" . money($cos) . "</b></td>";
    echo "</tr>";
    echo "</table>";
}
?>