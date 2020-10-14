<?php $loginmessage = isset($loginmessage) ? $loginmessage : ''; ?>
  <link rel="stylesheet" type="text/css" href="./css/login.css">
  </head>
  <body>
  <center>
    <br/>
    <h1><?= COMPANY ?></h1>
    <br/>
    <form action="index.php" method="POST" id="loginform" autocomplete="off" spellcheck="false">
        <?php echo $loginmessage; ?>
      <table border="0">
        <tr>
          <th width="25%">User Name :</th>
          <td>
            <input type="text" placeholder="Enter Username"
                     size="255" class="full-width" minlength="3" maxlength="255"
            name="username">
          </td>
        </tr>
        <tr style="padding-top: 20px;">
          <th style="padding-top: 20px;">Password :</th>
          <td style="padding-top: 20px;">
            <input type="password" placeholder="Enter Password"
                   size="255" class="full-width" minlength="3" maxlength="255"
                   name="userpass">
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center; padding-top: 20px">
            <input type="submit" name="submit" value="Submit"/>
          </td>
        </tr>
      </table>
    </form>
  </center>
  <br/><p class="footer">Developed by <a href="http://adovasoft.com/" target="_blank">Adova Soft</a></p>
  </body>
<?php
//don't render more html
exit(0);
?>