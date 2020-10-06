<h1>Datewise Stock Report</h1>
<?php
include("sources/inc/print/double_date.php");

$query = sprintf("SELECT date,name,stock, unite,price,type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY date DESC;", $date1, $date2);
$info = $qur->get_custom_select_query($query, 6);
$n = count($info);
$tti = $tto = 0;
$tti_p = 0;
if ($n > 0) {
    echo "<small>Report according to date " . date("d M Y (D)") . "</small><br/>";
    echo "<br/><table align='center' class='rb'>";
    echo "<tr>";
    echo "<td>";
    echo "Date";
    echo "</td>";

    echo "<td>";
    echo "Product";
    echo "</td>";

    echo "<td>";
    echo "Price (TK)";
    echo "</td>";


    echo "<td>";
    echo "Incomming";
    echo "</td>";

    echo "<td>";
    echo "Outgoing";
    echo "</td>";

    echo "<td>";
    echo "Unit";
    echo "</td>";

    echo "<td>";
    echo "Total Price";
    echo "</td>";

    echo "<td>";
    echo "Remark";
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
        echo $i[4];
        echo "</td>";

        if ($i[2] > 0) {
            echo "<td>";
            echo $i[2];
            if ($i[5] == 0 || $i[5] == 1)
                $tti_p += $i[2];

            echo "</td>";
            echo "<td>";
            if ($i[5] == 0 || $i[5] == 1) {
                echo "-";
            } else {
                echo $i[2];
            }
            echo "</td>";
        } else {
            echo "<td>";
            if ($i[5] == 0 || $i[5] == 1) {
                echo "-";
            } else {
                echo $i[2];
            }
            echo "</td>";
            echo "<td>";
            echo(-$i[2]);
            if ($i[5] == 0 || $i[5] == 1)
                $tto_p = $tto + (-$i[2]);
            echo "</td>";
        }

        echo "<td>";
        echo $i[3];
        echo "</td>";
        $ss = $i[2] * $i[4];
        if ($ss > 0) {
            $tti += $ss;
            echo "<th class='green'>" . $ss . "</th>";
        } else {
            $tto += $ss;
            echo "<th class='red'>" . (-$ss) . "</th>";
        }
        echo "<td>";

        if ($i[5] == 0) {
            echo "Godown";
        }
        if ($i[5] == 1) {
            echo "Factory";
        }
        if ($i[5] == 2) {
            echo "Factory to godown";
        }
        if ($i[5] == 3) {
            echo "Godown to factory";
        }
        echo "</td>";

        echo "</tr>";
    }
    echo "<tr><th colspan='3'>Total Incoming : " . $tti . " TK</th><th colspan='3'>Total Outgoing : " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
    echo "</table>";
    echo "<br/><small>Report according to price of date " . date("d M Y (D)") . "</small>";
} else {
    echo "<br/><h2 class='blue'>No input or output between $date1 and $date2</h2>";
}
