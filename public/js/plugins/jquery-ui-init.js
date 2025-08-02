(function ($) {
    'use strict'
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        duration: "fast",

    });
    var dateFormat = "dd-mm-yy",
        from = $("#datepickerFrom")
            .datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
        to = $("#datepickerTo").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,

        })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }


    
})(jQuery);

$(function () {

    $('#monthPicker').monthpicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM yy',

    });
});