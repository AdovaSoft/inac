<h1>Date wise Stock Report</h1>
<br/>
<?php

include("sources/inc/double_date.php");

//Grouped Productwise
if (isset($_GET['group']) && $_GET['group'] == 1) {
    $group = $_GET['group'];
    $query = sprintf("SELECT date,name,stock,unite,price, type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY name, date DESC;", $date1, $date2);
    $info = $qur->get_custom_select_query($query, 6);
    $n = count($info);
    $tti_p = $tto_p = 0;
    $tti = $tto = 0;
    if ($n > 0) {
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button'><b> Show Just Datewise </b></a>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&date1=" . $date1 . "&&date2=" . $date2 . "&&group=2' class='button'><b> Group Unitwise </b></a>";
        echo "<br/><a id='printBox'  href='print.php?e=" . $encptid . "&page=stock&&sub=date_report_productwise&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";
        echo "<br/><h2>Grouped Product Wise</h2><br/>";
        //echo "<small>Report according to price of date " . date("d M Y (D)") . "</small><br/>";
        $first_product = $info[0][1];
        $product_trac = null;
        $unit_trac = null;
        foreach ($info as $i) {
            if ($product_trac != $i[1]) {
                if ($i[1] != $first_product) {
                    echo "<tr>
                    <th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th>
                    <th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th>
                    <th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th>
                    </tr>";
                    echo "</table><br/>";
                    $tti_p = $tto_p = 0;
                    $tti = $tto = 0;
                }
                echo "<h3>" . $i[1] . "</h3>";
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
                echo "Total Price (TK)";
                echo "</td>";
                echo "<td>";
                echo "Remark";
                echo "</td>";
                echo "</tr>";

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
                        $tto_p = $tto_o + (-$i[2]);
                    echo "</td>";
                }
                echo "<td>";
                echo $i[3];
                echo "</td>";
                $ss = $i[2] * $i[4];
                if ($ss > 0) {
                    $tti += $ss;
                    if ($i[5] == 0 || $i[5] == 1)
                        echo "<th class='green'>" . $ss . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
                } else {
                    $tto += $ss;
                    if ($i[5] == 0 || $i[5] == 1)
                        echo "<th class='red'>" . (-$ss) . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
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
                echo "<td>";
                echo $i[4];
                echo "</td>";
                if ($i[2] > 0) {
                    echo "<td>";
                    echo $i[2];
                    if ($i[5] == 0 || $i[5] == 1)
                        $tti_p = $tti_p + $i[2];

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
                        $tto_p = $tto_o + (-$i[2]);
                    echo "</td>";
                }

                echo "<td>";
                echo $i[3];
                echo "</td>";
                $ss = $i[2] * $i[4];
                if ($ss > 0) {
                    $tti += $ss;
                    if ($i[5] == 0 || $i[5] == 1)
                        echo "<th class='green'>" . $ss . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
                } else {
                    $tto += $ss;
                    if ($i[5] == 0 || $i[5] == 1)
                        echo "<th class='red'>" . (-$ss) . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
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
        echo "<br/><small>Report according to price of date " . date("d M Y (D)") . "</small>";
    } else {
        echo "<br/><h2 class='blue'>No input or output between " . $inp->date_convert($date1) . " and " . $inp->date_convert($date2) . "</h2>";
    }
}

//Grouped Unitwise
elseif (isset($_GET['group']) && $_GET['group'] == 2) {
    $group = $_GET['group'];
    $query = sprintf("SELECT date,name,stock,unite,price,type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY unite, date DESC;", $date1, $date2);
    $unit_stock_list = $qur->get_custom_select_query($query, 6);
    $n = count($unit_stock_list);
    $tti_p = $tto_p = 0;
    $tti = $tto = 0;
    if ($n > 0) {
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button'><b> Show Just Date wise </b></a>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&group=1&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button'><b> Group Product wise </b></a>";
        echo "<br/><a id='printBox'  href='print.php?e=" . $encptid . "&page=stock&&sub=date_report_unitwise&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";

        echo "<br/><h2>Grouped Unit wise</h2><br/>";
        //echo "<small>Report according to price of date " . date("d M Y (D)") . "</small><br/>";
        $first_unit = $unit_stock_list[0][3];
        $unit_trac = 0;
        $unit_wise_stocks = array();

        for($i = 0;  $i < count($unit_stock_list); $i++) {
            $unit_index = $unit_stock_list[$i][3];
            $unit_wise_stocks[$unit_index][$i] = $unit_stock_list[$i];
        }

foreach ($unit_wise_stocks as $unit => $item) {
    echo "<br><h3>" . $unit . "</h3>";
    echo "<br/> <table align='center' class='rb'>";
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
    echo "Incoming";
    echo "</td>";
    echo "<td>";
    echo "Outgoing";
    echo "</td>";
    echo "<td>";
    echo "Unit";
    echo "</td>";
    echo "<td>";
    echo "Total Price (TK)";
    echo "</td>";
    echo "<td>";
    echo "Remark";
    echo "</td>";
    echo "</tr>";

    $tti_p = 0;

    foreach ($item as $stock) {
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
                $tti_p += $stock[2];
            echo "</td>";
            echo "<td>";
            if ($stock[5] == 0 || $stock[5] == 1) {
                echo "-";
            } else {
                echo $stock[2];
            }
            echo "</td>";
        }
        else {
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
                echo "<th class='green'>" . $ss . "</th>";
            else
                echo "<th class='blue'>" . $ss . "</th>";
        }
        else {
            $tto += $ss;
            if ($stock[5] == 0 || $stock[5] == 1)
                echo "<th class='red'>" . (-$ss) . "</th>";
            else
                echo "<th class='blue'>" . $ss . "</th>";
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
    }
    echo "<tr><th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th><th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
    echo "</table><br/>";
}

            if ($unit_trac != $stock[3]) {
                /*if ($stock[3] != $first_unit) {

                    echo "<tr>
                      <th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th>
                      <th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th>
                      <th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th>
                    </tr>";
                    echo "</table><br/>";
                    $tti_p = $tto_p = 0;
                    $tti = $tto = 0;

                }
                */





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
                }
                else {
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
                        echo "<th class='green'>" . $ss . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
                }
                else {
                    $tto += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1)
                        echo "<th class='red'>" . (-$ss) . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
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
            }
            else {
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
                        echo "<th class='green'>" . $ss . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
                } else {
                    $tto += $ss;
                    if ($stock[5] == 0 || $stock[5] == 1)
                        echo "<th class='red'>" . (-$ss) . "</th>";
                    else
                        echo "<th class='blue'>" . $ss . "</th>";
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
        //}
        echo "<tr><th colspan='3'>Total Incoming : <br/> " . $tti_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . $tti . " TK</th><th colspan='3'>Total Outgoing : <br/>" . $tto_p . " " . $unit_trac . "<b class='blue'> X </b>" . $price_trac . " TK <b class='blue'>=</b> " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
        echo "</table><br/>";
        //echo "<br/><small>Report according to price of date " . date("d M Y (D)") . "</small>";
    } else {
        echo "<br/><h2 class='blue'>No input or output between $date1 and $date2</h2>";
    }
}

//Group Date wise
else {
    $query = sprintf("SELECT date,name,stock, unite,price,type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY date DESC;", $date1, $date2);
    $info = $qur->get_custom_select_query($query, 6);
    $n = count($info);
    $tti = $tto = 0;
    if ($n > 0) {
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&group=1&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button'><b> Group Productwise </b></a>";
        echo "<a href='index.php?e=" . $encptid . "&page=stock&&sub=date_report&&date1=" . $date1 . "&&date2=" . $date2 . "&&group=2' class='button'><b> Group Unitwise </b></a>";
        echo "<br/><a id='printBox'  href='print.php?e=" . $encptid . "&page=stock&&sub=date_report&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";
        echo "<br/><small>Report according to date " . date("d M Y (D)") . "</small><br/>";
        echo "<br/><table align='center' class='rb'>";
        echo "<tr>";
        echo "<td>";
        echo "Date";
        echo "</td>";

        echo "<td>";
        echo "Product";
        echo "</td>";

        echo "<td>";
        echo "Price";
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
        echo "Total Price (TK)";
        echo "</td>";

        echo "<td>";
        echo "Remark";
        echo "</td>";
        echo "</tr>";

        foreach ($info as $stock) {
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
                    $tti += $stock[2];

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
                    $tto_p += (-$stock[2]);
                echo "</td>";
            }

            echo "<td>";
            echo $stock[3];
            echo "</td>";
            $ss = $stock[2] * $stock[4];
            if ($ss > 0) {
                $tti += $ss;
                if ($stock[5] == 0 || $stock[5] == 1)
                    echo "<th class='green'>" . $ss . "</th>";
                else
                    echo "<th class='blue'>" . $ss . "</th>";
            } else {
                $tto += $ss;
                if ($stock[5] == 0 || $stock[5] == 1)
                    echo "<th class='red'>" . (-$ss) . "</th>";
                else
                    echo "<th class='blue'>" . $ss . "</th>";
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
        }
        echo "<tr><th colspan='3'>Total Incoming : " . $tti . " TK</th><th colspan='3'>Total Outgoing : " . -$tto . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . ($tti + $tto) . " TK</th></tr>";
        echo "</table>";
        echo "<br/><small>Report according to price of date " . date("d M Y (D)") . "</small>";
    } else {
        echo "<br/><h2 class='blue'>No input or output between $date1 and $date2</h2>";
    }
}


?>