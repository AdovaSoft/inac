<?php $loginmessage = isset($loginmessage) ? $loginmessage : ''; ?>
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<center>
  <br/>
  <h1><?php echo $company; ?></h1>
  <br/>
  <form action="index.php" method="POST" id="loginform">
      <?php echo $loginmessage; ?>
    User Name : <input type="text" name="username"/>
    <br/>
    <br/>Password &nbsp;&nbsp;: <input type="password" name="userpass"/>
    <br/>
    <br/><input type="submit" name="submit" value="Submit"/>
    <br/>
    <br/>
  </form>
  <br/><small>Developed by <a href="http://adovasoft.com/" target="_blank">Adova Soft</a></small>
</center>
</body>
<?php
//don't render more html
exit(0);
?>