function calculate(multiplier, multiplicand, sliced) {
    var total = $("#" + multiplicand + multiplier.slice(sliced)).val() * $("#" + multiplier).val();
    $("#total_td" + multiplier.slice(sliced)).html(parseFloat(total).toFixed(2));
    process_grand_total(0);
}

function process_grand_total(sum) {
        $(".total_td").each(function () {
            sum += parseFloat($(this).html());
        });
    $("#grand_total").html(sum.toFixed(2));
    netCharge();
}

function netCharge() {
    $("#netcharges").html((parseFloat($("#grand_total").html()) - parseFloat($("#discount").val())).toFixed(2));
}

$(document).ready(function () {
    $(".rate").each(function () {
        var rate = $(this).attr("id");
        $("#total_td" + rate.slice(4)).html($("#quantity" + rate.slice(4)).val() * $(this).val());
        process_grand_total(0);
        netCharge();
    });
});
$(".quantity").keyup(function () {

    calculate($(this).attr("id"), "rate", 8);
});

$(".rate").keyup(function () {

    calculate($(this).attr("id"), "quantity", 4);
});

$("#discount").change(function () {
    netCharge();
});
