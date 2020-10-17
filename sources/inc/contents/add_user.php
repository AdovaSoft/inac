<h1>Add New User</h1>
<br/>
<?php
    
    include("sources/inc/usercheck.php");
    if (isset($_POST['ab'])) {
        if (isset($_POST['s']) && $_POST['s'] != null && $_POST['p'] != null) {
            $qur->execute_query('START TRANSACTION');
            $flag = $qur->insert_query('user', array('idstaff', 'pass', 'type', 'css'), array($_POST['s'], MD5($_POST['p']), 0, 8), array('d', 's', 'd', 'd'));
            
            if ($flag) {
                $custom_message = "<h3 class='green'>User Successfully Added</h3><br/>";
                $qur->execute_query('COMMIT');
            } else {
                $qur->execute_query('ROLLBACK');
                $custom_message = "<h3 class='red'>Failed to Add</h3><br/>";
            }
        }
    } else {
        $custom_message = "<h3 class='blue'>Please Select a staff to add as user</h3><br/>";
    }
    echo "<form method = 'POST' class='embossed'>";
    echo $custom_message;
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $res = $qur->get_cond_row('staff', array('idstaff', 'name', 'post'), 'status', '=', 1);
    echo "<select name = 's' >";
    echo "<option></option>";
    if ($inp->value_pgd('s')) {
        foreach ($res as $r) {
            if ($r[0] == $inp->value_pgd('s'))
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
    echo "<br/><br/>Password : ";
    echo "<input type = 'password' name = 'p' value = '' /><br/>";
    $inp->input_submit('ab', 'Add');
    echo "</form>";
?>
