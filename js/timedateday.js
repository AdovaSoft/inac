function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    if (h > 12) {
        h = h - 12;
        document.getElementById('digclock').innerHTML = h + ":" + m + ":" + s + " PM, ";
    } else {
        if (h == 0) {
            h = 12;
        }
        document.getElementById('digclock').innerHTML = h + ":" + m + ":" + s + " AM, ";
    }
    t = setTimeout('startTime()', 500);
}