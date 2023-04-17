$(document).ready(function(){
    const dateFrom = $('input[name=\"date_from\"]');
    const dateTo   = $('input[name=\"date_to\"]');


    if (dateFrom.hasClass('is-invalid')) {
        dateFrom.parent(2).find(".invalid-feedback").first().css('display', 'block');
    }

    if (dateTo.hasClass('is-invalid')) {
        dateTo.parent(2).find(".invalid-feedback").first().css('display', 'block');
    }

    if (dateFrom.length) {
        dateFrom.wrapAll('<div class="datepicker-container"></div>');
        dateTo.wrapAll('<div class="datepicker-container"></div>');

        $("<i class=\"bi bi-calendar-date input-group-text\"></i>").insertBefore('input[name=\"date_from\"]');
        $("<i class=\"bi bi-calendar-date input-group-text\"></i>").insertBefore('input[name=\"date_to\"]');
        const applicationDateRange = document.getElementById('applicationDateRange');
        let minDate = new Date();
        minDate.setDate(minDate.getDate() + 1);
        const rangePicker = new DateRangePicker(applicationDateRange, {
            'format': "dd-mm-yyyy",
            minDate: minDate,
            daysOfWeekDisabled: [0,6]
        });

        $("#submitApplication form").submit( function () {
            if (dateFrom[0].value !== "") {
                const from = moment(dateFrom[0].value, "DD-MM-YYYY")
                dateFrom[0].value = from.format('YYYY-MM-DD');
            }

            if (dateTo[0].value !== "") {
                const to = moment(dateTo[0].value, "DD-MM-YYYY")
                dateTo[0].value = to.format('YYYY-MM-DD');
            }

            return true;
        });
    }
});