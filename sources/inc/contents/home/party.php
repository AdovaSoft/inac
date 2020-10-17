<form action="index.php?e=<?php echo $encptid ?>&page=home&sub=party" method="POST" class="embossed">
  <h2>Party Search</h2>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>" required/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<br/>
<?php
    if (isset($_POST['submit']) && isset($_POST['searchword'])) {
        $searchword = $_POST['searchword'];
        echo "<h3>Party Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
        $s = null;
        $s = $_REQUEST['searchword'];
        if (strlen($s) < 1) {
            echo "You cant search on empty string";
        } else {
            $con = new indquery();
            $part_results = $con->search_party($s);
            $n = count($part_results);
            
            if ($n > 0) {
                echo "<table align='center' class='rb table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>";
                echo "Name";
                echo "</th>";
                echo "<th>";
                echo "Address";
                echo "</th>";
                echo "<th>";
                echo "Phone";
                echo "</th>";
                echo "<th>";
                echo "Email";
                echo "</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                for ($i = 0; $i < $n; $i++) {
                    echo "<tr>";
                    echo "<th>";
                    echo "<a href='index.php?e=" . $encptid . "&page=party&sub=view_particular&id=" . $part_results[$i][0] . "'>";
                    echo esc($part_results[$i][1]);
                    echo "</a>";
                    echo "</th>";
                    
                    echo "<td>";
                    echo "<a href='index.php?e=" . $encptid . "&page=party&sub=view_particular&id=" . $part_results[$i][0] . "'>";
                    echo esc($part_results[$i][2]);
                    echo "</a>";
                    echo "</td>";
                    
                    echo "<td>";
                    echo "<a href='index.php?e=" . $encptid . "&page=party&sub=view_particular&id=" . $part_results[$i][0] . "'>";
                    echo esc($part_results[$i][3], true);
                    echo "</a>";
                    echo "</td>";
                    
                    echo "<td>";
                    echo "<a href='index.php?e=" . $encptid . "&page=party&sub=view_particular&id=" . $part_results[$i][0] . "'>";
                    echo esc($part_results[$i][4]);
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