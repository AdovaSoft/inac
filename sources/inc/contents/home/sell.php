<form action="index.php?e=<?php echo $encptid ?>&page=home&sub=sell" method="POST" class="embossed">
  <h2>Sell Search</h2>
  <br/>Enter voucher number<br/>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>" required/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php
if (isset($_POST['delete_sell'])) {
    include("sources/inc/contents/sells/delete.php");
}

if (isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Sell Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = (isset($_POST['searchword']) != null) ? $_POST['searchword'] : $_GET['searchword'];
    if ($s == null) {
        echo "<h3 class='red'>Please enter a key word then click search</h3><br/>";
    } else {
        $sell_results = $qur->search_sell($s);
        if (count($sell_results) > 0) {
            echo "<h3>Sells Results</h3><br/>";
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Voucher No";
            echo "</th>";
            echo "<th>";
            echo "Party";
            echo "</th>";
            echo "<th>";
            echo "Date";
            echo "</th>";
            echo "<th width='400'>";
            echo "Actions";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            for ($i = 0; $i < count($sell_results); $i++) {
                echo "<tr>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=sells&sub=overview&id=" . $sell_results[$i][0] . "'>";
                echo $sell_results[$i][0];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=sells&sub=overview&id=" . $sell_results[$i][0] . "'>";
                echo $sell_results[$i][1];
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=sells&sub=overview&id=" . $sell_results[$i][0] . "'>";
                echo $inp->date_convert($sell_results[$i][2]);
                echo "</a>";
                echo "</td>";
                echo "<td>";
                echo "<form method='POST'><input type='hidden' name='searchword' value='" . $_POST['searchword'] . "'/>
                <input type='hidden' name='sell_id' value='" . $sell_results[$i][0] . "'/>
                <input type='submit' name='delete_sell' value='Delete'/></form> ";
                echo "<form method='POST' action='index.php?e=" . $encptid . "&page=sells&sub=return'>
                <input type='hidden' name='v' value='" . $sell_results[$i][0] . "'/>
                <input type='submit' name='ab' value='Edit'/></form> ";
                echo "<form method='POST' id='printBox' action='print.php?e=" . $encptid . "&page=sells&sub=sell' target='_blank'>
                <input type='hidden' name='vou' value='" . $sell_results[$i][0] . "'/>
                <input type='submit' name='print' value='Print Invoice'/></form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            /*create a link using res1[i][1] to Sales Return 'selles_ret' page*/

        } else {
            echo "<h3 class='blue'>No sells records found</h3><br/>";
        }
    }
}
?>