$('#modalAddQuestions').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$('#modalEditQuestions').on('shown.bs.modal', function () {
    $('.select2', this).each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});

$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-questions').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/master-data/questions/fetch-data",
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            { data: 'categories', name: 'categories' },
            { data: 'name', name: 'name' },
            { data: 'answers', name: 'answers' },
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
    $('#btnShowModalAddQuestions').click(function (e) {
        e.preventDefault();
        $('#modalAddQuestions').modal('show');
        // Reset tombol submit saat modal dibuka
        $('#submitAddQuestions').prop('disabled', false);
        $('#submitAddQuestions').text('Submit');
    });

    $('#submitAddQuestions').click(function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let answers = $('#answers').val();
        let categories = $('#categories').val();
        let status = $('#status').val();

        this.disabled = true;
        this.innerHTML = "Loading...";

        getCsrfToken().then(function() {
            $.ajax({
                type: "POST",
                url: "/master-data/questions/store",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    "name": name,
                    "answers": answers,
                    "categories": categories,
                    "status": status,
                },
                success: function(response) {
                    console.log(response);

                    document.getElementById("form-add-questions").reset();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $('#modalAddQuestions').modal('hide');
                    $('#datatable-questions').DataTable().ajax.reload();
                    $('#submitAddQuestions').prop('disabled', false);
                    $('#submitAddQuestions').text('Submit');
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

                    $('#submitAddQuestions').prop('disabled', false);
                    $('#submitAddQuestions').text('Submit');

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
    $('#datatable-questions').on('click', '.edit-action', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: `/master-data/questions/edit/${id}`,
            type: "GET",
            success: function(response) {
                $('#modalEditQuestions #questionId').val(response.question.id);
                $('#modalEditQuestions #edit_name').val(response.question.name);
                $('#modalEditQuestions #edit_status').val(response.question.status);

                // Isi select option untuk categories
                let categoriesSelect = $('#modalEditQuestions #edit_categories');
                categoriesSelect.empty();
                response.categories.forEach(function (category) {
                    let isSelected = category.id === response.question.categories_id ? 'selected' : '';
                    categoriesSelect.append(`<option value="${category.id}" ${isSelected}>${category.aspects.name} - ${category.name}</option>`);
                });

                let answerSelect = $('#modalEditQuestions #edit_answer');
                answerSelect.empty();
                response.answers.forEach(function (answer) {
                    let isSelected = answer.id === response.question.answer_id ? 'selected' : '';
                    answerSelect.append(`<option value="${answer.id}" ${isSelected}>${answer.name}</option>`);
                });

                $('#modalEditQuestions').modal('show');
            },
            error: function(xhr) {
                console.error("Gagal mengambil data questions", xhr);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data questions.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    });

    $('#submitEditQuestions').click(function(e) {
        e.preventDefault();

        let questionId = $('#questionId').val();
        let name = $('#edit_name').val();
        let categories = $('#edit_categories').val();
        let answer = $('#edit_answer').val();
        let status = $('#edit_status').val();

        // Disable tombol dan ubah teks menjadi "Loading..."
        this.disabled = true;
        this.innerHTML = "Loading...";

        // Update kategori dengan AJAX
        getCsrfToken().then(function() {
            $.ajax({
                url: `/master-data/questions/update/${questionId}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    status: status,
                    categories: categories,
                    answers: answer,
                },
                success: function(response) {
                    $('#modalEditQuestions').modal('hide');
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
                    $('#submitEditQuestions').prop('disabled', false);
                    $('#submitEditQuestions').text('Submit');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    // Aktifkan kembali tombol jika terjadi error
                    $('#submitEditQuestions').prop('disabled', false);
                    $('#submitEditQuestions').text('Update');
                }
            });
        });
    });

    // Bulk delete and checkbox action
    // Select All checkbox
    $('#selectAll').click(function () {
        let isChecked = $(this).is(':checked');
        $('.questions_checkbox').prop('checked', isChecked);
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
                $('.questions_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "/master-data/questions/delete",
                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                        method: "get",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#datatable-questions').DataTable().ajax.reload();

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
        let allChecked = $('.questions_checkbox:checked').length === $('.questions_checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

});
