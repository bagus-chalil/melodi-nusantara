$('#modalAddBiodata').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$('#modalEditBiodata').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-biodata').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/master-data/biodata/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            {
                data: 'answer_status',
                name: 'answer_status',
                orderable: false,
                searchable: false
            },
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

    //Add Button
    $('#btnShowModalAddBiodata').click(function (e) {
        e.preventDefault();
        $('#modalAddBiodata').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#submitAddBiodata').prop('disabled', false);
        $('#submitAddBiodata').text('Submit');
    });

    $('#submitAddBiodata').click(function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let answers = $('#answers').val();
        let description = $('#description').val();
        let status = $('#status').val();

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                type: "POST",
                url: "/master-data/biodata/store",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    "name": name,
                    "answers": answers,
                    "status": status,
                    "description": description,
                },
                success: function(response) {
                    console.log(response);

                    document.getElementById("form-add-biodata").reset();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $('#modalAddBiodata').modal('hide');
                    $('#datatable-biodata').DataTable().ajax.reload();
                    $('#submitAddBiodata').prop('disabled', false);
                    $('#submitAddBiodata').text('Submit');
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

                    $('#submitAddBiodata').prop('disabled', false);
                    $('#submitAddBiodata').text('Submit');

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
    $('#datatable-biodata').on('click', '.edit-action', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: `/master-data/biodata/edit/${id}`,
            type: "GET",
            success: function(response) {
                $('#modalEditBiodata #BiodataId').val(response.biodata.id);
                $('#modalEditBiodata #edit_name').val(response.biodata.name);
                $('#modalEditBiodata #edit_status').val(response.biodata.status);
                $('#modalEditBiodata #edit_description').val(response.biodata.description);

                // Isi select option untuk aspect
                let answersSelect = $('#modalEditBiodata #edit_answers');
                answersSelect.empty();
                response.answers.forEach(function (answer) {
                    // Periksa apakah aspects ada di array aspects
                    let isSelected = response.biodata.answer.includes(answer.id.toString()) ? 'selected' : '';
                    answersSelect.append(`<option value="${answer.id}" ${isSelected}>${answer.name}</option>`);
                });

                $('#modalEditBiodata').modal('show');
            },
            error: function(xhr) {
                console.error("Gagal mengambil data biodata", xhr);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data biodata.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    });

    $('#submitEditBiodata').click(function(e) {
        e.preventDefault();

        let biodataId = $('#biodataId').val();
        let name = $('#edit_name').val();
        let answers = $('#edit_answers').val();
        let status = $('#edit_status').val();
        let description = $('#edit_description').val();

        // Disable tombol dan ubah teks menjadi "Loading..."
        this.disabled = true;
        this.innerHTML = "Loading...";

        // Update kategori dengan AJAX
        getCsrfToken().then(function() {
            $.ajax({
                url: `/master-data/biodata/update/${biodataId}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    answers: answers,
                    status: status,
                    description: description,
                },
                success: function(response) {
                    $('#modalEditBiodata').modal('hide');
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
                    $('#submitEditBiodata').prop('disabled', false);
                    $('#submitEditBiodata').text('Submit');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    // Aktifkan kembali tombol jika terjadi error
                    $('#submitEditBiodata').prop('disabled', false);
                    $('#submitEditBiodata').text('Update');
                }
            });
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.biodata_checkbox').prop('checked', isChecked);
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
                $('.biodata_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/master-data/biodata/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-biodata').DataTable().ajax.reload();

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
        let allChecked = $('.biodata_checkbox:checked').length === $('.biodata_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

});
