<table border="0px" align="center" class="roundangled20" width="700px" height="480px">
  <tr>
    <td colspan="2">
      <h2>Party Search</h2>
      <br/>
      <form action="index.php?e=<?php echo $encptid ?>&page=home&sub=party" method="POST">
        <input type="text" name="searchword" class="searchword"/>
        <br/>
        <br/><input type="submit" name="submit" value="Search"/>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <h2>Product Search</h2>
      <br/>
      <form action="index.php?e=<?php echo $encptid ?>&page=home&sub=product" method="POST">
        <input type="text" name="searchword" class="searchword"/>
        <br/>
        <br/><input type="submit" name="submit" value="Search"/>
      </form>
    </td>
    <td>
      <h2>Staff Search</h2>
      <br/>
      <form action="index.php?e=<?php echo $encptid ?>&page=home&sub=staff" method="POST">
        <input type="text" name="searchword" class="searchword"/>
        <br/>
        <br/><input type="submit" name="submit" value="Search"/>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <h2>Sell Search</h2>
      <br/>Enter voucher number<br/>
      <form action="index.php?e=<?php echo $encptid ?>&page=home&sub=sell" method="POST">
        <input type="text" name="searchword" class="searchword"/>
        <br/>
        <br/><input type="submit" name="submit" value="Search"/>
      </form>
    </td>
    <td>
      <h2>Purchase Search</h2>
      <br/>Enter voucher number<br/>
      <form action="index.php?e=<?php echo $encptid ?>&page=home&sub=purchase" method="POST">
        <input type="text" name="searchword" class="searchword"/>
        <br/>
        <br/><input type="submit" name="submit" value="Search"/>
      </form>
    </td>
  </tr>
</table>