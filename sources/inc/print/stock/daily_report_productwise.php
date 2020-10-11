<h2>Date wise Stock Report</h2>
<?php
include("sources/inc/print/single_date.php");
$query = sprintf("SELECT date,name,stock,unite,price, type FROM (SELECT * FROM product_input WHERE date = '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY name, date DESC;", $date);
$info = $qur->get_custom_select_query($query, 6);
$n = count($info);
$tti_p = $tto_p =  $product_trac = 0;
$tti = $tto = 0;
$tto_o = 0;
if ($n > 0) {
    echo "<h2>Grouped Product wise</h2>";
    echo "<small>Report according to price of date " . date("d M Y (D)") . "</small><br/>";
    $first_product = $info[0][1];
    foreach ($info as $i) {
        if ($product_trac != $i[1]) {

            if ($i[1] != $first_product) {
                echo "<tr>";
                echo "<th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th>";
                echo "<th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th>";
                echo "<th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
                echo "</table><br/>";
                $tti_p = $tto_p = 0;
                $tti = $tto = 0;
            }
            echo "<h3>" . $i[1] . "</h3>";
            echo "<table align='center' class='rb'>";
            echo "<tr>";

            echo "<th>";
            echo "Date";
            echo "</th>";

            echo "<th>";
            echo "Product";
            echo "</th>";

            echo "<th>";
            echo "Price (TK)";
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
            echo "Total Price (TK)";
            echo "</th>";

            echo "<th>";
            echo "Remark";
            echo "</th>";

            echo "</tr>";


            echo "<tr>";
            echo "<td>";
            echo $inp->date_convert($i[0]);
            echo "</td>";

            echo "<td>";
            echo $i[1];
            echo "</td>";

            echo "<td class='text-right'>";
            echo money($i[4]);
            echo "</td>";

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
            echo $i[3];
            echo "</td>";

            $ss = $i[2] * $i[4];
            if ($ss > 0) {
                $tti += $ss;
                echo "<td class='text-right'>" . money($ss) . "</td>";
            } else {
                $tto += $ss;
                $ss = -$ss;
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
        } else {

            echo "<tr>";

            echo "<td>";
            echo $inp->date_convert($i[0]);
            echo "</td>";

            echo "<td>";
            echo $i[1];
            echo "</td>";

            echo "<td class='text-right'>";
            echo money($i[4]);
            echo "</td>";

            if ($i[2] > 0) {

                echo "<td>";
                echo $i[2];
                echo "</td>";
                if ($i[5] == 0 || $i[5] == 1) $tti_p = $tti_p + $i[2];


                if ($i[5] == 0 || $i[5] == 1) {
                    echo "<td>";
                    echo "-";
                    echo "</td>";
                } else {
                    echo "<td>";
                    echo $i[2];
                    echo "</td>";
                }
            } else {
                if ($i[5] == 0 || $i[5] == 1) {
                    echo "<td>";
                    echo "-";
                    echo "</td>";
                } else {
                    echo "<td>";
                    echo $i[2];
                    echo "</td>";
                }
                
                echo "<td>";
                echo (-$i[2]);
                echo "</td>";
                if ($i[5] == 0 || $i[5] == 1) $tto_p = $tto_o + (-$i[2]);
            }

            echo "<td>";
            echo $i[3];
            echo "</td>";
            $ss = $i[2] * $i[4];
            if ($ss > 0) {
                $tti += $ss;
                echo "<td class='text-right'>" . money($ss) . "</td>";
            } else {
                $tto += $ss;
                $ss = -$ss;
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
        $product_trac = $i[1];
        $price_trac = $i[4];
        $unit_trac = $i[3];
    }
    echo "<tr><th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th><th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
    echo "</table><br/>";
} else {
    echo "<br/><h2 class='blue'>No input or output between " . convert_date($date) . " and " . convert_date($date) . "</h2>";
}

?>