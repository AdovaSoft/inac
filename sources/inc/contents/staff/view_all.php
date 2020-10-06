<h1>All Staff</h1>
<br/>
<?php
$query = sprintf("SELECT idstaff,name,post,sallary,status FROM staff ORDER by name;");
$info = $qur->get_custom_select_query($query, 5);
echo "<table align='center' class='rb table'>";

echo "<thead><tr><th>Name</th><th>Post</th><th>Sallary</th><th>Status</th></tr></thead>";
echo "<tbody>";
foreach ($info as $i) {
    echo "<tr>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $i[0] . "'>";
    echo $i[1];
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $i[0] . "'>";
    echo $i[2];
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $i[0] . "'>";
    echo $i[3];
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $i[0] . "'>";
    if ($i[4] == 1) {
        echo "<b class='green'> Active</b>";
    } else {
        echo "<b class='red' > Not Active</b>";
    }
    echo "</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>