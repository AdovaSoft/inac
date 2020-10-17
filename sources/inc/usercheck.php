<?php
if (isset($usertype) && $usertype != ADMIN) {
    echo "<h1 class='red'>You are not permitted to use this page.</h1></center></body></div></center></body></html>";
    die();
}