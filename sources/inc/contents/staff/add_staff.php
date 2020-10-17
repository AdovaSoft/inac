<h1>Add New Staff</h1>
<br/>
<?php


include("sources/inc/usercheck.php");

if (isset($_POST['ab'])) {
    $flag = (isset($_POST['n']) && $_POST['n'] != null && isset($_POST['p']) && $_POST['p'] != null && isset($_POST['s']) && $_POST['s'] >= 0 && isset($_POST['dh']));
    if ($flag) {
        $query = new indquery();
        $date = $inp->get_post_date('jd');
        $id = $query->get_last_id('staff', 'idstaff');
        $query->execute_query('START TRANSACTION');
        $flag = $query->insert_query("staff", array("idstaff", "name", "post", "sallary", "hour"), array($id, $_POST['n'], $_POST['p'], $_POST['s'], $_POST['dh']), array('d', 's', 's', 'f', 'd'));
        if ($flag) {
            $flag = $query->insert_query("staff_joning", array("idstaff", "date"), array($id, $date), array('d', 's'));
        }
        if ($flag) {
            $custom_message = "<h3 class='green'>New Staff Added</h3>";
            $query->execute_query('COMMIT');
        } else {
            $custom_message = "<h3 class='red'>Failed to add staff.</h3>";
            $query->execute_query('ROLLBACK');
            unset($_POST['ab']);
        }
    } else {
        $custom_message = "<h3 class='red'>Please give proper joining date, name, post, sallary</h3>";
    }
} else {
    $custom_message = "<h3 class='blue'>Please give proper information</h3>";
}
echo "<form method = 'POST' class='embossed'>";
echo $custom_message;
echo "<br/>Joining Date : ";
$date = $inp->get_post_date('jd');
if (!$date)
    $date = date("Y-d-m");
$inp->input_date('jd', $date, true);
echo "<br/><br/>";
if (isset($_POST['n']))
    $inp->input_text('Name : ', 'n', $_POST['n']);
else {
    $inp->input_text('Name : ', 'n', null);
}
echo "<br/>";
if (isset($_POST['p']))
    $inp->input_text('Post : ', 'p', $_POST['p']);
else {
    $inp->input_text('Post : ', 'p', null);
}
echo "<br/>";
if (isset($_POST['s']))
    $inp->input_text('Salary : ', 's', $_POST['s']);
else {
    $inp->input_text('Salary : ', 's', null);
}
echo "<br/>";
echo "Duty Hours : ";
if (isset($_POST['dh']))
    $inp->select_digit('dh', 1, 12, $_POST['dh'], 1);
else
    $inp->select_digit('dh', 0, 12, 0, 1);
echo "<br/>";
$inp->input_submit('ab', 'Add');
echo "</form>";
?>