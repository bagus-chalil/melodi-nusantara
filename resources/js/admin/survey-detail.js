$(document).ready(function () {
    $('#submitSurvey').on('click', function () {
        let formData = $('#surveyForm').serializeArray();
        let jsonData = {};

        // Menyusun data form menjadi struktur JSON yang benar
        formData.forEach(field => {
            let sanitizedValue = DOMPurify.sanitize(field.value);

            let keys = field.name.match(/[^\[\]]+/g);
            if (keys) {
                let temp = jsonData;
                keys.forEach((key, index) => {
                    if (index === keys.length - 1) {
                        temp[key] = sanitizedValue;
                    } else {
                        temp[key] = temp[key] || {};
                        temp = temp[key];
                    }
                });
            }
        });

        // Debug: Memeriksa data yang akan dikirim
        console.log("Data JSON yang akan dikirim:", jsonData);

        $('#submitSurvey').prop('disabled', true).text('Loading...');

        getCsrfToken().then(function () {
            $.ajax({
                url: '/survey/survey-admin/submit',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: JSON.stringify(jsonData),
                contentType: 'application/json',
                success: function (response) {
                    $('#surveyForm')[0].reset();
                    Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    let jsonOutput = JSON.stringify(response.data, null, 2);
                    $('body').append(`
                        <div class="container mt-5">
                            <h3>📊 Hasil JSON (Trial Mode)</h3>
                            <pre style="background: #f4f4f4; border: 1px solid #ccc; padding: 15px;">${jsonOutput}</pre>
                        </div>
                    `);
                    $('#submitSurvey').prop('disabled', true).text('Submit');
                },
                error: function (xhr) {
                    $('#validationErrorsList').empty();
                    $('#validationAlert').removeClass('d-none');
                    $('.form-control').removeClass('is-invalid');
                    $('.question-section').removeClass('border border-danger');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Menangani error validasi
                        for (let field in errors) {
                            let fieldPath = field.replace(/\./g, '_');
                            let errorDiv = $(`#error-${fieldPath}`);

                            if (errorDiv.length > 0) {
                                errorDiv.html(errors[field][0]);  // Menampilkan pesan error
                                $(`[name="${field.replace(/\_/g, '.')}"]`).addClass('is-invalid');

                                // Menandai section pertanyaan yang bermasalah
                                if (field.includes('aspects')) {
                                    let questionId = field.match(/aspects\.(\d+)\.categories\.(\d+)\.questions\.(\d+)\.answer_id/);
                                    if (questionId) {
                                        let sectionId = `#question_${questionId[1]}_${questionId[2]}_${questionId[3]}`;
                                        $(sectionId).addClass('border border-danger');
                                    }
                                }
                            }

                            // Menambahkan pesan error ke dalam list
                            $('#validationErrorsList').append(`<li>${errors[field][0]}</li>`);
                        }

                        // Scroll ke bagian atas alert jika ada error
                        $('html, body').animate({ scrollTop: $('#validationAlert').offset().top - 100 }, 1000);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan server. Silakan coba lagi nanti.',
                            icon: 'error',
                            showConfirmButton: true
                        });
                    }

                    $('#submitSurvey').prop('disabled', false).text('Submit');
                }
            });
        });
    });
});
