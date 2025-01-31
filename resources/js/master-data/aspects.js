$('#modalAddAspect').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$('#modalEditAspect').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-aspect').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/master-data/aspect/fetch-data",
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
            { data: 'created_at', name: 'created_at' },
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
    $('#btnShowModalAddAspect').click(function (e) {
        e.preventDefault();
        $('#modalAddAspect').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#submitAddAspect').prop('disabled', false);
        $('#submitAddAspect').text('Submit');
    });

    $('#submitAddAspect').click(function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let description = $('#description').val();
        let status = $('#status').val();

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                type: "POST",
                url: "/master-data/aspect/store",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    "name": name,
                    "status": status,
                    "description": description,
                },
                success: function(response) {
                    console.log(response);

                    document.getElementById("form-add-aspect").reset();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $('#modalAddAspect').modal('hide');
                    $('#datatable-aspect').DataTable().ajax.reload();
                    $('#submitAddAspect').prop('disabled', false);
                    $('#submitAddAspect').text('Submit');
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

                    $('#submitAddAspect').prop('disabled', false);
                    $('#submitAddAspect').text('Submit');

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
    $('#datatable-aspect').on('click', '.edit-action', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: `/master-data/aspect/edit/${id}`,
            type: "GET",
            success: function(response) {
                $('#modalEditAspect #aspectId').val(response.aspect.id);
                $('#modalEditAspect #edit_name').val(response.aspect.name);
                $('#modalEditAspect #edit_status').val(response.aspect.status);
                $('#modalEditAspect #edit_description').val(response.aspect.description);

                $('#modalEditAspect').modal('show');
            },
            error: function(xhr) {
                console.error("Gagal mengambil data aspect", xhr);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data aspect.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    });

    $('#submitEditAspect').click(function(e) {
        e.preventDefault();

        let aspectId = $('#aspectId').val();
        let name = $('#edit_name').val();
        let status = $('#edit_status').val();
        let description = $('#edit_description').val();

        // Disable tombol dan ubah teks menjadi "Loading..."
        this.disabled = true;
        this.innerHTML = "Loading...";

        // Update kategori dengan AJAX
        getCsrfToken().then(function() {
            $.ajax({
                url: `/master-data/aspect/update/${aspectId}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    status: status,
                    description: description,
                },
                success: function(response) {
                    $('#modalEditAspect').modal('hide');
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
                    $('#submitEditAspect').prop('disabled', false);
                    $('#submitEditAspect').text('Submit');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    // Aktifkan kembali tombol jika terjadi error
                    $('#submitEditAspect').prop('disabled', false);
                    $('#submitEditAspect').text('Update');
                }
            });
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.aspect_checkbox').prop('checked', isChecked);
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
                $('.aspect_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/master-data/aspect/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-aspect').DataTable().ajax.reload();

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
        let allChecked = $('.aspect_checkbox:checked').length === $('.aspect_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

});
