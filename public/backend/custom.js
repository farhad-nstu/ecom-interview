/**
 * App Main Scripts
 * ------------------
 * Use only for function calls and Plugin calls.
 */


if ($('#windowmodal').length) {
    $('.modal').on('shown.bs.modal', function(e) {
        var target = $(e.relatedTarget);
        $.ajax({
            url: target[0].href,
            success: function(response) {

                $('#windowmodal .modal-content').html(response);
                $('#windowmodal .modal-title').html('<input type="hidden" id="modal_hidden" value="1">');
            }
        });
        // $(this).find('.modal-content').load(target[0].href);
    });


    $(".modal").on("hide.bs.modal", function(e) {
        if ($('.dismiss').data('reload')) {
            location.reload();
        } else {
            $(".modal-body").html("");
        }

    });
}

if ($('.dateOfBirth').length) {
    $(function() {
        $(".dateOfBirth").datepicker({
            showAnim: "slide",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
        });
    });
}

if ($('.timePicker').length) {
    (function($) {
        "use strict";
        $(function() {
            $('.timePicker').timepicker({
                'scrollDefault': 'now',
                'timeFormat': 'H:i',
                'step': 5
            });
        });
    })(jQuery);
}