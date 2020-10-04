<?php


/**
 * Class html
 */
class html
{
    /**
     * @param $name
     * @return string
     */
    public function extra_string($name)
    {
        $value = $this->value_pgd($name);
        if ($value != null) {
            $extention = "&&" . $name . "=" . $value;
        } else {
            $extention = "";
        }
        return $extention;
    }

    /**
     * @param $name
     * @param null $default_value
     * @return mixed|null
     */
    public function value_pgd($name, $default_value = null)
    {
        return (isset($_REQUEST[$name])) ? $_REQUEST[$name] : $default_value;
    }

    /**
     * @param $label
     * @param $name
     * @param $value
     * @param null $class
     * @param null $id
     */
    public function input_text($label, $name, $value, $class = null, $id = null)
    {
        echo $label . " <input type='text' step='any' name = '" . $name . "' value = '" . $value . "' class = '" . $class . "' id = '" . $id . "' /> <br/>";
    }

    public function input_number($label, $name, $value, $class = null, $id = null)
    {
        echo $label . " <input type='number' step='0.01' name = '" . $name . "' value = '" . $value . "' class = '" . $class . "' id = '" . $id . "' /> <br/>";
    }

    /**
     * @param $name
     * @param $value
     */
    public function input_hidden($name, $value)
    {
        echo " <input type = 'hidden' name = '" . $name . "' value = '" . $value . "' />";
    }

    /**
     * @param $i
     */
    public function print_month($i)
    {

        if ($i == 1 || $i == '01') {
            echo "January";
        } else if ($i == 2 || $i == '02') {
            echo "February";
        } else if ($i == 3 || $i == '03') {
            echo "March";
        } else if ($i == 4 || $i == '04') {
            echo "April";
        } else if ($i == 5 || $i == '05') {
            echo "May";
        } else if ($i == 6 || $i == '06') {
            echo "June";
        } else if ($i == 7 || $i == '07') {
            echo "July";
        } else if ($i == 8 || $i == '08') {
            echo "August";
        } else if ($i == 9 || $i == '09') {
            echo "September";
        } else if ($i == 10) {
            echo "October";
        } else if ($i == 11) {
            echo "November";
        } else if ($i == 12) {
            echo "December";
        }
    }

    /**
     * @param $m
     * @param $y
     * @return int|null
     */
    public function print_month_days($m, $y)
    {
        if (($m == 4) || ($m == 6) || ($m == 9) || ($m == 11)) {
            return 30;
        } elseif (($m == 1) || ($m == 3) || ($m == 5) || ($m == 7) || ($m == 8) || ($m == 10) || ($m == 12)) {
            return 31;
        } elseif ($m == 2) {
            if (($y % 4) == 0) {
                return 29;
            } else {
                return 28;
            }
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function input_submit($name, $value)
    {
        echo "<br/> " . " <input type = 'submit' name = '" . $name . "' value = '" . $value . "' /> <br/>";
    }

    /**
     * @param $name
     * @param $sel
     */
    public function select_month($name, $sel)
    {
        echo "<select name = '" . $name . "' >";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $sel)
                echo "<option selected value = '" . $i . "' >";
            else {
                echo "<option value = '" . $i . "' >";
            }
            if ($i == '01') {
                echo "Jan </option>";
            } else if ($i == '02') {
                echo "Feb </option>";
            } else if ($i == '03') {
                echo "Mar </option>";
            } else if ($i == '04') {
                echo "Apr </option>";
            } else if ($i == '05') {
                echo "May </option>";
            } else if ($i == '06') {
                echo "Jun </option>";
            } else if ($i == '07') {
                echo "Jul </option>";
            } else if ($i == '08') {
                echo "Aug </option>";
            } else if ($i == '09') {
                echo "Sep </option>";
            } else if ($i == 10) {
                echo "Oct </option>";
            } else if ($i == 11) {
                echo "Nov </option>";
            } else if ($i == 12) {
                echo "Dec </option>";
            }
        }
        echo "</select>";
    }

    /**
     * @param $label
     * @param $name
     * @param $value
     * @param $sel
     */
    public function input_radio($label, $name, $value, $sel)
    {
        if ($sel == 1)
            echo " <input type = 'radio' name = '" . $name . "' value = '" . $value . "' checked /> " . $label;
        else
            echo " <input type = 'radio' name = '" . $name . "' value = '" . $value . "'/> " . $label;
    }

    /**
     * @param $label
     * @param $name
     * @param $value
     * @param $sel
     */
    public function input_checkbox($label, $name, $value, $sel)
    {
        if ($sel)
            echo " <input type = 'checkbox' name = '" . $name . "' value = '" . $value . "' checked /> " . $label;
        else
            echo " <input type = 'checkbox' name = '" . $name . "' value = '" . $value . "'/> " . $label;
    }

    /**
     * @param $label
     * @param $a
     * @return bool
     */
    public function check($label, $a)
    {
        if (isset($_POST['a']) && $_POST[$a] != null) {
            return true;
        }
        if (isset($label))
            echo $label . " is missing <br/>";
        return false;
    }

    /**
     * @param $label
     * @param $a
     * @return bool
     */
    public function isPositive($label, $a)
    {
        if ($_POST[$a] > 0) {
            return true;
        }
        echo $label . "<br/>";
        return false;
    }

    /**
     * @param $p
     * @return int|string
     */
    public function get_post_date($p)
    {
        if (isset($_POST[$p . '_y']) && isset($_POST[$p . '_m']) && isset($_POST[$p . '_d']))
            return $_POST[$p . '_y'] . '-' . $_POST[$p . '_m'] . '-' . $_POST[$p . '_d'];
        else
            return false;
    }

    /**
     * @param $n
     * @param $t
     */
    public function input_date($n, $t)
    {
        //Date 2020-01-01
        $t = explode("-", $t);
        $y = intval($t[0]);
        $m = str_pad(intval($t[1]), 2, '0', STR_PAD_LEFT);
        $d = str_pad(intval($t[2]), 2, '0', STR_PAD_LEFT);

        $yless = date('Y') - 10;
        $ymore = date('Y') + 10;

        $this->select_digit($n . '_d', 1, 31, $d, 1);
        $this->select_digit($n . '_m', 1, 12, $m, 1);
        $this->select_digit($n . '_y', $yless, $ymore, $y, 1);
    }

    /**
     * @param $name
     * @param $from
     * @param $to
     * @param $sel
     * @param $int
     */
    public function select_digit($name, $from, $to, $sel, $int)
    {
        echo "<select name = '" . $name . "' > ";
        for ($i = $from; $i <= $to; $i = $i + $int) {
            if ($sel == $i)
                echo "<option selected>" . $i . "</option>";
            else
                echo "<option >" . $i . "</option>";
        }
        echo "</select>";
    }

    /**
     * @param $date
     * @return false|string
     */
    public function date_convert($date)
    {
        if ($date == "0000-00-00" || (!$date))
            return "";
        elseif ($date == date("Y-m-d"))
            return "Today";
        else
            return $newDate = date("d M Y (D)", strtotime($date));
    }

    /**
     * @param $t
     * @return bool
     */
    public function date_valid($t)
    {
        $y = $t[0] . $t[1] . $t[2] . $t[3];
        $m = $t[5] . $t[6];
        $d = intval($t[8] . $t[9]);
        return checkdate($m, $d, $y);
    }
}
