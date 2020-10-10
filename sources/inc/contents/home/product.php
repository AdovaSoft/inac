<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=product" method="POST" class="embossed">
  <h2>Product Search</h2>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>" required/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php
if (isset($_POST['submit']) && isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Product Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = (isset($_POST['searchword']) != null )? $_POST['searchword'] : $_GET['searchword'];
    if ($s == null) {
        echo "<br/><h3>You cant search on empty string</h3><br/>";
    } else {

        $con = new indquery();
        $res = $con->search_product($s);
        $n = count($res);

        if ($n > 0) {
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Product";
            echo "</th>";
            echo "<th>";
            echo "Stock";
            echo "</th>";
            echo "<th>";
            echo "Unit";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td><a href='index.php?e=" . $encptid . "&&page=product&&sub=particular_product&&id=" . $res[$i][0] . "'>";
                echo $res[$i][1];
                echo "</a></td>";

                echo "<td><a href='index.php?e=" . $encptid . "&&page=product&&sub=particular_product&&id=" . $res[$i][0] . "'>";
                echo $res[$i][2];
                echo "</a></td>";

                echo "<td><a href='index.php?e=" . $encptid . "&&page=product&&sub=particular_product&&id=" . $res[$i][0] . "' >";
                echo $res[$i][3];
                echo "</a></td>";

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            /*create a link using res[i][0] to show 'par_pro_ov' that was using post method to show make necessary changes page*/
        } else {
            echo "<h3>Nothing Found</h3>";
        }
    }
}
?>