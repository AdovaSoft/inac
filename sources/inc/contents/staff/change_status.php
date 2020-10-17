<h1 class="blue">Change Staff Status</h1>
<br/>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab']) && isset($_POST['id'])) {
    $query = sprintf("UPDATE staff SET status = not status WHERE idstaff = %d", $_POST['id']);
    if (!$qur->execute_query($query)) {
        echo "operation was failed";
    }
}

if (true) {
    $query = sprintf("SELECT idstaff,name,post,status FROM staff ORDER by name;");


    $info = $qur->get_custom_select_query($query, 4);
    echo "<table align='center' class='rb table'>";
    echo "<thead><tr><td>Name</td><td>Post</td><td>Status</td><td>Change</td></tr></thead>";
    echo "<tbody>";
    foreach ($info as $i) {
        echo "<tr>";
        echo "<form method = 'POST' >";
        echo "<input type = 'hidden' name = 'id' value = '" . $i[0] . "'>";
        echo "<td>";
        echo $i[1];
        echo "</td>";
        echo "<td>";
        echo $i[2];
        echo "</td>";
        echo "<td>";
        if ($i[3] == 1) {
            echo "<b class='green'> Active</b>";
        } else {
            echo "<b class='red' > Not Active</b>";
        }
        echo "</td>";
        echo "<td>";
        echo "<input type ='submit' name = 'ab' value = 'Change' />";
        echo "</td>";
        echo "</form>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

}

?>