let csrfToken;

// Fungsi untuk mendapatkan token CSRF
function getCsrfToken() {
    return $.ajax({
        url: '/csrf-token',
        type: 'GET',
        success: function(response) {
            csrfToken = response.csrfToken;
            // Update the CSRF token in the meta tag
            $('meta[name="csrf-token"]').attr('content', csrfToken);
            // Update the AJAX setup with the new token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Perbarui token CSRF setiap 10 menit
setInterval(getCsrfToken, 10 * 60 * 1000);

$(document).ready(function() {
    // Session timeout in milliseconds
    const sessionTimeout = 90 * 60 * 1000;
    // Warning time in milliseconds before session timeout
    const warningTime = 5 * 60 * 1000;

    // Function to show SweetAlert with countdown
    function showWarningAlert(seconds) {
        Swal.fire({
            title: 'Session Almost Expired',
            html: `<p>Session anda akan segera berakhir. Mohon untuk segera melakukan aksi atau simpan pekerjaan.</p>
                   <p>Waktu tersisa: <strong id="countdown">${Math.floor(seconds / 60)}m ${seconds % 60}s</strong></p>`,
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                // Update countdown every second
                const countdownInterval = setInterval(() => {
                    seconds--;
                    const minutes = Math.floor(seconds / 60);
                    const secondsLeft = seconds % 60;
                    document.getElementById('countdown').textContent = `${minutes}m ${secondsLeft}s`;
                    if (seconds <= 0) {
                        clearInterval(countdownInterval);
                    }
                }, 1000);
            },
        });
    }

    // Function to show session expired alert
    function showSessionExpiredAlert() {
        Swal.fire({
            title: 'Session Expired',
            text: 'Session anda telah berakhir. Silakan logout atau login kembali.',
            icon: 'error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonText: 'Stay Logged In',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to logout or perform other actions
                window.location.href = '/login'; // Update with your logout URL
            }
        });
    }

    // Set timeout for warning
    setTimeout(function() {
        showWarningAlert(warningTime / 1000);
    }, sessionTimeout - warningTime);

    // Set timeout for session expiry
    setTimeout(function() {
        showSessionExpiredAlert();
    }, sessionTimeout);
});



