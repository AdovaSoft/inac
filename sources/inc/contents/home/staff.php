<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=staff" method="POST" class="embossed">
  <h2>Staff Search</h2>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>" required/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php
if (isset($_POST['submit']) && isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Staff Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = ( isset($_POST['searchword']) != null ) ? $_POST['searchword'] : $_GET['searchword'];
    if ($s == null) {
        echo "<br/><h3 class='red'>You cant search on empty string</h3>";
    } else {

        $con = new indquery();
        $res = $con->search_staff($s);
        $n = count($res);

        if ($n > 0) {
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Name";
            echo "</th>";
            echo "<th>";
            echo "Post";
            echo "</th>";
            echo "<th>";
            echo "Salary";
            echo "</th>";
            echo "<th>";
            echo "Status";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<th>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo $res[$i][1];
                echo "</a>";
                echo "</th>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo $res[$i][2];
                echo "</a>";
                echo "</td>";

                echo "<td class='text-right pr-50'>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo money($res[$i][3]);
                echo "</a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                if ($res[$i][4]) {
                    echo "<span class='green'>active</span>";
                } else {
                    echo "<span class='red'>inactive</span>";
                }
                echo "</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

        } else {
            echo "<h3>Nothing Found</h3>";
        }
    }

}
?>