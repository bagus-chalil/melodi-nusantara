$(document).ready(function() {
    let table = $('#datatable-genres').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/genres",
        columns: [
            { data: 'checkbox', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'cover_image', orderable: false, searchable: false },
            { data: 'actions', orderable: false, searchable: false },
        ]
    });

    // Preview gambar sebelum upload
    $('#cover_image').change(function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            $('#cover-preview').attr('src', reader.result).show();
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    $('#closeModal').click(function() {
        $('#genreModal').modal('hide');
    });

    // Tambah/Edit Modal
    $('#addGenreBtn').click(function() {
        $('#genreModal').modal('show');
        $('#genreForm')[0].reset();
        $('#cover-preview').hide();
        $('#genreId').val('');
    });

    // Submit Form (Tambah/Edit)
    $('#genreForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#genreId').val();
        let url = id ? `/admin/genres/${id}` : "/admin/genres";
        let method = id ? "POST" : "POST";

        if (id) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire('Sukses!', response.success, 'success');
                $('#genreModal').modal('hide');
                table.ajax.reload();
            }
        });
    });

    // Edit Genre
    $(document).on('click', '.edit-genre', function() {
        let id = $(this).data('id');
        $.get(`/admin/genres/${id}/edit`, function(data) {
            $('#genreId').val(data.id);
            $('#name').val(data.name);
            $('#cover-preview').attr('src', `/storage/${data.cover_image}`).show();
            $('#genreModal').modal('show');
        });
    });

    // Delete Genre (Single)
    $(document).on('click', '.delete-genre', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/genres/${id}`,
                    type: 'DELETE',
                    data: { _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.success, 'success');
                        table.ajax.reload();
                    }
                });
            }
        });
    });

    // Batch Delete
    $('#deleteSelected').click(function() {
        let ids = [];
        $('.genre-checkbox:checked').each(function() { ids.push($(this).val()); });

        if (ids.length === 0) {
            Swal.fire('Oops!', 'Pilih setidaknya satu genre untuk dihapus.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Hapus Genre Terpilih?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/genres/batch-delete",
                    type: 'DELETE',
                    data: {
                        ids: ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.success, 'success');
                        $('#datatable-genres').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON.error || 'Terjadi kesalahan!';
                        Swal.fire('Error!', message, 'error');
                    }
                });
            }
        });
    });

    // Select All Checkbox
    $('#selectAll').click(function() {
        $('.genre-checkbox').prop('checked', this.checked);
    });
});
