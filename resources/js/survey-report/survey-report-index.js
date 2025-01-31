$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-report-survey').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/survey-report/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            {
                data: 'type_report',
                name: 'type_report',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
    });

    $('#datatable-report-survey').on('click', '.detail-action', function (e) {
        e.preventDefault();
        let type_report = $('#type_report').val();
        let id = $(this).data('id');

        let url = '';
        if (type_report == 1) {
            url = 'view-survey-responden'
        } else if(type_report == 2) {
            url = 'view-survey-entity'
        } else {
            url = 'view-survey-gap'
        }
        window.location.href = `/survey-report/${url}/${id}`;
    });

    // Show modal Export data
    $('#datatable-report-survey').on('click', '.export-action', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $('#modalExportResult #id_survey').val(id);
        $('#modalExportResult').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#exportDataResult').prop('disabled', false);
        $('#exportDataResult').text('Submit');
    });

    // Export Form Data
    $('#exportDataResult').click(async function (e) {
        e.preventDefault();

        let button = $(this);
        button.prop('disabled', true).text("Loading...");

        let formData = {
            division: $('#division').val(),
            survey_id: $('#id_survey').val(),
        };

        try {
            await getCsrfToken();

            // Ajax Post Request
            $.ajax({
                type: "POST",
                url: "/survey-report/export-result",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (response, status, xhr) {
                    let filename = "";
                    let disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        let matches = /filename="([^"]*)"/.exec(disposition);
                        if (matches != null && matches[1]) filename = matches[1];
                    }

                    let blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename || 'reportResultSurvey.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    Swal.fire({
                        title: 'Success!',
                        text: 'File berhasil diunduh.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#modalExportResult').modal('hide');
                },
                error: function (xhr) {
                    let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors || {};
                        $('.form-control').removeClass('is-invalid');
                        $('.error-message').html('');

                        for (let field in errors) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).html(errors[field][0]);
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    console.error('Error Trace:', xhr.responseJSON || xhr.responseText);

                    Swal.fire({
                        title: 'Gagal!',
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true
                    });
                },
                complete: function () {
                    button.prop('disabled', false).text('Submit');
                }
            });
        } catch (err) {
            console.error('Unexpected Error:', err);

            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan tidak terduga. Silakan coba lagi.',
                icon: 'error',
                showConfirmButton: true
            });

            button.prop('disabled', false).text('Submit');
        }
    });
});
