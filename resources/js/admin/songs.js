$(document).ready(function() {
    let table = $('#datatable-songs').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/songs",
        columns: [
            { data: 'checkbox', orderable: false, searchable: false },
            { data: 'thumbnail', orderable: false, searchable: false },
            { data: 'title' },
            { data: 'category' },
            { data: 'region' },
            { data: 'file_preview', orderable: false, searchable: false },
            { data: 'actions', orderable: false, searchable: false },
        ]
    });

    $('#closeModal').click(function() {
        $('#songModal').modal('hide');
    });

    // Open Add Modal
    $('#addSongBtn').click(function() {
        $('#songModal').modal('show');
        $('#songForm')[0].reset();
        $('#errorAlert').addClass('d-none').empty();
        $('#thumbnail-preview, #audioPreview, #lyricsPreview').hide();
        $('#category').val('');
    });

    $('#file').change(function(event) {
        let file = event.target.files[0];
        if (file) {
            let url = URL.createObjectURL(file);
            $('#audioPreview').attr('src', url).show();
        }
    });

    $('#thumbnail').change(function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnail-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('click', '.edit-song', function() {
        let id = $(this).data('id');
        $.get(`/admin/songs/${id}/edit`, function(data) {
            console.log(data);

            $('#songId').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#category').val(data.category);
            $('#region').val(data.region);
            $('#source').val(data.source);

            if (data.file_url) $('#audioPreview').attr('src', data.file_url).show();
            if (data.thumbnail_url) $('#thumbnail-preview').attr('src', data.thumbnail_url).show();
            if (data.lyrics_url) $('#lyricsPreview').attr('href', data.lyrics_url).text('Download Lirik').show();

            $('#songModal').modal('show');
        });
    });

    // Submit Form (Tambah/Edit)
    $('#songForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#songId').val();
        let url = id ? `/admin/songs/${id}` : "/admin/songs";
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
                $('#songModal').modal('hide');
                table.ajax.reload();
                $('#errorAlert').addClass('d-none').empty();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorList = '<ul>';
                $.each(errors, function(key, value) {
                    errorList += '<li>' + value + '</li>';
                });
                errorList += '</ul>';
                $('#errorAlert').removeClass('d-none').html(errorList);
            }
        });
    });

    // Delete Single Song
    $(document).on('click', '.delete-song', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/songs/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Terhapus!', response.success, 'success');
                        table.ajax.reload();
                    }
                });
            }
        });
    });

    // Batch Delete (Hapus Banyak)
    $('#deleteSelected').click(function() {
        let ids = [];
        $('.song-checkbox:checked').each(function() { ids.push($(this).val()); });

        if (ids.length === 0) {
            Swal.fire('Oops!', 'Pilih setidaknya satu lagu untuk dihapus.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Hapus Lagu Terpilih?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/songs/batch-delete",
                    type: 'DELETE',
                    data: {
                        ids: ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.success, 'success');
                        table.ajax.reload();
                    }
                });
            }
        });
    });

    // Select All Checkbox
    $('#selectAll').click(function() {
        $('.song-checkbox').prop('checked', this.checked);
    });
});
