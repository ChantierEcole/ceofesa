(function ( $ ) {
    'use strict';

    $(document).ready(function() {
        var deleteButton;

        $(document).on('click', '.btn-confirm',function(e) {
            e.preventDefault();

            deleteButton = $(this);

            if (deleteButton.is("a")) {
                $('#confirmation-modal #confirmation-modal-confirm').attr('href', deleteButton.attr('href'));
            }

            $('#confirmation-modal').modal('show');
        });

        $('#confirmation-modal #confirmation-modal-confirm').click(function(e) {
            if (deleteButton.is("button")) {
                e.preventDefault();
                deleteButton.closest('form').submit();
            }
        });
    });
})( jQuery );
