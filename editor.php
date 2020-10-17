<?php
    include("./sources/inc/system.php");
    include("./sources/inc/security_o.php");
    $editor = isset($_POST['editor']) ? $_POST['editor'] : 'settings/theme';
    $return_link = isset($_POST['returnlink']) ? $_POST['returnlink'] : 'index.php?e=' . $encptid;
    if ($editor && $return_link) {
        $path = "./sources/inc/editor/" . $editor . ".php";
        if (file_exists($path)) {
            include "$path";
            if (isset($_POST['more_input']) && isset($_POST['num'])) {
                $more = $_POST['num'] + 1;
                $extra_string .= "&&num=" . $more . "&&say=input_added";
            }
            header("Location:" . $return_link . $extra_string);
        } else {
            header("Location:" . $return_link);
        }
    } else {
        header("Location:index.php?e=' . $encptid");
    }
