$(document).ready(function () {
    $(window).load(function () {
        $(".rate").each(function () {
            var rate = $(this).attr("id");
            $("#total_td" + rate.slice(4)).html($("#quantity" + rate.slice(4)).val() * $(this).val());
        });
        process_grand_total(0);
        netCharge();
    });
    $(".quantity").keyup(function () {
        calculate($(this).attr("id"), "rate", 8);
    });
    $(".rate").keyup(function () {
        calculate($(this).attr("id"), "quantity", 4);
    });
    $("#discount").keyup(function () {
        netCharge();
    });
});

function calculate(multiplier, multiplicand, sliced) {
    var total = parseFloat($("#" + multiplicand + multiplier.slice(sliced)).val() * $("#" + multiplier).val());
    $("#total_td" + multiplier.slice(sliced)).html(total);
    process_grand_total(0);
}

function process_grand_total(sum) {
    $(".total_td").each(function () {
        console.log("fine");
        sum += parseFloat($(this).html());
    });
    $("#grand_total").html(sum);
    netCharge();
}

function netCharge() {
    $("#netcharges").html(parseFloat($("#grand_total").html()) - parseFloat($("#discount").val()));
}