$('#modalAddSurvey').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$('#modalEditSurvey').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-survey').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/survey/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'quota', name: 'quota' },
            { data: 'total_responden', name: 'total_responden' },
            { data: 'token', name: 'token' },
            {
                data: 'status_approve',
                name: 'status_approve',
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

    $(document).on('click', '.copy-link', function () {
        const link = $(this).data('link');
        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(link).select();
        document.execCommand('copy');
        tempInput.remove();

        alert('Link copied to clipboard!');
    });

    //Add Button
    $('#btnShowModalAddSurvey').click(function (e) {
        e.preventDefault();
        $('#modalAddSurvey').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#submitAddSurvey').prop('disabled', false);
        $('#submitAddSurvey').text('Submit');
    });

    $('#submitAddSurvey').click(function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let aspects = $('#aspects').val();
        let biodatas = $('#biodatas').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let description = $('#description').val();
        let status = $('#status').val();
        let quota = $('#quota').val();

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                type: "POST",
                url: "/survey/store",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    "name": name,
                    "aspects": aspects,
                    "biodatas": biodatas,
                    "start_date": start_date,
                    "end_date": end_date,
                    "description": description,
                    "quota": quota,
                    "status": status,
                },
                success: function(response) {
                    document.getElementById("form-add-survey").reset();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $('#modalAddSurvey').modal('hide');
                    $('#datatable-survey').DataTable().ajax.reload();
                    $('#submitAddSurvey').prop('disabled', false);
                    $('#submitAddSurvey').text('Submit');
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $('.form-control').removeClass('is-invalid');
                        $('.error-message').html('');

                        for (let field in errors) {
                            $('#error-' + field).html(errors[field][0]);
                        }

                        for (let field in errors) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).html(errors[field][0]);
                        }
                    }

                    $('#submitAddSurvey').prop('disabled', false);
                    $('#submitAddSurvey').text('Submit');

                    let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }

                    Swal.fire({
                        title: 'Gagal!',
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            });
        });
    });

    // Event listener untuk tombol Edit
    $('#datatable-survey').on('click', '.edit-action', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        $.ajax({
            url: `/survey/edit/${id}`,
            type: "GET",
            success: function (response) {
                // Isi input teks dasar
                $('#surveyId').val(response.survey.id);
                $('#edit_name').val(response.survey.name);
                $('#edit_description').val(response.survey.description);
                $('#edit_start_date').val(response.survey.start_date);
                $('#edit_end_date').val(response.survey.end_date);
                $('#edit_quota').val(response.survey.quota);

                // Isi select option untuk aspect
                let aspectSelect = $('#modalEditSurvey #edit_aspects');
                aspectSelect.empty();
                response.aspects.forEach(function (aspect) {
                    // Periksa apakah aspects ada di array aspects
                    let isSelected = response.survey.aspect.includes(aspect.id.toString()) ? 'selected' : '';
                    aspectSelect.append(`<option value="${aspect.id}" ${isSelected}>${aspect.name}</option>`);
                });
                // Isi select option untuk aspect
                let biodataSelect = $('#modalEditSurvey #edit_biodatas');
                biodataSelect.empty();
                response.biodatas.forEach(function (biodata) {
                    // Periksa apakah aspects ada di array aspects
                    let isSelected = response.survey.biodata.includes(biodata.id.toString()) ? 'selected' : '';
                    biodataSelect.append(`<option value="${biodata.id}" ${isSelected}>${biodata.name}</option>`);
                });

                // Tampilkan modal edit
                $('#modalEditSurvey').modal('show');
            },
            error: function (xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data untuk edit.',
                    icon: 'error'
                });
            }
        });
    });

    // Submit Edit Form
    $('#submitEditSurvey').click(function (e) {
        e.preventDefault();

        let formData = {
            id: $('#surveyId').val(),
            name: $('#edit_name').val(),
            start_date: $('#edit_start_date').val(),
            end_date: $('#edit_end_date').val(),
            description: $('#edit_description').val(),
            aspects: $('#edit_aspects').val(),
            biodatas: $('#edit_biodatas').val(),
            quota: $('#edit_quota').val()
        };

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                url: `/survey/update/${formData.id}`,
                type: 'PUT',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: formData,
                success: function(response) {
                    $('#modalEditSurvey').modal('hide');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    dataTable.ajax.reload();
                    // Aktifkan kembali tombol submit
                    $('#submitEditSurvey').prop('disabled', false);
                    $('#submitEditSurvey').text('Submit');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    // Aktifkan kembali tombol jika terjadi error
                    $('#submitEditSurvey').prop('disabled', false);
                    $('#submitEditSurvey').text('Update');
                }
            });
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.surveys_checkbox').prop('checked', isChecked);
    });

    $('#bulk_delete').click(function () {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Anda akan menghapus Kategori ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            // Lanjutkan hanya jika tombol "Ya, hapus!" diklik
            if (result.isConfirmed) {
                let id = [];
                $('.surveys_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/survey/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-survey').DataTable().ajax.reload();

                            Swal.fire({
                                title: response.message,
                                text: 'Tunggu beberapa saat hingga datatable refresh',
                                icon: 'success',
                                timer: 4000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON;
                            console.log(errors);
                        }
                    });
                } else {
                    alert('Silakan pilih data terlebih dahulu');
                }
            }
        }).catch((err) => {
            console.log('Dialog error:', err);
        });
    });

    // Update "Select All" checkbox state on redraw
    dataTable.on('draw', function () {
        let allChecked = $('.surveys_checkbox:checked').length === $('.surveys_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

     // Event listener untuk tombol submit
     $('#datatable-survey').on('click', '.submit-action', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to send this survey for approval?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Send it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                getCsrfToken().then(function() {
                    $.ajax({
                        url: `/survey/send-approval-survey`,
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { id: id },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            dataTable.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat memperbarui data.',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
                    });
                });
            }
        });
    });

    // Event listener untuk tombol submit
    $('#datatable-survey').on('click', '.approve-action', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to approve this survey?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                getCsrfToken().then(function() {
                    $.ajax({
                        url: `/survey/approve-form-survey`,
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { id: id },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            dataTable.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat memperbarui data.',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
                    });
                });
            }
        });
    });
});
