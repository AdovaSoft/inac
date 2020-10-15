<?php
include "query.php";

/**
 * Class indquery
 */
class indquery extends query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function print_new_sales($encptid)
    {
        $inp = new html();
        $query = sprintf("SELECT idparty,name FROM (SELECT * FROM party_type WHERE type=1 OR type=2) as sel LEFT JOIN party USING(idparty) ORDER BY name");
        $party = $this->get_custom_select_query($query, 2);
        $query = sprintf("SELECT idproduct, name, unite, stock FROM (SELECT idunite, idproduct FROM product_details WHERE sell = 1) as PRO  JOIN product USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN stock USING(idproduct);;");
        $products = $this->get_custom_select_query($query, 4);

        echo "<br/>";
        echo "<form action='editor.php?e=" . $encptid ."&' method = 'POST' class='embossed'>";
        echo "<fieldset><legend>Selles Information</legend>";
        echo "<table class='centeraligned' width='100%'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td colspan='2' class='text-left'>";
        echo "Client: ";
        $this->get_dropdown_array($party, 0, 1, 'pt', $inp->value_pgd('pt'));
        echo "</td>";
        echo "<td colspan='2'> Date:  ";
        $inp->input_date('sd', date('Y-m-d'));
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>";
        echo "<br/>Product";
        echo "</th>";
        echo "<th>";
        echo "<br/>Quantity";
        echo "</th>";

        echo "<th>";
        echo "<br/>Rate";
        echo "</th>";

        echo "<th width='150'>";
        echo "<br/>Total";
        echo "</th>";
        echo "</tr>";
        echo "</thead>";
        $num = $inp->value_pgd('num', 5);
        echo "<input type = 'hidden' name = 'num' value='" . $num . "' />";
        for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            echo "<td>";
            $this->get_dropdown_array($products, 0, 1, 'pr_' . $i, $inp->value_pgd('pr_' . $i), '', true);
            echo "</td>";

            echo "<td>";
            echo $inp->input_number('', 'pc_' . $i, $inp->value_pgd('pc_' . $i), 'quantity', 'quantity_' . $i);
            // echo "<input type='number' step='any' name= value='" .  . "' class='quantity' id=/>";
            echo "</td>";

            echo "<td>";
            echo $inp->input_number('', 'co_' . $i, $inp->value_pgd('co_' . $i), 'rate', 'rate_' . $i);
            //echo "<input type='number' step='any' name='co_" . $i . "' value='" . $inp->value_pgd('co_' . $i) . "' class='rate'
            echo "</td>";

            echo "<td><span class='total_td' id='total_td_" . $i . "'></span></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "<tr>";
        echo "<td class='text-center'>";
        echo "<br/><input type='submit' name='more_input' value='Add More'>";
        echo "</td>";
        echo "<th class='text-right'><br/>Total :</th>";
        echo "<td colspan='2'><br/><span id='grand_total' style='text-align:right;'></span></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'><br>Transport Cost : </th>";
        echo "<td colspan='2'><br><input type='number'  name='t' value='" . $inp->value_pgd('t', '0') . "' style='margin-left: 0px; width: 100%'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'>Discount : </th>";
        echo "<td colspan='2'><input type='number' step='0.01' id='discount' name='d' value='" . $inp->value_pgd('d', '0') . "' style='margin-left: 0px; width: 100%'></td>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'><br>Net Charges : </br></th>";
        echo "<td colspan='2'><br><span id='netcharges'></span></td>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</fieldset>";
        echo "<br/><fieldset><legend>Delivery Information</legend>";
        echo "<table width='100%'>";
        echo "<tr>";
        echo "<td><br> Driver Name : </td>";
        echo "<td colspan='3'>";
        echo $inp->input_text("", 'driver', $inp->value_pgd('driver'), 'full-width', 'drivers');
        echo "</td>";
        echo "</tr>";
        echo "<td><br> Vehicle No : </td>";
        echo "<td colspan='3'>";
        echo $inp->input_text("", 'vehicle', $inp->value_pgd('vehicle'), 'full-width', 'drivers');
        echo "</td>";
        echo "</tr>";
        echo "<td><br> Company : </td>";
        echo "<td colspan='3'>";
        echo $inp->input_text("", 'company', $inp->value_pgd('company'), 'full-width', 'drivers');
        echo "<input type='hidden' name='editor' value='sells/new'/>";
        echo "<input type='hidden' name='e' value='" . $encptid . "'/>";
        echo "<input type='hidden' name='returnlink' value='index.php?page=sells&sub=new&e=" . $encptid . "'/>";
        echo "</td>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</fieldset>";
        echo "<div style='width: 100%;'>";
        $inp->input_submit('ab', 'Sell');
        echo "</div>";
        echo "</form>";
        echo "<script type='text/javascript' src='./js/calculator.js'></script> ";
    }

    public function new_sells($party, $date, $sel_info, $dis, $t, $driver = NULL, $vehicle = NULL, $company = NULL)
    {
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $id = $this->get_last_id('selles', 'idselles');
        $flag = $this->insert_query('selles', array('idselles', 'idparty', 'date'), array($id, $party, $date), array('d', 'd', 's'));

        foreach ($sel_info as $info) {
            if ($flag) {
                $flag = $this->insert_query('selles_details', array('idselles', 'idproduct', 'unite', 'rate'), array($id, $info[0], $info[1], $info[2]), array('d', 'd', 'd', 'f'));
                if ($flag) {
                    $stock = $this->get_cond_row('stock', array('stock'), 'idproduct', '=', $info[0]);

                    if ($stock[0][0] >= $info[1]) {
                        $query = sprintf("UPDATE stock SET stock = stock - %d WHERE idproduct = %d", $info[1], $info[0]);
                        $flag = mysqli_query($this->dtb_con, $query);
                        if (!$flag) {
                            mysqli_query($this->dtb_con, 'ROLLBACK');
                            return -1;
                        }
                    } else {
                        mysqli_query($this->dtb_con, 'ROLLBACK');
                        return -2;
                    }
                } else {
                    break;
                }
            } else {
                break;
            }
        }
        if ($flag) {
            $flag = $this->insert_query('selles_discount', array('idselles', 'discount'), array($id, $dis), array('d', 'd'));
            $flag = $this->insert_query('selles_chalan', array('idselles', 'driver', 'vehicle', 'company'), array($id, $driver, $vehicle, $company), array('d', 's', 's', 's'));
        }
        if ($flag) {
            $flag = $this->insert_query('selles_delivery', array('idselles', 'cost'), array($id, $t), array('d', 'd'));
        }

        if ($t > 0) {
            $tid = $this->get_last_id('transaction', 'id');
            if ($flag) {
                $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($tid, $date, 1, -$t), array('d', 's', 'd', 'f'));

            }
            if ($flag) {
                $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($tid, 'Transport cost'), array('d', 's'));

            }

            if ($flag) {
                $flag = $this->insert_query("party_payment", array("id", "idparty"), array($tid, $party), array("d", "d"));

            }

        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return $id;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }
    }

    public function print_new_purchase($encptid)
    {
        $inp = new html();
        $query = sprintf("SELECT idparty,name FROM (SELECT * FROM party_type WHERE type = 0 OR type=2) as sel LEFT JOIN party USING(idparty) ORDER BY name");
        $party = $this->get_custom_select_query($query, 2);
        $query = sprintf("SELECT idproduct, name, unite, stock FROM (SELECT idunite, idproduct FROM product_details WHERE purchase = 1) as PRO  JOIN product USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN stock USING(idproduct);;");
        $products = $this->get_custom_select_query($query, 3);
        echo "<br/><form  action='editor.php?e=" . $encptid . "' method = 'POST' class='embossed'>";

        echo "<input type = 'hidden' name = 'num' value ='" . count($products) . "' />";
        echo "<table class='centeraligned'>";
        echo "<tr>";
        echo "<td colspan='2' class='text-left'>";
        echo "Date: ";
        $inp->input_date('sd', date('Y-m-d'));
        echo "</td><td colspan='2' class='text-right'>";
        $inp->input_text('Voucher : ', 'res', $inp->value_pgd('res'));
        echo "</td>";
        echo "<tr><td colspan='4' class='text-left'>Party : ";
        $this->get_dropdown_array($party, 0, 1, 'pt', $inp->value_pgd('pt'));
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>";
        echo "Product";
        echo "</th>";

        echo "<th>";
        echo "Quantity";
        echo "</th>";

        echo "<th>";
        echo "Rate";
        echo "</th>";
        echo "<th width='150'>";
        echo "Total";
        echo "</th>";
        echo "</tr>";
        $num = $inp->value_pgd('num', 5);
        echo "<input type = 'hidden' name = 'num' value='" . $num . "' />";
        for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            echo "<td>";
            $this->get_dropdown_array($products, 0, 1, 'pr_' . $i, $inp->value_pgd('pr_' . $i), 'full-width');
            echo "</td>";

            echo "<td>";
            $inp->input_number(null, 'pc_' . $i, $inp->value_pgd('pc_' . $i), 'quantity full-width', 'quantity_' . $i, '');
            echo "</td>";


            echo "<td>";
            $inp->input_number(null, 'co_' . $i, $inp->value_pgd('co_' . $i), 'rate full-width', 'rate_' . $i);
            echo "</td>";


            echo "<td><span class='total_td' id='total_td_" . $i . "'></span></td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td class='text-center'>";
        echo "<br/><input type='submit' name='more_input' value='Add More'>";
        echo "</td>";
        echo "<th class='text-right'><br/>Total :</th>";
        echo "<td colspan='2'><br/><span id='grand_total' style='text-align:right;'></span></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'><br>Transport Cost : </th>";
        echo "<td colspan='2'><br><input type='number'  name='t' value='" . $inp->value_pgd('t', '0') . "' style='margin-left: 0px; width: 100%'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'>Discount : </th>";
        echo "<td colspan='2'><input type='number' step='0.01' id='discount' name='d' value='" . $inp->value_pgd('d', '0') . "' style='margin-left: 0px; width: 100%'></td>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th colspan='2' class='text-right'><br>Net Charges : </br></th>";
        echo "<td colspan='2'><br><span id='netcharges'></span></td>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<br/><input type='submit' name='ab' value='Purchase'/>";
        echo "<input type='hidden' name='editor' value='purchase/new'/>";
        echo "<input type='hidden' name='e' value='" . $encptid . "'/>";
        echo "<input type='hidden' name='returnlink' value='index.php?&e=" . $encptid . "&page=purchase&sub=new'/>";
        echo "</form>";
        echo "<script type='text/javascript' src='js/calculator.js'></script> ";
    }

    public function newPurchase($party, $date, $sel_info, $dis, $voc, $t)
    {
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $id = $this->get_last_id('purchase', 'idpurchase');
        $flag = $this->insert_query('purchase', array('idpurchase', 'idparty', 'date'), array($id, $party, $date), array('d', 'd', 's'));
        d("After Purchase Insert", $flag);
        if ($flag == 1) {
            foreach ($sel_info as $info) {
                if ($flag) {
                    $flag = $this->insert_query('purchase_details', array('idpurchase', 'idproduct', 'unite', 'rate'), array($id, $info[0], $info[1], $info[2]), array('d', 'd', 'd', 'f'));
                    d("After Purchase Insert", $flag);
                    if ($flag) {
                        $query = sprintf("UPDATE stock SET stock = stock + %d WHERE idproduct = %d", $info[1], $info[0]);
                        $flag = mysqli_query($this->dtb_con, $query);
                        d("After Stock Update", $flag);

                        if (!$flag) {
                            echo "Failed to update stock ";
                        }
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }

        if ($flag == 1) {
            $flag = $this->insert_query('purchase_discount', array('idpurchase', 'discount'), array($id, $dis), array('d', 'd'));
            d("After Discount Insert", $flag);

        }
        if ($flag == 1) {
            $flag = $this->insert_query('purchase_recipt', array('idpurchase', 'recipt'), array($id, $voc), array('d', 's'));
            d("After Receipt Insert", $flag);

        }
        if ($flag = 1) {
            $flag = $this->insert_query('purchase_delivery', array('idpurchase', 'cost'), array($id, $t), array('d', 'd'));
            d("After Delievery Insert", $flag);

        }

        $tid = $this->get_last_id('transaction', 'id');
        if ($flag) {
            $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($tid, $date, 1, -$t), array('d', 's', 'd', 'f'));
            d("After Transaction Insert", $flag);


        }
        if ($flag == 1) {
            $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($tid, 'Transport cost'), array('d', 's'));
            d("After Comment Insert", $flag);

        }

        if ($flag == 1) {
            $flag = $this->insert_query("party_payment", array("id", "idparty"), array($tid, $party), array("d", "d"));
            d("After Payment Insert", $flag);

        }


        if ($flag = 1) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return $id;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }
    }

    public function addParty($name = '', $p1 = '', $p2 = '', $address = 'N/A', $type = 1)
    {
        $id = $this->get_last_id("party", "idparty");
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = $this->insert_query('party', array('idparty', 'name'), array($id, $name), array('d', 's'));
        if ($flag == 1) {
            $flag = $this->insert_query('party_adress', array('idparty', 'adress'), array($id, $address), array('d', 's'));
        }
        if ($flag == 1) {
            if ($p1 != "") {
                $flag = $this->insert_query('party_phone', array('idparty', 'phone'), array($id, $p1), array('d', 's'));
            }
            if ($p2 != "") {
                $flag = $this->insert_query('party_phone', array('idparty', 'phone'), array($id, $p2), array('d', 's'));
            }
        }
        if ($flag == 1) {
            $flag = $this->insert_query('party_type', array('idparty', 'type'), array($id, $type), array('d', 's'));
        }
        if ($flag == 1) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }

    }

    public function addNewTran($date, $am, $ttype, $tmedium, $c)
    {

        $id = $this->get_last_id('transaction', 'id');

        $query = sprintf("SELECT  SUM(ammount) FROM transaction GROUP BY type ORDER BY type;");

        $balance = $this->get_custom_select_query($query, 1);

        $cash = $balance[0][0];

        $bank = $balance[1][0];

        //Drawing  Error Validation
        if ($ttype == -1) {

            if ($tmedium == false) {

                if ($cash < $am) {
                    echo "You dont have enough money (" . $am . ") in cash. You have " . $cash . "<br/>";
                    return false;
                }
            } else if ($tmedium == true) {
                if ($bank < $am) {
                    echo "You dont have enough money (" . $am . ") in cash. You have " . $bank . "<br/>";
                    return false;
                }
            }
        }

        $am = $am * $ttype;

        mysqli_query($this->dtb_con, "START TRANSACTION");
        $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($id, $date, $tmedium, $am), array('d', 's', 'd', 'd'));
        if ($flag) {
            $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($id, $c), array('d', 's'));
        }

        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }

        return true;

    }

    public function addTran($rel_id, $date, $am, $ttype, $tmedium, $c, $cat, $bank_info)
    {
        // rel_id
        //cat = 1 party tran

        $id = $this->get_last_id('transaction', 'id');

        $query = sprintf("SELECT  SUM(ammount) FROM transaction GROUP BY type ORDER BY type;");

        $balance = $this->get_custom_select_query($query, 2);

        $cash = $balance[0][0];  //positive type -> 0

        $bank = $balance[1][0]; //negative type -> 1

        if ($ttype == -1) {

            if ($tmedium == false) {

                if ($cash < $am) {
                    echo "You dont have enough money (" . $am . ") in cash. You have " . $cash . "<br/>";
                    return false;
                }
            } else if ($tmedium == true) {
                if ($bank < $am) {
                    echo "You dont have enough money (" . $am . ") in bank. You have " . $bank . "<br/>";
                    return false;
                }
            }
        }

        $am = $am * $ttype;

        mysqli_query($this->dtb_con, "START TRANSACTION");
        $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($id, $date, $tmedium, $am), array('d', 's', 'd', 'd'));
        if ($flag && $c != "") {
            $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($id, $c), array('d', 's'));
        }

        if ($flag) {
            $flag = $this->insert_query("party_payment", array("id", "idparty"), array($id, $rel_id), array("d", "d"));
        }
        if ($tmedium == true && $flag) {
            $bank_info[0] = $id;
            $flag = $this->insert_query("cheque", array('id', 'bank', 'branch', 'date', 'ac'), $bank_info, array('d', 's', 's', 's', 's'));
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }
    }

    public function print_attendance()
    {
        $query = sprintf("SELECT idstaff,name,post FROM staff WHERE status = 1 ORDER BY post ;");
        // $info got the necessary information about staff;
        $info = $this->get_custom_select_query($query, 3);
        // further customization is upto you
        echo "<br/>Attendance For : ";

        $html = new html();
        $d = date('Y-m-d');
        $y = $d[0] . $d[1] . $d[2] . $d[3];
        $m = $d[5] . $d[6];
        $html->select_month('r_m', $m);
        echo " of ";
        $html->select_digit('r_y', 2011, 2021, $y, 1);
        echo "<br/>";

        $i = 0;
        echo "<br/><table align='center' class='centeraligned'>";
        echo "<tr>";
        echo "<th>Select</th>";
        echo "<th>Post</th>";
        echo "<th>Name</th>";
        echo "<th>Attended</th>";
        echo "<th>Leave</th>";
        echo "<th>Absent</th>";
        echo "<th>Overtime</th>";
        echo "</tr>";
        foreach ($info as $staff) {
            echo "<tr>";
            echo "<td><input type = 'checkbox' name = 'staff_" . $i . "' value = '" . $staff[0] . "' /></td>";
            echo "<td>" . $staff[2] . '</td><td>' . $staff[1] . '</td>';
            echo '<td>';
            if (isset($_POST['s_at' . $i]))
                $html->select_digit('s_at' . $i, 0, 31, $_POST['s_at' . $i], 1);
            else
                $html->select_digit('s_at' . $i, 0, 31, 0, 1);
            echo '</td>';

            echo '<td>';
            if (isset($_POST['s_lv' . $i]))
                $html->select_digit('s_lv' . $i, 0, 31, $_POST['s_lv' . $i], 1);
            else
                $html->select_digit('s_lv' . $i, 0, 31, 0, 1);
            echo '</td>';

            echo '<td>';
            if (isset($_POST['s_ab' . $i]))
                $html->select_digit('s_ab' . $i, 0, 31, $_POST['s_ab' . $i], 1);
            else
                $html->select_digit('s_ab' . $i, 0, 31, null, 1);
            echo '</td>';

            echo '<td>';
            if (isset($_POST['s_ov' . $i]))
                $html->select_digit('s_ov' . $i, 0, 372, $_POST['s_ov' . $i], 1);
            else
                $html->select_digit('s_ov' . $i, 0, 372, 0, 1);
            echo '</td>';
            echo "</tr>";
            $i++;
        }
        echo "</table>";
        echo "<input type = 'hidden' name = 'num' value = '" . count($info) . "' />";
    }

    /**
     *
     */
    public function print_salary()
    {

        $query = sprintf("SELECT idstaff,name,post,sallary FROM staff WHERE status = 1");

        $info = $this->get_custom_select_query($query, 4);

        $n = count($info);

        for ($i = 0; $i < $n; $i++) {

            $query = sprintf("SELECT sal_month, sal_year, sum(ammount) as ammount FROM staff_sallary WHERE sal_year = (SELECT MAX(sal_year) FROM staff_sallary WHERE idstaff = %d) AND idstaff = %d GROUP BY (sal_month) ORDER BY  sal_month DESC LIMIT 0,1", $info[$i][0], $info[$i][0]);
            $fin_info = $this->get_custom_select_query($query, 3);
            $p = count($info[$i]);
            for ($j = 0; $j < 3; $j++) {
                $info[$i][$p + $j] = $fin_info[0][$j];
            }

        }

        // furtern customization is upto you


        $html = new html();
        $d = date('Y-m-d');
        $y = $d[0] . $d[1] . $d[2] . $d[3];
        $m = $d[5] . $d[6];
        echo "<br/>";

        $i = 0;
        echo "<table align='center' class='centeraligned'>";
        echo "<tr>";
        echo "<td>Select</td>";
        echo "<td>Post</td>";
        echo "<td>Name</td>";
        echo "<td>Sallary</td>";
        echo "<td>Last Paid</td>";
        echo "<td>Current</td>";
        echo "<td>ammount</td>";
        echo "</tr>";
        $i = 0;
        foreach ($info as $staff) {
            echo "<tr>";
            echo "<td>
<input type = 'checkbox' name = 'staff_" . $i . "' value = '" . $staff[0] . "' />
</td>";

            echo "<td >" . esc($staff[2]) . '</td>';
            if ($m < $staff[4]) {
                echo "<td ><font color = 'red' > " . esc($staff[1]) . ' </font> </td> ';
            } else {
                echo "<td >" . esc($staff[1]) . '</td>';
            }
            echo '<td>';
            echo esc($staff[3]);
            echo '</td>';

            echo "<td align = 'center' >";
            echo $html->print_month($staff[4]) . '-' . $staff[5];
            echo "<br/>";
            echo esc($staff[6]);
            echo '</td>';

            echo '<td>';
            $html->select_month('s_m' . $i, $m);
            $html->select_digit('s_y' . $i, 2011, 2021, $y, 1);
            echo '</td>';


            echo '<td>';
            $html->input_text(null, 's_a' . $i, isset($_POST['s_a' . $i]) ? $_POST['s_a' . $i] : $staff[3]);
            echo '</td>';

            echo "</tr>";
            $i++;
        }

        echo "</table>";
        echo "<input type = 'hidden' name = 'num' value = '" . count($info) . "' />";

    }

    /**
     * @param $mon
     * @param $yer
     * @param $emp
     * @param $at
     * @param $lv
     * @param $ab
     * @param $ov
     * @param $j
     * @return bool
     */
    public function insert_attendance($mon, $yer, $emp, $at, $lv, $ab, $ov, $j)
    {
        $flag = true;
        $rep_name = array('rep_month', 'rep_year', 'idstaff', 'attended', 'rep_leave', 'absent', 'overtime', 'sallary', 'hour');
        $rep_flag = array('d', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd');

        $sal_hr = null;
        $fault = array();
        $inp = new html();
        for ($i = 0; $i < count($emp); $i++) {
            $q = sprintf("SELECT sallary,hour,name FROM staff WHERE idstaff = %d;", $emp[$i]);
            $sal_hr[$i] = $this->get_custom_select_query($q, 3);

            if ($at[$i] + $lv[$i] + $ab[$i] != $inp->print_month_days($mon, $yer)) {
                array_push($fault, $sal_hr[$i][0][2]);
            }
        }

        if (count($fault) > 0) {
            echo "<br/><h4 class='red'>Your input is wrong for the entries of";
            foreach ($fault as $f) {
                echo " " . $f . ", ";
            }
            echo "<br/>because Attendance + Leave + Absent is not equal to " . $inp->print_month_days($mon, $yer) . "</h4>";
            return false;
        } else {
            mysqli_query($this->dtb_con, 'START TRANSACTION');
            for ($i = 0; $i < $j; $i++) {
                if ($flag) {
                    $flag = $this->insert_query('staff_report', $rep_name, array($mon, $yer, $emp[$i], $at[$i], $lv[$i], $ab[$i], $ov[$i], $sal_hr[$i][0][0], $sal_hr[$i][0][1]), $rep_flag);
                } else {
                    break;
                }
            }
            if ($flag) {
                mysqli_query($this->dtb_con, 'COMMIT');
                return true;
            } else {
                mysqli_query($this->dtb_con, 'ROLLBACK');
                return false;

            }
        }
    }

    /**
     * @param $name
     * @param $mes_tpe
     * @param $products_type
     * @param $price
     * @return bool
     */
    public function addProduct($name, $mes_tpe, $products_type, $price)
    {
        $id = $this->get_last_id("product", "idproduct");
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = $this->insert_query('product', array('idproduct', 'name'), array($id, $name), array('d', 's'));
        if ($flag) {
            if ($products_type == 0) {
                // only selles
                $flag = $this->insert_query('product_details', array('idproduct', 'idunite', 'sell', 'purchase'), array($id, $mes_tpe, 0, 1), array('d', 'd', 'd', 'd'));
            } else {
                // only purchase
                $flag = $this->insert_query('product_details', array('idproduct', 'idunite', 'sell', 'purchase'), array($id, $mes_tpe, 1, 0), array('d', 'd', 'd', 'd'));
            }
            if ($flag) {
                $flag = $this->insert_query('stock', array('idproduct'), array($id), array('d'));
            }
            if ($flag) {
                $flag = $this->insert_query('price', array('idproduct', 'price'), array($id, $price), array('d', 'f'));
            }
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }

    }

    /**
     * @param $id
     * @param $type
     * @param $cost
     */
    public function printPayment($id = NULL, $type = NULL, $cost = 0.0)
    {
        $comment = null;
        $inp = new html();
        echo "<br/><form method = 'POST' class='embossed'>";
        echo "<br/>Date : ";
        $inp->input_date('d', date('Y-m-d'));

        echo "<br/>";
        echo "<br/>";
        if ($type == null) {
            $inp->input_radio('Giving to ', 'p_t', -1, 0);
            echo "&nbsp&nbsp;&nbsp&nbsp;";
            $inp->input_radio('Receiving from ', 'p_t', 1, 0);
        } else {
            if ($type == 1) {
                echo "Receiving from <input type='hidden' name='p_t' value='1' >";
                $comment = "Receiving from ";
            } else {
                echo "Giving to <input type='hidden' name='p_t' value='-1' >";
                $comment = "Giving to ";
            }
        }

        if ($id == null) {
            $party = $this->get_custom_select_query('SELECT * FROM party WHERE ', 2);
            $this->get_dropdown_array($party, 0, 1, 'party', null);
        } else {
            $party = $this->get_custom_select_query("SELECT name FROM party WHERE idparty=" . $id, 1);
            echo "<b class='blue'>" . $party[0][0] . "</b>";
            echo "<input type = 'hidden' name = 'party' value = '" . $id . "' />";
            $comment .= $party[0][0];
        }
        echo "<br/>";
        echo "<br/> In ";
        echo "<input type = 'radio' name = 'p_m' value = '0'  onClick='hideallhidden();'checked/> Cash &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type = 'radio' name = 'p_m' value = '1'  onClick='showallhidden();'/> Check";
        echo " Of";
        echo "<br/>";
        echo "<div  id='hidden'>";
        $inp->input_text("Bank", 'c_bn', null);
        $inp->input_text("Branch", 'c_br', null);
        $inp->input_text("A/C", 'c_ac', null);
        echo "Date";
        $inp->input_date('c_d', date('Y-m-d'));
        echo "<br/>";
        echo "</div>";
        echo "<br/>";
        $inp->input_text("Taka", 'amnt', $cost);
        echo "<br/>";
        $inp->input_text("Comment", 'cmnt', $comment);
        $inp->input_submit('ab', 'Save');
        echo "</form>";
    }
    /**
     * @param $id
     * @param $type
     * @param $cost
     */
    public function recivePayment($id = NULL, $type = NULL, $cost = 0.0)
    {
        $comment = null;
        $inp = new html();
        echo "<br/><form method = 'POST' class='embossed'>";
        echo "<br/>Date : ";
        $inp->input_date('d', date('Y-m-d'));

        echo "<br/>";
        echo "<br/>";
        if ($type == null) {

                echo "Receiving from : <input type='hidden' name='p_t' value='1'>";
                $comment = " ";
            
        }

        if ($id == null) {
            $party = $this->get_custom_select_query(sprintf("SELECT party.idparty, party.name,(CASE party_type.type WHEN 1 THEN 'Client' ELSE 'Supplier & Client' END)  type_name FROM party INNER JOIN party_type ON party.idparty = party_type.idparty WHERE party_type.type = 1 OR party_type.type = 2 "), 3);
            $this->get_dropdown_array($party, 0, 1, 'party', null, 'full-width', false, 2);
        } else {
            
            $party = $this->get_custom_select_query("SELECT name FROM party WHERE idparty=" . $id, 1);
            echo "<b class='blue'>" . $party[0][0] . "</b>";
            echo "<input type = 'hidden' name = 'party' value = '" . $id . "' />";
            $comment .= $party[0][0];
        }
        echo "<br/>";
        echo "<br/> In ";
        echo "<input type = 'radio' name = 'p_m' value = '0'  onClick='hideallhidden();'checked/> Cash &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type = 'radio' name = 'p_m' value = '1'  onClick='showallhidden();'/> Check";
        echo " Of";
        echo "<br/>";
        echo "<br/>";
        echo "<div  id='hidden'>";
        $inp->input_text("Bank : ", 'c_bn', null);
        echo "<br/>";
        $inp->input_text("Branch : ", 'c_br', null);
        echo "<br/>";
        $inp->input_text("A/C  : ", 'c_ac', null);
        echo "<br/>";
        echo "Date : ";
        $inp->input_date('c_d', date('Y-m-d'));
        echo "<br/>";
        echo "</div>";
        echo "<br/>";
        $inp->input_text("Taka : ", 'amnt', $cost);
        echo "<br/>";
        $inp->input_text("Comment : ", 'cmnt', $comment);
        $inp->input_submit('ab', 'Save');
        echo "</form>";
    }

    /**
     * @param $id
     * @param $type
     * @param $cost
     */
    public function purchaseExpense($id = NULL, $type = NULL, $cost = 0.0){

        $comment = null;
        $inp = new html();
        echo "<br/><form method = 'POST' class='embossed'>";
        echo "<br/>Date : ";
        $inp->input_date('d', date('Y-m-d'));

        echo "<br/>";
        echo "<br/>";
        if ($type == null) {
            //$inp->input_radio('Suppliers : ', 'p_t', -1, 0);
            echo "Suppliers : <input type='hidden' name='p_t' value='-1' >";
            $comment = "";
        }

        if ($id == null) {
            $party = $this->get_custom_select_query(sprintf("SELECT party.idparty, party.name,(CASE party_type.type WHEN 0 THEN 'Supplier' ELSE 'Supplier & Client' END)  type_name FROM party INNER JOIN party_type ON party.idparty = party_type.idparty WHERE party_type.type = 0 OR party_type.type = 2 "), 3);
            $this->get_dropdown_array($party, 0, 1, 'party', null, '', false, 2);
        } else {
            $party = $this->get_custom_select_query("SELECT name FROM party WHERE idparty=" . $id, 2);
            d($party);
            echo "<b class='blue'>" . $party[0][0] . "</b>";
            echo "<input type = 'hidden' name = 'party' value = '" . $id . "' />";
            $comment .= $party[0][0];
        }
        echo "<br/>";
        echo "<br/> In ";
        echo "<input type = 'radio' name = 'p_m' value = '0'  onClick='hideallhidden();'checked/> Cash &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type = 'radio' name = 'p_m' value = '1'  onClick='showallhidden();'/> Check ";
        echo " Of";
        echo "<br/>";
        echo "<br/>";
        echo "<div  id='hidden'>";
        $inp->input_text("Bank : ", 'c_bn', null);
        echo "<br/>";
        $inp->input_text("Branch : ", 'c_br', null);
        echo "<br/>";
        $inp->input_text("A/C : ", 'c_ac', null);
        echo "<br/>";
        echo "Date : ";
        $inp->input_date('c_d', date('Y-m-d'));
        echo "<br/>";
        echo "</div>";
        echo "<br/>";
        $inp->input_text("Taka : ", 'amnt', $cost);
        echo "<br/>";
        $inp->input_text("Comment : ", 'cmnt', $comment);
        $inp->input_submit('ab', 'Save');
        echo "</form>";
    }

    public function print_edit_sells($vou){

        echo "<br/><form method = 'POST' class='embossed'>";
        $query_pro = sprintf("SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM selles_details WHERE idselles = %d) as selles LEFT JOIN product USING (idproduct);", $vou);
        $query_det = sprintf("SELECT name,date,discount, driver,vehicle, company FROM (SELECT * FROM selles s WHERE idselles = %d) as sell 
LEFT JOIN selles_discount USING (idselles) LEFT JOIN selles_chalan USING (idselles) LEFT JOIN party USING (idparty);", $vou);

        $inp = new html();

        $inp->input_hidden('v', $vou);

        $sell_det = $this->get_custom_select_query($query_det, 6);
        $sell_pro = $this->get_custom_select_query($query_pro, 4);
        //$party = $this->get_custom_select_query('SELECT * FROM party', 2);
        //$products = $this->get_custom_select_query('SELECT * FROM product', 2);
        if (count($sell_pro) > 0 && count($sell_det) > 0) {
            echo "<fieldset><legend>Selles Information</legend>";
            $n = count($sell_pro);
            $inp->input_hidden('num', $n);
            echo "<table class='centeraligned' align='center'>";
            echo "<tr>";
            echo "<td colspan = '3' >";
            echo "<br/>Was sold to : ";
            echo "<b class='blue'>" . $sell_det[0][0] . "</b>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On date : ";
            echo "<b class='blue'>" . $inp->date_convert($sell_det[0][1]) . "</b>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voucher : ";
            echo "<b class='blue'>" . $vou . "</b><br/><br/>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>";
            echo "Product";
            echo "</td>";

            echo "<td>";
            echo "Quantity";
            echo "</td>";

            echo "<td>";
            echo "Cost";
            echo "</td>";
            echo "</tr>";
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo esc($sell_pro[$i][3]);
                $inp->input_hidden('pr_' . $i, $sell_pro[$i][0]);
                echo "</td>";

                echo "<td>";

                if (isset($_POST['pc_' . $i])) {
                    $inp->input_number(null, 'pc_' . $i, esc($_POST['pc_' . $i]));
                    $inp->input_hidden('pr_pc_' . $i, $_POST['pr_pc_' . $i]);

                } else {
                    $inp->input_number(null, 'pc_' . $i, esc($sell_pro[$i][1]));
                    $inp->input_hidden('pr_pc_' . $i, $sell_pro[$i][1]);

                }

                echo "</td>";


                echo "<td>";
                if (isset($_POST['co_' . $i]))
                    $inp->input_number(null, 'co_' . $i, esc($_POST['co_' . $i]));
                else
                    $inp->input_number(null, 'co_' . $i, esc($sell_pro[$i][2]));
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan = '3'><br/>";
            if (isset($_POST['d']))
                $inp->input_number('Discount', 'd', esc($_POST['d']));
            else
                $inp->input_number('Discount', 'd', esc($sell_det[0][2]));
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</fieldset>";

            echo "<br/><fieldset><legend>Delivery Information</legend>";
            echo "<table width='100%'>";
            echo "<tr>";
            echo "<td><br> Driver Name : </td>";
            echo "<td>";
            echo $inp->input_text("", 'driver', esc($sell_det[0][3]), 'full-width', 'drivers');
            echo "</td>";
            echo "</tr>";
            echo "<td><br> Vehicle No : </td>";
            echo "<td>";
            echo $inp->input_text("", 'vehicle', esc($sell_det[0][4]), 'full-width', 'drivers');
            echo "</td>";
            echo "</tr>";
            echo "<td><br> Company : </td>";
            echo "<td>";
            echo $inp->input_text("", 'company', esc($sell_det[0][5]), 'full-width', 'drivers');
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</fieldset>";
            echo "<div style='width: 100%;'>";
            $inp->input_submit('ab', 'save');
            echo "</div>";
            echo "</form>";
        } else {
            echo "<h3> Nothing Found. </h3>";
        }
    }

    public function sells_return($id, $products, $d, $cost, $driver = null, $vehicle = null, $company = null)
    {
        if ($cost <= $d) {
            echo "<br/>Discount cant be equal to cost";
            return false;
        }
        mysqli_query($this->dtb_con, 'START TRANSACTION');

        $flag = $this->update_column('selles_discount', array('discount'), array($d), array('d'), 'idselles', '=', $id);
        $flag = $this->update_column('selles_chalan', array('driver', 'vehicle', 'company'), array($driver, $vehicle, $company), array('s', 's', 's'), 'idselles', '=', $id);
        if (count($products) > 0) {
            foreach ($products as $p) {
                if ($flag) {
                    if (0 == $p[2] || $p[2] == null) {
                        $query = sprintf("DELETE FROM selles_details WHERE idselles = %d and idproduct = %d;", $id, $p[0]);
                        $flag = mysqli_query($this->dtb_con, $query);
                        if ($flag) {
                            $flag = $this->update_column('stock', array('stock'), array('stock + ' . $p[1]), array('d'), 'idproduct', '=', $p[0]);
                        }
                    } else if ($p[1] > $p[2]) {
                        $flag = $this->update_column('stock', array('stock'), array('stock + ' . ($p[1] - $p[2])), array('d'), 'idproduct', '=', $p[0]);
                        if ($flag) {
                            $query = sprintf("UPDATE selles_details SET unite = %d, rate = %f WHERE idselles = %d AND idproduct = %d", $p[2], $p[3], $id, $p[0]);
                            $flag = mysqli_query($this->dtb_con, $query);
                        }
                    }

                } else {
                    unset($products);
                    mysqli_query($this->dtb_con, 'ROLLBACK');
                    return $flag;

                }
            }
        }
        unset($products);
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }

    public function printReturnPur($vou){

        echo "<br/><form method = 'POST' class='embossed'>";
        $query_pro = sprintf("SELECT idproduct, unite, rate, name FROM (SELECT idproduct,unite,rate FROM purchase_details WHERE idpurchase = %d) as purchase LEFT JOIN product USING (idproduct);", $vou);
        $query_det = sprintf("SELECT name,date,discount FROM (SELECT * FROM purchase s WHERE idpurchase = %d) as purchase LEFT JOIN purchase_discount USING (idpurchase) LEFT JOIN party USING (idparty);", $vou);

        $inp = new html();

        $inp->input_hidden('v', $vou);

        $sell_det = $this->get_custom_select_query($query_det, 3);
        $sell_pro = $this->get_custom_select_query($query_pro, 4);
        //$party = $this->get_custom_select_query('SELECT * FROM party', 2);
        //$products = $this->get_custom_select_query('SELECT * FROM product', 2);

        if (count($sell_det) > 0 && count($sell_pro) > 0) {
            $n = count($sell_pro);
            $inp->input_hidden('num', $n);

            echo "<table class='centeraligned' align='center'>";
            echo "<tr>";
            echo "<td colspan = '3' >";
            echo "<br/>Was purchased from : ";
            echo "<b class='blue'>" . $sell_det[0][0] . "</b>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On date : ";
            echo "<b class='blue'>" . convert_date($sell_det[0][1]) . "</b>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voucher : ";
            echo "<b class='blue'>" . $vou . "</b><br/><br/>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>";
            echo "Product";
            echo "</td>";

            echo "<td>";
            echo "Quantity";
            echo "</td>";

            echo "<td>";
            echo "Cost";
            echo "</td>";
            echo "</tr>";
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo esc($sell_pro[$i][3]);
                $inp->input_hidden('pr_' . $i, $sell_pro[$i][0]);
                echo "</td>";

                echo "<td>";

                if (isset($_POST['pc_' . $i])) {
                    $inp->input_number(null, 'pc_' . $i, $_POST['pc_' . $i]);
                    $inp->input_hidden('pr_pc_' . $i, $_POST['pr_pc_' . $i]);

                } else {
                    $inp->input_number(null, 'pc_' . $i, esc($sell_pro[$i][1]));
                    $inp->input_hidden('pr_pc_' . $i, esc($sell_pro[$i][1]));

                }

                echo "</td>";


                echo "<td>";
                if (isset($_POST['co_' . $i]))
                    $inp->input_number(null, 'co_' . $i, $_POST['co_' . $i]);
                else
                    $inp->input_number(null, 'co_' . $i, esc($sell_pro[$i][2]));
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan = '3'><br/>";
            if (isset($_POST['d']))
                $inp->input_number('Discount', 'd', $_POST['d']);
            else
                $inp->input_number('Discount', 'd', esc($sell_det[0][2]));
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan = '3'>";
            $inp->input_submit('ab', 'Save');
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</form>";
        } else {
            echo "<h3>Nothing Found</h3>";
        }
    }

    public function purchaseReturn($id, $products, $d, $cost)
    {
        if ($cost <= $d) {
            echo "Discount cant be equal to cost";
            return false;
        }
        mysqli_query($this->dtb_con, 'START TRANSACTION');

        $flag = $this->update_column('purchase_discount', array('discount'), array($d), array('d'), 'idpurchase', '=', $id);

        if (count($products) > 0) {


            foreach ($products as $p) {
                if ($flag) {
                    if (0 == $p[2] || $p[2] == null) {
                        $query = sprintf("DELETE FROM purchase_details WHERE idpurchase = %d and idproduct = %d;", $id, $p[0]);
                        $flag = mysqli_query($this->dtb_con, $query);
                        if ($flag) {
                            $flag = $this->update_column('stock', array('stock'), array('stock + ' . $p[1]), array('d'), 'idproduct', '=', $p[0]);
                        }
                    } else if ($p[1] > $p[2]) {
                        $flag = $this->update_column('stock', array('stock'), array('stock - ' . ($p[1] - $p[2])), array('d'), 'idproduct', '=', $p[0]);
                        if ($flag) {
                            $query = sprintf("UPDATE purchase_details SET unite = %d, rate = %f WHERE idpurchase = %d AND idproduct = %d", $p[2], $p[3], $id, $p[0]);
                            $flag = mysqli_query($this->dtb_con, $query);
                        }
                    }

                } else {
                    unset($products);
                    mysqli_query($this->dtb_con, 'ROLLBACK');
                    return $flag;

                }
            }
        }
        unset($products);
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }

    public function search_staff($s)
    {
        $query = "SELECT * FROM staff WHERE name LIKE '%$s%' ORDER BY name;";
        return $this->get_custom_select_query($query, 5);
    }

    public function search_party($s)
    {
        $query = "SELECT * FROM party LEFT JOIN party_adress USING (idparty) LEFT JOIN party_phone USING (idparty)  WHERE name LIKE '%$s%' OR adress LIKE '%$s%' OR phone LIKE '%$s%' ORDER BY name;";
        return $this->get_custom_select_query($query, 5);
    }

    public function search_product($s)
    {
        $query = "SELECT idproduct,name,stock,unite FROM product LEFT JOIN product_details USING (idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN stock USING(idproduct)  WHERE name LIKE '%$s%' ORDER BY name;";
        return $this->get_custom_select_query($query, 4);
    }

    public function search_sell($s)
    {
        $query1 = "SELECT idselles,name,date FROM (SELECT * FROM selles s WHERE idselles LIKE '%$s%') as s LEFT JOIN party USING (idparty);";
        return $res1 = $this->get_custom_select_query($query1, 3);


    }

    public function search_pur($s)
    {
        $query2 = "SELECT idpurchase,recipt,name,date FROM (SELECT * FROM purchase_recipt WHERE recipt LIKE '%$s%') as p LEFT JOIN purchase USING (idpurchase) LEFT JOIN party USING(idparty);";
        return $res1 = $this->get_custom_select_query($query2, 4);

    }

    public function changecss($idstaff, $newcss)
    {
        $q = mysqli_query($this->dtb_con, "UPDATE  user SET css='$newcss' WHERE idstaff='$idstaff'");
        if ($q)
            return 1;
        else
            return 0;
    }

    public function changepass($idstaff, $newpass)
    {
        $q = mysqli_query($this->dtb_con, "UPDATE  user SET pass='$newpass' WHERE idstaff='$idstaff'");
        if ($q)
            return 1;
        else
            return 0;
    }

    public function get_particular_product_overview($id, $date1, $date2)
    {

        $query = sprintf("SELECT name,sell, purchase FROM (SELECT * FROM product WHERE idproduct = %d) AS pro LEFT JOIN product_details USING(idproduct);", $id);

        $products_type = $this->get_custom_select_query($query, 2);

        if (count($products_type) > 0) {

            if ($products_type[0][1] == 1) {
                echo "<h2 class='blue'>" . strtoupper($products_type[0][0]) . " Sells Report</h2>";
                $query = sprintf("SELECT date, name,unite,rate FROM(SELECT * FROM selles WHERE date BETWEEN '%s' AND '%s') as selles JOIN (SELECT * FROM selles_details WHERE idproduct = %d) as selles_details USING(idselles) LEFT JOIN party USING (idparty) ORDER BY date DESC,idparty;", $date1, $date2, $id);
            } else {
                echo "<h2 class='blue'>" . strtoupper($products_type[0][0]) . " Purchase Report</h2>";
                $query = sprintf("SELECT date,name,unite,rate FROM(SELECT * FROM purchase WHERE date BETWEEN '%s' AND '%s') as purchase JOIN (SELECT * FROM purchase_details WHERE idproduct = %d) as purchase_details USING(idpurchase) LEFT JOIN party USING (idparty) ORDER BY date DESC,idparty;", $date1, $date2, $id);
            }
        }
        return $this->get_custom_select_query($query, 4);
    }

    public function get_finished_product_overview($date1, $date2)
    {

        $query = sprintf("SELECT date,pt.name,pr.name,sd.unite,mu.unite,sd.rate FROM (SELECT * FROM selles WHERE date BETWEEN '$date1' AND '$date2') as s LEFT JOIN party as pt USING (idparty) LEFT JOIN selles_details as sd USING(idselles) LEFT JOIN product as pr USING(idproduct) LEFT JOIN product_details as pd USING(idproduct) LEFT JOIN mesurment_unite as mu USING(idunite) ORDER BY date DESC,pt.name,pr.name ;");

        return $info = $this->get_custom_select_query($query, 6);
    }

    public function get_raw_product_overview($date1, $date2)
    {

        $query = sprintf("SELECT date,pt.name,pr.name,sd.unite,mu.unite,sd.rate FROM (SELECT * FROM purchase WHERE date BETWEEN '$date1' AND '$date2') as s LEFT JOIN party as pt USING (idparty) LEFT JOIN purchase_details as sd USING(idpurchase) LEFT JOIN product as pr USING(idproduct) LEFT JOIN product_details as pd USING(idproduct) LEFT JOIN mesurment_unite as mu USING(idunite) ORDER BY date DESC,pt.name,pr.name ;");

        return $info = $this->get_custom_select_query($query, 6);
    }

    public function update_stock($id, $date, $st, $cur)
    {
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = $this->insert_query('product_input', array('date', 'idproduct', 'stock'), array($date, $id, $st), array('s', 'd', 'd'));

        if ($flag) {
            $flag = $this->update_column('stock', array('stock'), array($cur + $st), array('d'), 'idproduct', '=', $id);
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }

    public function update_fac_stock($id, $date, $st, $cur)
    {
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = $this->insert_query('product_input', array('date', 'idproduct', 'stock', 'type'), array($date, $id, $st, 1), array('s', 'd', 'd', 'd'));

        if ($flag) {
            $flag = $this->update_column('stock', array('factory_stock'), array($cur + $st), array('d'), 'idproduct', '=', $id);
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }


    public function delete_product_input($p, $s)
    {

        $id = $this->get_custom_select_query("SELECT idproduct FROM product_input WHERE idupdate = $p", 1);

        $query = sprintf("SELECT stock FROM stock WHERE idproduct = %d;", $id[0][0]);

        $cs = $this->get_custom_select_query($query, 1);

        $flag = true;
        $pid = $id[0][0];
        if ($cs[0][0] - $s >= 0) {
            $flag = true;
        } else {
            $flag = false;
            echo "<h3 class='red'>Not enough stock to perform this operation</h3><br/>";
        }

        mysqli_query($this->dtb_con, 'START TRANSACTION');


        if ($flag) {
            $query = sprintf("DELETE FROM product_input WHERE idupdate = %d", $p);
            $flag = mysqli_query($this->dtb_con, $query);

        }
        if ($flag) {
            $flag = $this->update_column('stock', array('idproduct', 'stock'), array($id[0][0], $cs[0][0] - $s), array('d', 'd'), 'idproduct', '=', $pid);
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }

    public function print_party_overview($id, $encptid, $name, $date1 = null, $date2 = null)
    {
        $inp = new html();
        if ($date1 && $date2) {
            $query1 = sprintf("SELECT date, SUM(unite*rate) as sell,discount FROM (SELECT date, idselles FROM selles WHERE idparty = %d  AND date BETWEEN '%s' AND '%s') as selles LEFT JOIN selles_details USING (idselles)  LEFT JOIN selles_discount USING(idselles)  GROUP BY idselles;", $id, $date1, $date2);
            $query2 = sprintf("SELECT date, SUM(unite*rate) as purchase,discount FROM (SELECT date, idpurchase FROM purchase WHERE idparty = %d AND date BETWEEN '%s' AND '%s' ) as purchase LEFT JOIN purchase_details USING (idpurchase)  LEFT JOIN purchase_discount USING(idpurchase)  GROUP BY idpurchase;", $id, $date1, $date2);
            $query3 = sprintf("SELECT date, ammount, comment FROM (SELECT id FROM party_payment WHERE idparty = %d) as payment LEFT JOIN transaction USING (id) LEFT JOIN transaction_comment USING(id) WHERE date BETWEEN '%s' AND '%s';", $id, $date1, $date2);
        } else {
            $query1 = sprintf("SELECT date, SUM(unite*rate) as sell,discount FROM (SELECT date, idselles FROM selles WHERE idparty = %d) as selles LEFT JOIN selles_details USING (idselles)  LEFT JOIN selles_discount USING(idselles) GROUP BY idselles;", $id);
            $query2 = sprintf("SELECT date, SUM(unite*rate) as purchase,discount FROM (SELECT date, idpurchase FROM purchase WHERE idparty = %d) as purchase LEFT JOIN purchase_details USING (idpurchase)  LEFT JOIN purchase_discount USING(idpurchase) GROUP BY idpurchase;", $id);
            $query3 = sprintf("SELECT date, ammount, comment FROM (SELECT id FROM party_payment WHERE idparty = %d) as payment LEFT JOIN transaction USING (id) LEFT JOIN transaction_comment USING(id);", $id);
        }
        $sell = $this->get_custom_select_query($query1, 3);
        $pur = $this->get_custom_select_query($query2, 3);
        $tran = $this->get_custom_select_query($query3, 3);

        $paid = 0;
        $recived = 0;

        echo "<br/><div class='embossed'>";
        echo "<img src='images/blank1by1.gif' width='600px' height='1px'/><br/>";
        echo "<a onclick='showit(0)'><h3>Transaction Report</h3></a>";
        echo "<div  id='sud0'>";
        if (count($tran) > 0) {
            if ($date1 && $date2) {
                echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_trans&id=" . $id . "&date1=" . $date1 . "&date2=" . $date2 . "' class='button' target='_blank'><b>Print</b></a><br/>";
            } else {
                echo "<a  id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_trans&id=" . $id . "' class='button' target='_blank'><b>Print</b></a><br/>";
            }
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Date";
            echo "</th>";

            echo "<th>";
            echo " Paid";
            echo "</th>";

            echo "<th>";
            echo " Recived";
            echo "</th>";
            echo "<th>";
            echo "Comments";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($tran as $s) {
                echo "<tr>";
                echo "<td>";
                echo $inp->date_convert($s[0]);
                echo "</td>";
                if ($s[1] > 0) {
                    echo "<td align = 'center' ></td>";
                    echo "<td align = 'right' >" . money($s[1]) . "</td>";
                    $recived += $s[1];
                } else {
                    $neg = ($s[1]) * -1;
                    echo "<td align = 'right' >" . money($neg) . "</td>";
                    echo "<td align = 'center' ></td>";
                    $paid += $s[1];
                }

                echo "<td>";
                echo esc($s[2]);
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            $total_paid = ($paid) * -1;
            echo "<tr><td>Total </td> 
<td><b>" . money($total_paid) . "</b></td>
<td><b>" . money($recived) . "</b  ></td>
<td> - </td></tr>";
            echo "</table>";

        } else {
            if ($date1 && $date2) {
                echo "<br/><h4 class='green'>You have no transactions with " . $name . " between " . $inp->date_convert($date1) . " and " . $inp->date_convert($date2) . "</h4>";
            } else {
                echo "<br/><h4 class='green'>You have never done any transactions with  " . $name . "</h4>";
            }
        }
        echo "</div>";
        echo "</div>";

        $bill_t = 0;
        $bill_d = 0;
        $total = 0;

        echo "<br/><div class='embossed'>";
        echo "<img src='images/blank1by1.gif' width='600px' height='1px'/><br/>";
        echo "<a onclick='showit(1)'><h3>Sells Report</h3></a>";
        echo "<div  id='sud1'>";
        if (count($sell) > 0) {
            if ($date1 && $date2) {
                echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_sell&id=" . $id . "&date1=" . $date1 . "&date2=" . $date2 . "' class='button' target='_blank'><b>Print</b></a><br/>";
            } else {
                echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_sell&id=" . $id . "' class='button' target='_blank'><b>Print</b></a><br/>";
            }
            echo "<br/><table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Date";
            echo "</th>";
            echo "<th>";
            echo "Bill";
            echo "</th>";

            echo "<th>";
            echo "Discount";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($sell as $s) {
                echo "<tr>";
                echo "<td>" . $inp->date_convert($s[0]) . "</td>" . "<td >" . money($s[1]) . "</td>" . "<td>" . money($s[2]) . "</td>";
                $bill_t += $s[1];
                $bill_d += $s[2];
                echo "</tr>";
            }
            echo "</tbody>";
            echo "<tr><td>Total : </td> <td>" . money($bill_t) . "</td><td>" . money($bill_d) . "</td></tr>";
            $gdtotal = $bill_t - $bill_d;
            echo "<tr><td> Grand Total  </td> <td colspan = '2' > <b>" . money($gdtotal) . "</b></td></td></tr>";
            $total += $gdtotal;
            echo "</table>";
        } else {
            if ($date1 && $date2) {
                echo "<br/><h4 class='green'>You have not sold any item to " . $name . " between " . $inp->date_convert($date1) . " and " . $inp->date_convert($date2) . "</h4>";
            } else {
                echo "<br/><h4 class='green'>You have never sold any item to " . $name . "</h4>";
            }
        }
        echo "</div>";
        echo "</div>";

        $r_bill_t = 0;
        $r_bill_d = 0;

        echo "<br/><div class='embossed'>";
        echo "<img src='images/blank1by1.gif' width='600px' height='1px'/><br/>";
        echo "<a onclick='showit(2)'><h3>Purchase Report</h3></a>";
        echo "<div  id='sud2'>";
        if (count($pur) > 0) {
            if ($date1 && $date2) {
                echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_purchase&id=" . $id . "&date1=" . $date1 . "&date2=" . $date2 . "' class='button' target='_blank'><b>Print</b></a><br/>";
            } else {
                echo "<a id='printBox' href='print.php?e=" . $encptid . "&page=party&sub=individual_purchase&id=" . $id . "' class='button' target='_blank'><b>Print</b></a><br/>";
            }
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Date";
            echo "</th>";

            echo "<th>";
            echo "Bill";
            echo "</th>";

            echo "<th>";
            echo "Discount";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($pur as $s) {
                echo "<tr>";
                echo "<td>" . $inp->date_convert($s[0]) . "</td>" . "<td >" . money($s[1]) . "</td>" . "<td>" . money($s[2]) . "</td>";
                $r_bill_t += $s[1];
                $r_bill_d += $s[2];
                echo "</tr>";
            }
            echo "</tbody>";
            echo "<tr><td>Total : </td> <td>" . money($r_bill_t) . "</td><td>" . money($r_bill_d) . "</td></tr>";
            $total = $r_bill_t - $r_bill_d;
            echo "<tr><td> Grand Total  </td> <td colspan = '2' > <b>" . money($total) . "</b></td></td></tr>";
            echo "</table>";
        } else {
            if ($date1 && $date2) {
                echo "<br/><h4 class='green'>You have not purchased any item from " . $name . " between " . $inp->date_convert($date1) . " and " . $inp->date_convert($date2) . "</h4>";
            } else {
                echo "<br/><h4 class='green'>You have never purchased any item from " . $name . "</h4>";
            }
        }
        echo "</div>";
        echo "</div>";
        echo "<br/><img src='images/blank1by1.gif'  alt='Blank' onload='hideAllButZero(4);' class='rightflotingnoborder'>";
    }

    public function party_adv_due($id)
    {

        $query1 = sprintf("SELECT sum(ammount) FROM (SELECT * FROM party_payment WHERE idparty = %d) as pp LEFT JOIN transaction USING(id);", $id);
        $query2 = sprintf("SELECT idparty,(cost-discount) FROM (SELECT idparty,SUM(unite*rate) AS cost FROM (SELECT * FROM purchase WHERE idparty = %d) as pur LEFT JOIN purchase_details USING(idpurchase)) as p LEFT JOIN  (SELECT idparty,sum(discount) as discount FROM (SELECT * FROM purchase WHERE idparty = %d) as p LEFT JOIN purchase_discount USING (idpurchase)) as dis  USING(idparty);", $id, $id);
        $query3 = sprintf("SELECT idparty,(cost-discount) FROM (SELECT idparty,SUM(unite*rate) AS cost FROM (SELECT * FROM selles WHERE idparty = %d) as pur LEFT JOIN selles_details USING(idselles)) as s LEFT JOIN  (SELECT idparty,sum(discount) as discount FROM (SELECT * FROM selles WHERE idparty = %d) as p LEFT JOIN selles_discount USING (idselles)) as dis  USING(idparty)", $id, $id);

        //total transaction either plus or minus
        $i1 = $this->get_custom_select_query($query1, 1);
        //i2[0][1] total purchase
        $i2 = $this->get_custom_select_query($query2, 2);
        //i3[0][1]total sell
        $i3 = $this->get_custom_select_query($query3, 2);

        $total_transaction = isset($i1[0][0]) ? $i1[0][0] : 0;
        $total_purchase = isset($i2[0][1]) ? $i2[0][1] : 0;
        $total_sell = isset($i3[0][1]) ? $i3[0][1] : 0;
        return $total_transaction + $total_purchase - $total_sell;
    }

    public function update_party($id, $name, $p1, $p2, $adrs, $type)
    {
        $flag = $this->update_column('party', array('name'), array($name), array('s'), 'idparty', '=', $id);
        if ($flag) {
            $flag = mysqli_query($this->dtb_con, "DELETE FROM party_phone WHERE idparty = $id;");
        }

        if ($flag && $p1 != null) {
            $flag = $this->insert_query('party_phone', array('idparty', 'phone'), array($id, $p1), array('d', 's'));
        }

        if ($flag && $p2 != null) {
            $flag = $this->insert_query('party_phone', array('idparty', 'phone'), array($id, $p2), array('d', 's'));
        }

        if ($flag) {
            $flag = $this->update_column('party_adress', array('adress'), array($adrs), array('s'), 'idparty', '=', $id);
        }

        if ($flag) {
            $flag = $this->update_column('party_type', array('type'), array($type), array('d'), 'idparty', '=', $id);
        }

        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
        }
        return $flag;
    }

    public function add_salary_pay($date, $emp, $m, $y, $sal, $cmnt = 'Sallary')
    {
        $id = $this->get_last_id('transaction', 'id');

        $query = sprintf("SELECT  SUM(ammount) FROM transaction GROUP BY type ORDER BY type;");
        $cols = array('id', 'idstaff', 'sal_month', 'sal_year');

        $balance = $this->get_custom_select_query($query, 1);

        $cash = $balance[0][0];


        if ($cash < $sal) {
            echo "You dont have enough money (" . money($am) . ") in cash. You have " . $cash . "<br/>";
            return false;
        }
        $am = -$sal;
        mysqli_query($this->dtb_con, "START TRANSACTION");
        $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($id, $date, 0, $am), array('d', 's', 'd', 'd'));
        if ($flag) {
            $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($id, $cmnt), array('d', 's'));
        }

        if ($flag) {
            $flag = $this->insert_query('staff_sallary', $cols, array($id, $emp, $m, $y), array('d', 'd', 'd', 'd',));
        }

        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            echo 'something is wrong check your given data or contact with <a> unique webers </a>';
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }
    }

    public function add_bonus_payment($date, $emp, $m, $y, $bon, $cmnt = 'Bonus')
    {

        $cols = array('id', 'idstaff', 'month', 'year');

        $flag = true;

        $id = $this->get_last_id('transaction', 'id');

        $query = sprintf("SELECT  SUM(ammount) FROM transaction GROUP BY type ORDER BY type;");

        $balance = $this->get_custom_select_query($query, 1);

        $cash = $balance[0][0];


        if ($cash < $bon) {
            echo "You dont have enough money (" . money($am) . ") in cash. You have " . money($cash) . "<br/>";
            return false;
        }
        $am = -$bon;

        mysqli_query($this->dtb_con, "START TRANSACTION");
        $flag = $this->insert_query('transaction', array('id', 'date', 'type', 'ammount'), array($id, $date, 0, $am), array('d', 's', 'd', 'd'));
        if ($flag) {
            $flag = $this->insert_query('transaction_comment', array('id', 'comment'), array($id, $cmnt), array('d', 's'));
        }


        if ($flag) {
            $flag = $this->insert_query('staff_bonus', $cols, array($id, $emp, $m, $y), array('d', 'd', 'd', 'd'));
        }

        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            echo 'something is wrong check your given data or contact with <a> unique wavers </a>';
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }

    }

    public function purchase_delete($purchase_id)
    {
        $query = sprintf("SELECT idproduct,stock-unite FROM (SELECT idproduct, unite FROM purchase_details p WHERE idpurchase = %d) as pur LEFT JOIN stock USING(idproduct);", $purchase_id);
        $info = $this->get_custom_select_query($query, 2);
        $n = count($info);
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = true;
        for ($i = 0; $i < $n; $i++) {
            if ($flag && $info[$i][1] >= 0) {
                $flag = $this->update_column("stock", array('stock'), array($info[$i][1]), array('d'), 'idproduct', '=', $info[$i][0]);
            }
        }
        $query = sprintf("DELETE FROM purchase WHERE idpurchase = %d", $purchase_id);
        $flag = mysqli_query($this->dtb_con, $query);
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        }
        mysqli_query($this->dtb_con, 'ROLLBACK');
        return false;
    }

    public function selles_delete($sel_id)
    {
        $query = sprintf("SELECT idproduct,stock+unite FROM (SELECT idproduct, unite FROM selles_details p WHERE idselles = %d) as sel LEFT JOIN stock USING(idproduct);", $sel_id);
        $info = $this->get_custom_select_query($query, 2);
        $n = count($info);
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = true;
        for ($i = 0; $i < $n; $i++) {
            if ($flag && $info[$i][1] >= 0) {
                $flag = $this->update_column("stock", array('stock'), array($info[$i][1]), array('d'), 'idproduct', '=', $info[$i][0]);
            }
        }
        $query = sprintf("DELETE FROM selles WHERE idselles = %d", $sel_id);
        $flag = mysqli_query($this->dtb_con, $query);
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        }
        mysqli_query($this->dtb_con, 'ROLLBACK');
        return false;
    }

    public function editProduct($id, $name, $mt, $pt, $price)
    {

        mysqli_query($this->dtb_con, 'START TRANSACTION');

        $flag = $this->update_column('product', array('name'), array($name), array('s'), 'idproduct', '=', $id);
        if ($flag) {
            if ($pt == 1) {
                $sell = 0;
                $pur = 1;
            } else {
                $sell = 1;
                $pur = 0;
            }

            $flag = $this->update_column('product_details', array('idunite', 'sell', 'purchase'), array($mt, $sell, $pur), array('d', 'd', 'd'), 'idproduct', '=', $id);

            if ($flag) {
                $flag = $this->update_column('price', array('price'), array($price), array('f'), 'idproduct', '=', $id);
            }
        }
        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            return true;
        } else {
            mysqli_query($this->dtb_con, 'ROLLBACK');
            return false;
        }

    }

    public function getPrevBalance($date)
    {
        $query = sprintf("SELECT ammount FROM transaction WHERE date < '%s';", $date);
        $bl = $this->get_custom_select_query($query, 1);
        $n = count($bl);
        $t1 = $t2 = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($bl[$i][0] > 0) {
                $t1 += $bl[$i][0];
            } else {
                $t2 += $bl[$i][0];
            }
        }
        return ($t1 + $t2);
    }

    public function deleteTransaction($id)
    {
        $q = mysqli_query($this->dtb_con, "DELETE FROM transaction WHERE id='$id'");
        if ($q)
            return 1;
        else
            return 0;
    }

    public function current_stock($id)
    {
        $query = sprintf("SELECT stock FROM stock WHERE idproduct = %d", $id);
        $res = $this->get_custom_select_query($query, 1);
        return $res[0][0];
    }

    public function delete_attendense($id, $mon, $yr)
    {
        $query = sprintf("DELETE FROM staff_report WHERE idstaff = %d AND rep_month = %d AND rep_year = %d", $id, $mon, $yr);
        return mysqli_query($this->dtb_con, $query);
    }

    public function transfarProduct($product, $num, $type, $date)
    {


        if ($type == 2)
            $query1 = sprintf("UPDATE stock SET stock = stock + %d , factory_stock = factory_stock - %d WHERE idproduct = %d", $num, $num, $product);
        if ($type == 3)
            $query1 = sprintf("UPDATE stock SET stock = stock - %d , factory_stock = factory_stock + %d WHERE idproduct = %d", $num, $num, $product);
        mysqli_query($this->dtb_con, 'START TRANSACTION');
        $flag = $this->execute_query($query1);
        if ($flag)
            $flag = $this->insert_query('product_input', array('date', 'idproduct', 'stock', 'type'), array($date, $product, $num, $type), array('s', 'd', 'f', 'd'));

        if ($flag) {
            mysqli_query($this->dtb_con, 'COMMIT');
            echo "<h2 class='green'>Stock Transfer Successful</h2><br/>";
            return true;
        }
        mysqli_query($this->dtb_con, 'ROLLBACK');
        echo "<h2 class='green'>Failed to Transfer Stock</h2><br/>";
        return false;
    }
}

