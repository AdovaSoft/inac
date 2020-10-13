<?php

/**
 * Class query
 */
class query
{
    /**
     * @var
     */
    protected $dtb_con = null;

    /**
     * query constructor.
     */
    public function __construct()
    {
        if ($this->dtb_con = mysqli_connect($_SERVER['HOST'], $_SERVER['USER'], $_SERVER['PASS'], $_SERVER['DBASE'])) {
            if (!mysqli_query($this->dtb_con, "SET NAMES utf8")) {
                echo "Database Encode Change Failed!\n";
            }
        } else {
            echo "Connection Failed!\n";
        }
    }

    /**
     * @param $table
     * @param $col
     * @param $order
     * @return mixed
     */
    public function get_row_asc($table, $col, $order)
    {
        $i = 0;
        $value = null;
        $query = sprintf("%s ORDER BY %s ASC", $this->gen_query($table, $col, 0), $order);
        $res = mysqli_query($this->dtb_con, $query);

        while ($row = mysqli_fetch_array($res)) {
            for ($j = 0; $j < count($col); $j++) {
                $value[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $value;
    }

    /**
     * @param $table
     * @param $col
     * @param $i
     * @return string
     */
    public function gen_query($table, $col, $i)
    {
        if ($i == 0) {
            return sprintf("SELECT %s%s", $col[$i], $this->gen_query($table, $col, $i + 1));
        } else if ($i < count($col)) {
            return sprintf(", %s %s", $col[$i], $this->gen_query($table, $col, $i + 1));
        } else if (count($col) == $i) {
            return sprintf(" FROM %s", $table);
        } else {
            return "";
        }
    }

    /**
     * @param $table
     * @param $col
     * @param $order
     * @return mixed
     */
    public function get_row_dsc($table, $col, $order)
    {

        $i = 0;
        $value = null;
        $query = sprintf("%s ORDER BY %s DESC", $this->gen_query($table, $col, 0), $order);
        $res = mysqli_query($this->dtb_con, $query);

        while ($row = mysqli_fetch_array($res)) {
            for ($j = 0; $j < count($col); $j++) {
                $value[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $value;
    }

    /**
     * @param $table
     * @param $cols
     * @param $matchcol
     * @param $cond
     * @param $value
     * @param $llimit
     * @param $ulimit
     * @return mixed
     */
    public function get_cond_row_limited($table, $cols, $matchcol, $cond, $value, $llimit, $ulimit)
    {

        $query = sprintf("%s WHERE %s %s %s LIMIT %d , %d", $this->gen_query($table, $cols, 0), $matchcol, $cond, $value, $llimit, $ulimit);
        $result = null;
        $i = 0;
        $n = count($cols);

        $res = mysqli_query($this->dtb_con, $query);

        while ($row = mysqli_fetch_array($res)) {
            for ($j = 0; $j < $n; $j++) {
                $result[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $result;
    }

    /**
     * @param $table
     * @param $cols
     * @param $matchcol
     * @param $cond
     * @param $value
     * @return mixed
     */
    public function get_cond_row($table, $cols, $matchcol, $cond, $value)
    {

        $query = sprintf("%s WHERE %s %s %s", $this->gen_query($table, $cols, 0), $matchcol, $cond, $value);
        $result = null;
        $i = 0;
        $n = count($cols);

        $res = mysqli_query($this->dtb_con, $query);

        while ($row = mysqli_fetch_array($res)) {

            for ($j = 0; $j < $n; $j++) {
                $result[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $result;
    }

    /**
     * @param $tab
     * @param $cols
     * @param $vals
     * @param $flags
     * @return int
     */
    public function insert_query($tab, $cols, $vals, $flags)
    {
        $query = $this->gen_insert_query($tab, $cols, $vals, $flags);
        if (mysqli_query($this->dtb_con, $query))
            return 1;
        else
            return 0;
    }

    /**
     * @param $tab
     * @param $cols
     * @param $vals
     * @param $flags
     * @return string
     */
    public function gen_insert_query($tab, $cols, $vals, $flags)
    {
        $cols_are = "";
        $vals_are = "";

        for ($i = 0; $i < count($cols); $i++) {
            if ($i == 0) {
                $cols_are = sprintf("( %s", $cols[$i]);
            } else {
                $cols_are = sprintf(" %s , %s", $cols_are, $cols[$i]);
            }
        }
        $cols_are = sprintf(" %s ) ", $cols_are);

        for ($i = 0; $i < count($vals); $i++) {
            if ($i == 0) {
                if ($flags[$i] == 's') {
                    $vals_are = sprintf("( '%s'", $vals[$i]);
                } else if ($flags[$i] == 'd') {
                    $vals_are = sprintf("( %d", $vals[$i]);
                } else if ($flags[$i] == 'f') {
                    $vals_are = sprintf("( %f", $vals[$i]);
                }
            } else {
                if ($flags[$i] == 's') {
                    $vals_are = sprintf(" %s , '%s'", $vals_are, $vals[$i]);
                } else if ($flags[$i] == 'd') {
                    $vals_are = sprintf(" %s , %d", $vals_are, $vals[$i]);
                } else if ($flags[$i] == 'f') {
                    $vals_are = sprintf(" %s , %f", $vals_are, $vals[$i]);
                }
            }
        }

        $vals_are = sprintf(" %s ) ", $vals_are);

        return sprintf("INSERT INTO %s %s VALUES %s", $tab, $cols_are, $vals_are);
    }

    /**
     * @param $query
     * @return bool|resource
     */
    public function execute_query($query)
    {
        return mysqli_query($this->dtb_con, $query);
    }

    /**
     * @param $table
     * @param $col
     * @param $val
     * @return mixed
     */
    public function value_count($table, $col, $val)
    {
        $query = sprintf("SELECT count(%s) FROM %s WHERE %s = %s", $col, $table, $col, $val);
        $v = $this->get_custom_select_query($query, 1);
        return $v[0][0];
    }

    /**
     * @param $query
     * @param $n
     * @return array
     */
    public function get_custom_select_query($query, $n)
    {
        $result = array();
        $res = mysqli_query($this->dtb_con, $query);
        
        if (mysqli_num_rows($res) > 0) {
            $i = 0;
            while ($row = mysqli_fetch_array($res)) {
                for ($j = 0; $j < $n; $j++) {
                    if (isset($row[$j]))
                        $result[$i][$j] = $row[$j];
                }
                $i++;
            }
        }

        return $result;
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @param $name
     * @param $sel
     */
    public function get_drop_down($table, $column, $value, $name, $sel)
    {
        $row = $this->get_row($table, array($column, $value));
        echo "<select name = '" . $name . "' >";
        echo "<option> </option>";
        for ($i = 0; $i < count($row); $i++) {
            if ($sel == $row[$i][1]) {
                echo "<option value = '" . $row[$i][1] . "' selected>" . $row[$i][0] . "</option>";
            } else {
                echo "<option value = '" . $row[$i][1] . "' >" . $row[$i][0] . "</option>";
            }
        }
        echo "</select>";
    }

    /**
     * @param $table
     * @param $col
     * @return mixed
     */
    public function get_row($table, $col)
    {
// Find every $col from $table

        $query = $this->gen_query($table, $col, 0);
        $i = 0;
        $value = null;
        $res = mysqli_query($this->dtb_con, $query);

        while ($row = mysqli_fetch_array($res)) {
            for ($j = 0; $j < count($col); $j++) {
                $value[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $value;
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @param $name
     * @return int
     */
    public function get_all_checkbox($table, $column, $value, $name)
    {
        $row = $this->get_row($table, array($column, $value));
        for ($i = 0; $i < count($row); $i++) {
            echo "<input type= 'checkbox' name= $name$i value= '" . $row[$i][1] . "'  />" . "&nbsp;&nbsp;" . $row[$i][0];
        }
        return count($row);
    }

    /**
     * @param $table
     * @return null
     */
    public function get_column_table($table)
    {
        $query = sprintf("DESC %s", $table);
        $res = $this->get_custom_select_query($query, 6);
        $final_res = null;

        for ($i = 0; $i < count($res); $i++) {
            $final_res[$i] = $res[$i][0];
        }
        return $final_res;
    }

    /**
     * @param $table
     * @param $cols
     * @param $vals
     * @param $flag
     * @param $mat
     * @param $con
     * @param $val
     * @return int
     */
    public function update_column($table, $cols, $vals, $flag, $mat, $con, $val)
    {
        $query = $this->gen_update_query($table, $cols, $vals, $flag, $mat, $con, $val);
        if (mysqli_query($this->dtb_con, $query)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @param $table
     * @param $cols
     * @param $vals
     * @param $flag
     * @param $mat
     * @param $con
     * @param $m_val
     * @return string
     */
    public function gen_update_query($table, $cols, $vals, $flag, $mat, $con, $m_val)
    {
        $num = count($cols);
        $qur = sprintf("UPDATE %s SET", $table);

        for ($i = 0; $i < $num; $i++) {
            if ($flag[$i] == "s") {
                $qur = sprintf("%s %s = '%s'", $qur, $cols[$i], $vals[$i]);
            } else {
                $qur = sprintf("%s %s = %s", $qur, $cols[$i], $vals[$i]);
            }
            if ($i != $num - 1) {
                $qur = sprintf("%s \n,", $qur);
            }
        }

        return $qur = sprintf("%s WHERE %s %s %s", $qur, $mat, $con, $m_val);
    }

    /**
     * @param $ar
     * @param $ind_sho
     * @param $ind_val
     * @param $name
     * @param $sel
     */
    public function get_dropdown_array($ar, $ind_sho, $ind_val, $name, $sel, $class = '', $is_product = false)
    {
        /**
         *  Product Query
         *  [ 0  -> ID,  1 -> Name, 2 -> Unit Name, 3 -> Quantity
         */
        echo "<select name = '" . $name . "' class='" . $class . "' >";
        echo "<option> Select an option</option>";
        $n = count($ar);
        foreach ($ar as $item) {
           // d($item);
            echo "<option value = '" . $item[$ind_sho] . "'";

            if ($sel == $item[$ind_sho])
                echo " selected";

            if ($is_product == true)
                echo "> " . $item[$ind_val] . " ( " . $item[3] . " " . $item[2] . " )";
            else
                echo "> " . $item[$ind_val];

            echo "</option>\n";
        }
        echo "</select>";
    }

    /**
     * @param $ar
     * @param $ind_sho
     * @param $pr_ind
     * @param $ind_val
     * @param $name
     * @param $sel
     */
    public function get_dropdown_pr_array($ar, $ind_sho, $pr_ind, $ind_val, $name, $sel)
    {
        echo "<select name = '" . $name . "' >";
        echo "<option> </option>";
        for ($i = 0; $i < count($ar); $i++) {
            if ($sel == $ar[$i][$ind_val]) {
                echo "<option value = '" . $ar[$i][$ind_sho] . "' selected>" . $ar[$i][$ind_val] . ' ( ' . $ar[$i][$pr_ind] . ' ) ' . "</option>";
            } else {
                echo "<option value = '" . $ar[$i][$ind_sho] . "' >" . $ar[$i][$ind_val] . ' ( ' . $ar[$i][$pr_ind] . ' ) ' . "</option>";
            }
        }
        echo "</select>";
    }

    /**
     * @param $table
     * @param $col
     * @return array|int
     */
    public function column_datatype($table, $col)
    {
        $type = null;
        $query = sprintf("DESC %s", $table);
        $res = $this->get_custom_select_query($query, 5);
        $i = 0;
        $flag = 1;
        while ($flag && $res[$i]) {
            if ($res[$i][0] == $col) {
                $flag = 0;
                break;
            }
            $i++;
        }

        if (!$flag) {
            $res[$i][1];
            $type[0] = strstr($res[$i][1], '(', true);
            $temp = strstr($res[$i][1], '(');
            $n_temp = null;

            for ($j = 1; $j < strlen($temp) - 1; $j++) {
                $n_temp = $n_temp . mb_substr($temp, $j, 1);
            }
            $type[1] = $n_temp;

            return $type;

        } else {
            return -1;
        }
    }

    /**
     * @param $table
     * @param $id
     * @return int|mixed
     */
    public function get_last_id($table, $id)
    {
        $r = $this->get_desc_limit($table, array($id), $id, 0, 1);
        return $r[0][0] + 1;

    }

    /**
     * @param $table
     * @param $col
     * @param $order
     * @param $ll
     * @param $ul
     * @return mixed
     */
    public function get_desc_limit($table, $col, $order, $ll, $ul)
    {
        $i = 0;

        $query = sprintf("%s ORDER BY %s DESC LIMIT %d, %d", $this->gen_query($table, $col, 0), $order, $ll, $ul);
        $res = mysqli_query($this->dtb_con, $query);

        $value[0][0] = 0;
        while ($row = mysqli_fetch_array($res)) {
            for ($j = 0; $j < count($col); $j++) {
                $value[$i][$j] = $row[$j];
            }
            $i++;
        }

        return $value;
    }

}