<?php
if ($page && $sub) {
    $section = $section . "/" . $page;
    $page = $sub;
}

if ($page) {
    $path = "sources/inc/" . $section . "/" . $page . ".php";
    if (file_exists("$path")) {
        include("$path");
    } else {
        include("sources/inc/contents/default.php");
    }
} else {
    include("sources/inc/" . $section . "/home.php");
}
?>