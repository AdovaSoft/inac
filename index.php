<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
$company = file_get_contents("companyname.txt");

//USER TYPE CONSTANTS
defined('STAFF') || define('STAFF', 0);
defined('ADMIN') || define('ADMIN', 1);
defined('USER') || define('USER', 2);

//Debug Function
function d(...$var)
{
    echo "<pre>";
    var_dump(...$var);
    echo "</pre>";
}

?>
<html>
<head>
  <title><?php echo $company; ?></title>
    <?php
    include("sources/inc/security.php");
    ?>
  <link rel="stylesheet" type="text/css" href="./vendors/DataTables-1.10.22/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="./css/general.css">
  <link rel="stylesheet" type="text/css" href="./css/<?php echo $csschoice; ?>/style.css">

  <!-- JavaScript -->
  <script src="./vendors/jQuery-1.12.4/jquery-1.12.4.js"></script>
  <script src='./js/hidecheck.js'></script>
  <script src='./js/timedateday.js'></script>
  <script src='./js/slideupdown.js'></script>
<!-- dataTables -->
<script src="./vendors/DataTables-1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body onLoad="startTime();">
<div id="topmenu">
    <?php
    include("sources/inc/topmenu.php");
    ?>
</div>
<div id="ttd">
  <div id="date">
      <?php echo date("D, d M Y"); ?>
  </div>
  <div id="digclock">
  </div>
</div>
<center>
  <div id="content">
    <img src="images/blank1by1.gif" class="leftpillar" alt=""/>
    <img src="images/blank1by1.gif" class="rightpillar" alt=""/>
    <br/>
    <h1 id="banner"><?php echo $company; ?></h1><br/>
      <?php
      $page = isset($_GET['page']) ? $_GET['page'] : NULL;
      $sub = isset($_GET['sub']) ? $_GET['sub'] : NULL;
      $section = "contents";
      include("sources/inc/content.php");
      ?>
    <br/>
  </div>
  <div id="ending">
      <?php
      include("sources/inc/ending.php");
      ?>
  </div>
</center>

<script>
    $(document).ready(function () {
        $('body').find('.rb').DataTable({
            "dom": 'rt<"bottom"p>',
            "lengthMenu": false,
            "ordering": true,
            "info": false
        });
    });
</script>
</body>
</html>