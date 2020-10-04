<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=party" method="POST" class="embossed">
  <h2>Party Search</h2>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>"/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<br/>
<?php
if (isset($_POST['submit']) && isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<h3>Party Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = ($_POST['searchword'] != null ? $_POST['searchword'] : $_GET['searchword']);
    if ($s == null) {
        echo "You cant search on empty string";
    } else {
        $con = new indquery();
        $res = $con->search_party($s);
        $n = count($res);

        if ($n > 0) {
            echo "<table align='center' class='rb'>";
            echo "<tr>";
            echo "<td>";
            echo "Name";
            echo "</td>";
            echo "<td>";
            echo "Address";
            echo "</td>";
            echo "<td>";
            echo "Phone";
            echo "</td>";
            echo "</tr>";

            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $res[$i][0] . "'>";
                echo $res[$i][1];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $res[$i][0] . "'>";
                echo $res[$i][2];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $res[$i][0] . "'>";
                echo $res[$i][3];
                echo "</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h3>Nothing Found</h3>";
        }
    }
}
?>