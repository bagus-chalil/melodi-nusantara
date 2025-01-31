$(document).ready(function() {
    let table = $('#datatable-songs').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/songs",
        columns: [
            { data: 'checkbox', orderable: false, searchable: false },
            { data: 'title' },
            { data: 'artist' },
            { data: 'genre' },
            { data: 'file_path', orderable: false, searchable: false },
            { data: 'actions', orderable: false, searchable: false },
        ]
    });

    $('#closeModal').click(function() {
        $('#songModal').modal('hide');
    });

    $('#addSongBtn').click(function() {
        $('#songModal').modal('show');
        $('#songForm')[0].reset();
    });

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
            }
        });
    });

    $(document).on('click', '.edit-song', function() {
        let id = $(this).data('id');
        $.get(`/admin/songs/${id}/edit`, function(data) {
            $('#songId').val(data.id);
            $('#title').val(data.title);
            $('#artist').val(data.artist);
            $('#genre_id').val(data.genre_id);
            $('#songModal').modal('show');
        });
    });

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
});
