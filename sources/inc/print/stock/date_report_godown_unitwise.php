<h2>Date wise Godown Stock Report</h2>
<?php
    include("sources/inc/print/double_date.php");
    $query = sprintf("SELECT date,name,stock,unite,price,type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' AND (type='0' OR type='2') ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY unite, date DESC;", $date1, $date2);
    $info = $qur->get_custom_select_query($query, 6);
    $info = $qur->get_custom_select_query($query, 6);
    $n = count($info);
    $tti_p = $tto_p = 0;
    $tti = $tto = 0;
    if ($n > 0) {
        echo "<h2>Grouped Unit wise</h2>";
        echo "<small>Report according to price of date " . date("d M Y (D)") . "</small><br/>";
        $first_unit = $info[0][3];
        
        $product_trac = null;
        $unit_trac = null;
        $price_trac = null;
        
        $first_unit = $info[0][3];
        $unit_trac = array();
        $tto_o = 0;
        foreach ($info as $stock) {
            if ($unit_trac != $stock[3]) {
                if ($stock[3] != $first_unit) {
                    echo "</tbody><tr><th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th><th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
                    echo "</table>";
                    $tti_p = $tto_p = 0;
                    $tti = $tto = 0;
                }
                echo "<h3>" . $stock[3] . "</h3>";
                echo "<table align='center' class='rb table'>";
                echo "<thead>";
                echo "<tr>";
                
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
                echo "Total Price ";
                echo "</th>";
                
                echo "<th>";
                echo "Remark";
                echo "</th>";
                
                echo "</tr>";
                echo "</thead><tbody>";
                echo "<tr>";
                echo "<td>";
                echo $inp->date_convert($stock[0]);
                echo "</td>";
                
                echo "<td>";
                echo $stock[1];
                echo "</td>";
                
                echo "<td>";
                echo $stock[4];
                echo "</td>";
                
                if ($stock[2] > 0) {
                    echo "<td>";
                    echo $stock[2];
                    if ($stock[5] == 0 || $stock[5] == 1)
                        $tti_p = $tti_p + $stock[2];
                    
                    echo "</td>";
                    
                    echo "<td>";
                    if ($stock[5] == 0 || $stock[5] == 1) {
                        echo "-";
                    } else {
                        echo $stock[2];
                    }
                    
                    echo "</td>";
                } else {
                    
                    echo "<td>";
                    if ($stock[5] == 0 || $stock[5] == 1) {
                        echo "-";
                    } else {
                        echo $stock[2];
                    }
                    echo "</td>";
                    
                    echo "<td>";
                    echo(-$stock[2]);
                    if ($stock[5] == 0 || $stock[5] == 1)
                        $tto_p = $tto_o + (-$stock[2]);
                    echo "</td>";
                }
                
                echo "<td>";
                echo $stock[3];
                echo "</td>";
                
                $ss = $stock[2] * $stock[4];
                if ($ss > 0) {
                    $tti += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1)
                        echo "<td class='green'>" . money($ss) . "</td>";
                    else
                        echo "<td class='blue'>" . money($ss) . "</td>";
                } else {
                    $tto += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1) {
                        $ss = -$ss;
                        echo "<td class='red'>" . money($ss) . "</td>";
                    } else
                        echo "<td class='blue'>" . money($ss) . "</td>";
                }
                echo "<td>";
                
                if ($stock[5] == 0) {
                    echo "Godown";
                }
                if ($stock[5] == 1) {
                    echo "Factory";
                }
                if ($stock[5] == 2) {
                    echo "Factory to godown";
                }
                if ($stock[5] == 3) {
                    echo "Godown to factory";
                }
                echo "</td>";
                
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td>";
                echo $inp->date_convert($stock[0]);
                echo "</td>";
                echo "<td>";
                echo $stock[1];
                echo "</td>";
                echo "<td>";
                echo $stock[4];
                echo "</td>";
                if ($stock[2] > 0) {
                    echo "<td>";
                    echo $stock[2];
                    if ($stock[5] == 0 || $stock[5] == 1)
                        $tti_p = $tti_p + $stock[2];
                    echo "</td>";
                    echo "<td>";
                    if ($stock[5] == 0 || $stock[5] == 1) {
                        echo "-";
                    } else {
                        echo $stock[2];
                    }
                    echo "</td>";
                } else {
                    echo "<td>";
                    if ($stock[5] == 0 || $stock[5] == 1) {
                        echo "-";
                    } else {
                        echo $stock[2];
                    }
                    echo "</td>";
                    echo "<td>";
                    echo(-$stock[2]);
                    if ($stock[5] == 0 || $stock[5] == 1)
                        $tto_p = $tto_o + (-$stock[2]);
                    echo "</td>";
                }
                
                echo "<td>";
                echo $stock[3];
                echo "</td>";
                $ss = $stock[2] * $stock[4];
                if ($ss > 0) {
                    $tti += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1)
                        echo "<td class='green'>" . $ss . "</td>";
                    else
                        echo "<td class='blue'>" . $ss . "</td>";
                } else {
                    $tto += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1)
                        echo "<td class='red'>" . (-$ss) . "</td>";
                    else
                        echo "<td class='blue'>" . $ss . "</td>";
                }
                echo "<td>";
                if ($stock[5] == 0) {
                    echo "Godown";
                }
                if ($stock[5] == 1) {
                    echo "Factory";
                }
                if ($stock[5] == 2) {
                    echo "Factory to godown";
                }
                if ($stock[5] == 3) {
                    echo "Godown to factory ";
                }
                echo "</td>";
                
                echo "</tr>";
            }
            $product_trac = $stock[1];
            $price_trac = $stock[4];
            $unit_trac = $stock[3];
        }
        echo "</tbody>";
        echo "<tr><th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th><th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
        echo "</table>";
    } else {
        echo "<br/><h2 class='blue'>No input or output between " . convert_date($date) . " and " . convert_date($date) . "</h2>";
    }