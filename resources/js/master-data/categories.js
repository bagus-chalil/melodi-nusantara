$('#modalAddCategories').on('shown.bs.modal', function () {
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
    dataTable = $('#datatable-categories').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/master-data/categories/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'role', name: 'role' },
            { data: 'aspect', name: 'aspect' },
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
    $('#btnShowModalAddCategories').click(function (e) {
        e.preventDefault();
        $('#modalAddCategories').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#submitAddCategories').prop('disabled', false);
        $('#submitAddCategories').text('Submit');
    });

    $('#submitAddCategories').click(function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let role = $('#role').val();
        let aspect = $('#aspect').val();
        let description = $('#description').val();
        let status = $('#status').val();

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                type: "POST",
                url: "/master-data/categories/store",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    "name": name,
                    "role": role,
                    "aspect": aspect,
                    "status": status,
                    "description": description,
                },
                success: function(response) {
                    console.log(response);

                    document.getElementById("form-add-categories").reset();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $('#modalAddCategories').modal('hide');
                    $('#datatable-categories').DataTable().ajax.reload();
                    $('#submitAddCategories').prop('disabled', false);
                    $('#submitAddCategories').text('Submit');
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

                    $('#submitAddCategories').prop('disabled', false);
                    $('#submitAddCategories').text('Submit');

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
    $('#datatable-categories').on('click', '.edit-action', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: `/master-data/categories/edit/${id}`,
            type: "GET",
            success: function (response) {
                // Isi input teks
                $('#modalEditCategories #categoriesId').val(response.categories.id);
                $('#modalEditCategories #edit_name').val(response.categories.name);
                $('#modalEditCategories #edit_status').val(response.categories.status);
                $('#modalEditCategories #edit_description').val(response.categories.description);

                // Isi select option untuk roles
                let rolesSelect = $('#modalEditCategories #edit_roles');
                rolesSelect.empty();
                response.roles.forEach(function (role) {
                    // Periksa apakah role.id ada di array type_role
                    let isSelected = response.categories.type_role.includes(role.id.toString()) ? 'selected' : '';
                    rolesSelect.append(`<option value="${role.id}" ${isSelected}>${role.name}</option>`);
                });

                // Isi select option untuk aspects
                let aspectSelect = $('#modalEditCategories #edit_aspects');
                aspectSelect.empty();
                response.aspects.forEach(function (aspect) {
                    let isSelected = aspect.id === response.categories.aspect_id ? 'selected' : '';
                    aspectSelect.append(`<option value="${aspect.id}" ${isSelected}>${aspect.name}</option>`);
                });

                // Tampilkan modal
                $('#modalEditCategories').modal('show');
            },
            error: function (xhr) {
                console.error("Gagal mengambil data Categories", xhr);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data Categories.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    });

    $('#submitEditCategories').click(function(e) {
        e.preventDefault();

        let categoriesId = $('#categoriesId').val();
        let name = $('#edit_name').val();
        let role = $('#edit_roles').val();
        let aspect = $('#edit_aspects').val();
        let status = $('#edit_status').val();
        let description = $('#edit_description').val();

        // Disable tombol dan ubah teks menjadi "Loading..."
        this.disabled = true;
        this.innerHTML = "Loading...";

        // Update kategori dengan AJAX
        getCsrfToken().then(function() {
            $.ajax({
                url: `/master-data/categories/update/${categoriesId}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    status: status,
                    role: role,
                    aspect: aspect,
                    status: status,
                    description: description,
                },
                success: function(response) {
                    $('#modalEditCategories').modal('hide');
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
                    $('#submitEditCategories').prop('disabled', false);
                    $('#submitEditCategories').text('Submit');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    // Aktifkan kembali tombol jika terjadi error
                    $('#submitEditCategories').prop('disabled', false);
                    $('#submitEditCategories').text('Update');
                }
            });
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.categories_checkbox').prop('checked', isChecked);
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
                $('.categories_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/master-data/categories/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-categories').DataTable().ajax.reload();

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
        let allChecked = $('.categories_checkbox:checked').length === $('.categories_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

});
