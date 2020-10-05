var visible;
var totalElements;
var speed = 1000;
var autospeed = 5000;

function hideAllButZero(total) {
    for (var i = 1; i < total; i++) {
        workon = "div#" + "sud" + i;
        $(workon).hide(speed);
    }
    workon = "div#" + "sud" + "0";
    $(workon).show(speed);
    visible = 0;
    totalElements = total;
}

function showit(num) {
    if (visible !== num) {
        showtable = "div#" + "sud" + num;
        $(showtable).show(speed);
        hidetable = "div#" + "sud" + visible;
        $(hidetable).hide(speed);
        visible = num;
    } else {
        hidetable = "div#" + "sud" + num;
        $(hidetable).hide(speed);
        visible = -1;
    }
    $("a#showAll").show();
    $("a#hideAll").show();
}

function showAll() {
    for (var i = 0; i < totalElements; i++) {
        workon = "div#" + "sud" + i;
        $(workon).show(speed);
    }
    $("a#showAll").hide();
    $("a#hideAll").show();
    visible = -1;
}

function hideAll() {
    for (var i = 0; i < totalElements; i++) {
        workon = "div#" + "sud" + i;
        $(workon).hide(speed);
    }
    $("a#showAll").show();
    $("a#hideAll").hide();
    visible = -1;
}