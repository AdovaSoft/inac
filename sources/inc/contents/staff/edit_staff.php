<h1>Edit Staff</h1>
<br/>
<?php
    
    include("sources/inc/usercheck.php");
    if (isset($_POST['ab1'])) {
        $flag = true;
        $qur->execute_query('START TRANSACTION');
        if ($flag) {
            $flag = $qur->update_column('staff', array('name', 'post', 'sallary', 'hour'), array($_POST['n'], $_POST['p'], $_POST['s'], $_POST['dh']), array('s', 's', 'd', 'd'), 'idstaff', '=', $_POST['st']);
        }
        if ($flag) {
            $flag = $qur->update_column('staff_joning', array('date'), array($inp->get_post_date('jd')), array('s'), 'idstaff', '=', $_POST['st']);
        }
        if ($flag) {
            $qur->execute_query('COMMIT');
            echo "<h3 class='green'>Successful</h3><br/>";
        } else {
            $qur->execute_query('ROLLBACK');
            echo "<h3 class='green'>Failed</h3><br/>";
        }
    }
    
    $res = $qur->get_cond_row('staff', array('idstaff', 'name', 'post'), 'status', '=', 1);
    echo "<form method = 'POST' class='embossed'>";
    echo "<h3 class='blue'>Select  staff</h3><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    echo "<select name = 'st' >";
    echo "<option></option>";
    if ($inp->value_pgd('st')) {
        foreach ($res as $r) {
            if ($r[0] == $inp->value_pgd('st'))
                echo "<option value = '" . $r[0] . "' selected > $r[1] ($r[2]) </option>";
            else
                echo "<option value = '" . $r[0] . "' > $r[1] ($r[2]) </option>";
        }
    } else {
        foreach ($res as $r) {
            echo "<option value = '" . $r[0] . "' > $r[1] ($r[2]) </option>";
        }
    }
    echo "</select>";
    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form>";
    
    if (isset($_POST['st']) && $_POST['st'] != null) {
        $flag = true;
        $query = sprintf("SELECT name,post,sallary,date,hour FROM (SELECT * FROM staff WHERE idstaff = %d) as s LEFT JOIN staff_joning USING(idstaff);", $_POST['st']);
        $info = $qur->get_custom_select_query($query, 5);
        echo "<br/><h2>Edit " . $info[0][0] . "</h2>";
        echo "<br/><form method = 'POST' class='embossed'>";
        echo "Joining Date : ";
        $inp->input_date('jd', $info[0][3], true);
        echo "<br/><br/>";
        if (isset($_POST['n']))
            $inp->input_text('Name : ', 'n', $_POST['n']);
        else {
            $inp->input_text('Name : ', 'n', $info[0][0]);
        }
        echo "<br/>";
        if (isset($_POST['p']))
            $inp->input_text('Post : ', 'p', $_POST['p']);
        else {
            $inp->input_text('Post : ', 'p', $info[0][1]);
        }
        echo "<br/>";
        if (isset($_POST['s']))
            $inp->input_text('Salary : ', 's', $_POST['s']);
        else {
            $inp->input_text('Salary : ', 's', $info[0][2]);
        }
        echo "<br/>";
        echo "Duty Hours : ";
        if (isset($_POST['dh']))
            $inp->select_digit('dh', 1, 12, $_POST['dh'], 1);
        else
            $inp->select_digit('dh', 0, 12, $info[0][4], 1);
        $inp->input_hidden('st', $_POST['st']);
        echo "<br/>";
        $inp->input_submit('ab1', 'Edit');
        echo "</form>";
    }

?>
