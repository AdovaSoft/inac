<?php
if ($_GET['say'] == 1) {
    $custom_message = "<h3 class='green'>Theme Changed successfully.</h3>";
} elseif ($_GET['say'] == 2) {
    $custom_message = "<h3 class='red'>Could not change theme.</h3>";
} elseif ($_GET['say'] == 3) {
    $custom_message = "<h3 class='faintred'>Wrong Password.</h3>";
} elseif ($_GET['say'] == 4) {
    $custom_message = "<h3 class='faintgreen'>Retyped password Mismatch.</h3>";
} elseif ($_GET['say'] == 5) {
    $custom_message = "<h3 class='faintred'>Please fill all the fields.</h3>";
} else {
    $custom_message = "<h3 class='blue'>Please fill the fields.</h3>";
}
?>
<h2>Change Password</h2>
<br/>
<form action="editor.php" method="POST" class="embossed">
  <img src="images/blank1by1.gif" class="customwidth" alt="" width="350px"/>
  <br/><?php echo $custom_message; ?>
  <br/>Previous Password : <input type="password" name="oldpass1"/>
  <br/>
  <br/>Retype Previous &nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" name="oldpass2"/>
  <br/>
  <br/>
  <br/>New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="password" name="newpass1"/>
  <br/>
  <br/>Retype New &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="password"
                                                                                             name="newpass2"/>
  <input type="hidden" name="editor" value="settings/pass"/>
  <input type="hidden" name="e" value="<?php echo $encptid; ?>"/>
  <input type="hidden" name="returnlink" value="index.php?page=settings&&sub=pass&&e=<?php echo $encptid; ?>"/>
  <br/>
  <br/><input type="submit" name="change" value="Change"/>
  <br/>
</form>