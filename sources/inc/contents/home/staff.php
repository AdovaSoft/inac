<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=staff" method="POST" class="embossed">
  <h2>Staff Search</h2>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>"/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php
if (isset($_POST['submit']) && isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Staff Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = ($_POST['searchword'] != null ? $_POST['searchword'] : $_GET['searchword']);
    if ($s == null) {
        echo "<br/><h3 class='red'>You cant search on empty string</h3>";
    } else {

        $con = new indquery();
        $res = $con->search_staff($s);
        $n = count($res);

        if ($n > 0) {
            echo "<table align='center' class='rb'>";
            echo "<tr>";
            echo "<th>";
            echo "Name";
            echo "</th>";
            echo "<th>";
            echo "Post";
            echo "</th>";
            echo "<th>";
            echo "Sallary";
            echo "</th>";
            echo "<th>";
            echo "Post";
            echo "</th>";
            echo "</tr>";

            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo $res[$i][1];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo $res[$i][2];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                echo $res[$i][3];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=report&&s=" . $res[$i][0] . "'>";
                if ($res[$i][4]) {
                    echo "active";
                } else {
                    echo "inactive";
                }
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