$('#modalAddAnswers').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$('#modalEditCategories').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-answers').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/master-data/answers/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'label', name: 'label' },
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type' },
            { data: 'data', name: 'data' },
            {
                data: 'status',
                name: 'status',
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

    // Show Modal: Reset & Prepare
    $('#btnShowModalAddAnswers').click(function (e) {
        e.preventDefault();
        $('#form-add-answers')[0].reset();
        $('#type').val(null).trigger('change'); // Reset select2 dropdown
        $('#input-container, #checkbox-container').hide(); // Hide conditional fields
        $('#modalAddAnswers').modal('show'); // Show modal
    });

    // Inisialisasi Select2 untuk Type Dropdown
    $('#type').select2({
        dropdownParent: $('#modalAddAnswers')
    });

    let initializedCheckbox = false;
    // Handle Change Event on "Type" Dropdown
    $('#type').on('change', function () {
        let selectedType = $(this).val();

        // Hide all conditional fields by default
        $('#input-container, #checkbox-container').hide();
        $('#data-input').val(''); // Reset input text
        $('#data-checkbox').val(null).trigger('change'); // Reset checkbox dropdown

        if (selectedType === 'checkbox' || selectedType === 'radiobutton') {
            $('#checkbox-container').show(); // Show checkbox container
            if (!initializedCheckbox) {
                $('#data-checkbox').select2({
                    tags: true,
                    tokenSeparators: [','],
                    dropdownParent: $('#checkbox-container')
                });
                initializedCheckbox = true;
            }
        } else if (selectedType === 'select') {
            $('#input-container').show();
        }
    });

    // Submit Form Data
    $('#submitAddAnswers').click(function (e) {
        e.preventDefault();
        let valData = null;
        if ($('#type').val() == 'checkbox' || $('#type').val() == 'radiobutton') {
            valData = $('#data-checkbox').val();
        } else {
            valData = $('#data-input').val();
        }

        // Prepare data based on input type
        let formData = {
            label: $('#label').val(),
            name: $('#name').val(),
            type: $('#type').val(),
            data: valData,
            status: $('#status').val()
        };

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            // Ajax Post Request
            $.ajax({
                type: "POST",
                url: "/master-data/answers/store",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: formData,
                success: function (response) {
                    document.getElementById("form-add-answers").reset();
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#modalAddAnswers').modal('hide');
                    $('#datatable-answers').DataTable().ajax.reload();
                    $('#submitAddAnswers').prop('disabled', false);
                    $('#submitAddAnswers').text('Submit');
                },
                error: function (xhr) {
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

                    $('#submitAddAnswers').prop('disabled', false);
                    $('#submitAddAnswers').text('Submit');

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

    let initializedEditCheckbox = false;

    // Event listener untuk tombol Edit
    $('#datatable-answers').on('click', '.edit-action', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        $.ajax({
            url: `/master-data/answers/edit/${id}`,
            type: "GET",
            success: function (response) {
                // Isi input teks dasar
                $('#answersId').val(response.answers.id);
                $('#edit_name').val(response.answers.name);
                $('#edit_type').val(response.answers.type).trigger('change');
                $('#edit_status').val(response.answers.status);

                // Reset all containers
                $('#edit-input-container, #edit-checkbox-container').hide();
                $('#edit_data_input').val('');
                $('#edit_data_checkbox').empty().trigger('change');

                // Tampilkan data sesuai tipe
                if (response.answers.type === 'checkbox' || response.answers.type === 'radiobutton') {
                    $('#edit-checkbox-container').show();

                    let checkboxValues = JSON.parse(response.answers.data); // Ubah string JSON jadi array
                    checkboxValues.forEach(value => {
                        $('#edit_data_checkbox').append(new Option(value, value, true, true));
                    });

                    // Initialize select2 jika belum
                    if (!initializedEditCheckbox) {
                        $('#edit_data_checkbox').select2({
                            tags: true,
                            tokenSeparators: [','],
                            dropdownParent: $('#modalEditAnswers')
                        });
                        initializedEditCheckbox = true;
                    }

                    $('#edit_data_checkbox').trigger('change');
                } else if (response.answers.type === 'select' || response.answers.type === 'input') {
                    $('#edit-input-container').show();
                    $('#edit_data_input').val(response.answers.data); // Isi input teks
                }

                // Tampilkan modal edit
                $('#modalEditAnswers').modal('show');
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

    // Handle Type Change in Edit Modal (Optional: Dinamis saat user ubah tipe)
    $('#edit_type').on('change', function () {
        let selectedType = $(this).val();
        $('#edit-input-container, #edit-checkbox-container').hide();

        if (selectedType === 'checkbox' || selectedType === 'radiobutton') {
            $('#edit-checkbox-container').show();
        } else if (selectedType === 'select') {
            $('#edit-input-container').show();
        }
    });

    // Submit Edit Form
    $('#submitEditAnswers').click(function (e) {
        e.preventDefault();

        let formData = {
            id: $('#answersId').val(),
            name: $('#edit_name').val(),
            type: $('#edit_type').val(),
            data: ($('#edit_type').val() === 'checkbox') ? $('#edit_data_checkbox').val() : $('#edit_data_input').val(),
            status: $('#edit_status').val()
        };

        $.ajax({
            url: `/master-data/answers/update/${formData.id}`,
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: formData,
            success: function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#modalEditAnswers').modal('hide');
                $('#datatable-answers').DataTable().ajax.reload();
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memperbarui data.',
                    icon: 'error'
                });
            }
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.answers_checkbox').prop('checked', isChecked);
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
                $('.answers_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/master-data/answers/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-answers').DataTable().ajax.reload();

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
        let allChecked = $('.answers_checkbox:checked').length === $('.answers_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

});
