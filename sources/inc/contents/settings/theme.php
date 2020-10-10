<?php
$custom_message = '';
if (isset($_GET['say'])) {
    if ($_GET['say'] == 1) {
        $custom_message = "<h3 class='green'>Theme Changed successfully.</h3>";
    } elseif ($_GET['say'] == 2) {
        $custom_message = "<h3 class='red'>Could not change theme.</h3>";
    } elseif ($_GET['say'] == 3) {
        $custom_message = "<h3 class='faintred'>Please Select a theme then click change.</h3>";
    }
} else {
    $custom_message = "<h3 class='blue'>Please Select a theme.</h3>";
}
?>
<h2>Theme Settings</h2>
<br/>
<form action="editor.php" method="POST" class="embossed">
  <img src="images/blank1by1.gif" class="customwidth" alt="" width="350px"/>
  <br/>
    <?php
    echo $custom_message;
    if (isset($_GET['say']) && $_GET['say'] == 1) {
        //echo '<br/><input type="button"  onclick="location.reload();" name="something" value="Refresh Page" />';
    } ?>

  <br/><select name="newcss" class="full-width">
    <option value="<?= $_SESSION['theme'] ?>">Current theme</option>
    <option value="1">Blue Sky</option>
    <option value="2">Black Steal</option>
    <option value="3">Grey Steal</option>
    <option value="4">White Marble</option>
    <option value="5">Royal Blue</option>
    <option value="6">Orange Harvest</option>
    <option value="7">Green Moss</option>
    <option value="8">Dark Shadow</option>
    <option value="9">Navy Blue</option>
    <option value="10">Royal Red</option>
    <option value="11">Brown Earth</option>
    <option value="12">Agro</option>
    <option value="13">Agro Pro</option>
  </select>
  <input type="hidden" name="editor" value="settings/theme"/>
  <input type="hidden" name="e" value="<?php echo $encptid; ?>"/>
  <input type="hidden" name="returnlink" value="index.php?page=settings&sub=theme&e=<?php echo $encptid; ?>"/>
  <br/>
  <br/><input type="submit" name="change" value="Change"/>
  <br/>
</form>