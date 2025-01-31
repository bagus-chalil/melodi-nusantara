$(document).ready(function() {
    $('#datatable').DataTable({
        language: {
            lengthMenu: "Show _MENU_ entries",
        }
    });

    $('.datatable').DataTable({
        language: {
            lengthMenu: "Show _MENU_ entries",
        }
    });

    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
} );


