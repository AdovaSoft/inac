<?php

/**
 * @param $userid
 * @param $userpass
 * @return array|int|null
 */
function login_check($userid, $userpass)
{
    $con = mysqli_connect($_SERVER['HOST'], $_SERVER['USER'], $_SERVER['PASS'], $_SERVER['DBASE']);
    $encuserpass = md5(mysqli_real_escape_string($con, $userpass));
    $userid = mysqli_real_escape_string($con, $userid);
    $qstring = sprintf("SELECT idstaff,pass,type,css FROM user LEFT JOIN staff USING(idstaff) WHERE pass='%s' AND name='%s'", $encuserpass, $userid);
    $q = mysqli_query($con, $qstring);

    if (mysqli_num_rows($q) > 0) {
        $result = mysqli_fetch_array($q);
        mysqli_close($con);
        return $result;
    } else {
        mysqli_close($con);
        return 0;
    }
}

function login_check_session($userid, $userpass)
{
    $con = mysqli_connect($_SERVER['HOST'], $_SERVER['USER'], $_SERVER['PASS'], $_SERVER['DBASE']);
    $qstring = sprintf("SELECT css FROM user LEFT JOIN staff USING(idstaff) WHERE pass='%s' AND name='%s'", $userpass, $userid);
    $q = mysqli_query($con, $qstring);
    if (mysqli_num_rows($q) > 0) {
        $result = mysqli_fetch_array($q);
        mysqli_close($con);
        return $result;
    } else {
        mysqli_close($con);
        return 0;
    }
}