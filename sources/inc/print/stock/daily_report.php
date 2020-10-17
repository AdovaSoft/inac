<h2>Daily Stock Report</h2>
<?php

include("sources/inc/print/single_date.php");
$query = sprintf("SELECT date,name,stock, unite,price,type FROM (SELECT * FROM product_input WHERE date = '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY date DESC;", $date);
$info = $qur->get_custom_select_query($query, 6);
$n = count($info);
$tti = $tto = 0;
$tto_p = $tto_o = 0;
if ($n > 0) {
    // echo "<small>Report according to date " . date("d M Y (D)") . "</small><br/><br/>";
    echo "<table align='center' class='rb'>";
    echo "<tr>";

    echo "<th>SI</th>";

    echo "<th>";
    echo "Date";
    echo "</th>";

    echo "<th>";
    echo "Product";
    echo "</th>";

    echo "<th>";
    echo "Price ";
    echo "</th>";


    echo "<th>";
    echo "Incoming";
    echo "</th>";

    echo "<th>";
    echo "Outgoing";
    echo "</th>";

    echo "<th>";
    echo "Unit";
    echo "</th>";

    echo "<th>";
    echo "Total Price";
    echo "</th>";

    echo "<th>";
    echo "Remark";
    echo "</th>";
    echo "</tr>";

    $j = 1;
    foreach ($info as $i) {
        echo "<tr>";

        echo "<td>" . $j++ . "</td>";

        echo "<td>";
        echo $inp->date_convert($i[0]);
        echo "</td>";

        echo "<td>";
        echo $i[1];
        echo "</td>";

        echo "<td class='text-right'>";
        echo money($i[4]);
        echo "</td>";

        $tti_p = 0;
        if ($i[2] > 0) {

            echo "<td>";
            echo esc($i[2]);
            echo "</td>";
            if ($i[5] == 0 || $i[5] == 1) $tti_p = $tti_p + $i[2];

            if ($i[5] == 0 || $i[5] == 1) {
                echo "<td>";
                echo "-";
                echo "</td>";
            } else {
                echo "<td>";
                echo esc($i[2]);
                echo "</td>";
            }
        } else {

            if ($i[5] == 0 || $i[5] == 1) {
                echo "<td>";
                echo "-";
                echo "</td>";
            } else {
                echo "<td>";
                echo esc($i[2]);
                echo "</td>";
            }

            $i[2] = -$i[2];
            echo "<td>";
            echo esc($i[2]);
            echo "</td>";
            if ($i[5] == 0 || $i[5] == 1) $tto_p = $tto_o + $i[2];
        }

        echo "<td>";
        echo esc($i[3]);
        echo "</td>";

        $ss = $i[2] * $i[4];
        if ($ss > 0) {
            $tti += $ss;
            echo "<td class='text-right'>" . money($ss) . "</td>";
        } else {
            $tto += $ss;
            $ss *= (-1);
            echo "<td class='text-right'>" . money($ss) . "</td>";
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
    $total = $tti + $tto;
    $tto *= (-1);
    echo "<tr>";
    echo "<th colspan='4'>Total Incoming : " . money($tti) . " TK</th>";
    echo "<th colspan='3'>Total Outgoing : " . money($tto) . " TK</th>";
    echo "<th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . money($total) . " TK</th>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<br/><h2 class='blue'>No input or output in " . $inp->date_convert($date) . " date</h2>";
}
?>