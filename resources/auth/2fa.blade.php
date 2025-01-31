@extends('layouts.auth')

@section('title', 'Verification OTP 2FA')

@section('content')

    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center text-white-50">
                        <div>
                            <a href="/" class="d-inline-block auth-logo">
                                <img src="{{ asset('assets/images/logo-white-sm.png') }}" height="50">
                            </a>
                        </div>
                        <br>
                        <p class="fs-15 fw-medium">Unlocking Potential with Real-Time E-Asset</p>
                    </div>
                </div>
            </div>

            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Verification OTP 2FA!</h5>
                                <p class="text-muted">We have sent an OTP code to your email. Please check your email.
                                    : {{ substr(auth()->user()->email, 0, 5) . '******' . substr(auth()->user()->email,  -2) }}</p>
                            </div>
                            <div class="p-2">
                                <!-- Validation Errors -->
                                @if ($errors->any())
                                    <!-- Primary Alert -->
                                    <div class="alert alert-danger alert-dismissible alert-solid alert-label-icon fade show" role="alert">
                                        <i class="ri-error-warning-line align-middle label-icon"></i>
                                        @foreach ($errors->all() as $error)
                                            <span>{{ $error }}</span>
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('2fa.post') }}">
                                    @csrf

                                    @if ($message = Session::get('success'))
                                        <div
                                            class="alert alert-success alert-dismissible alert-solid alert-label-icon fade show"
                                            role="alert">
                                            <i class="ri-error-warning-line align-middle label-icon"></i>
                                            <span>{{ $message }}</span>
                                            <p id="countdown" class="mb-0"></p>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if ($message = Session::get('error'))
                                        <div
                                            class="alert alert-danger alert-dismissible alert-solid alert-label-icon fade show"
                                            role="alert">
                                            <i class="ri-error-warning-line align-middle label-icon"></i>
                                            <span>{{ $message }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <label class="form-label" for="Code OTP">Code OTP</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                    <input type="text" name="code[]" class="form-control form-control-lg bg-light text-center" onkeyup="moveToNext(1, event)" maxlength="1" id="digit1-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                    <input type="text" name="code[]" class="form-control form-control-lg bg-light text-center" onkeyup="moveToNext(2, event)" maxlength="1" id="digit2-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                    <input type="text" name="code[]" class="form-control form-control-lg bg-light text-center" onkeyup="moveToNext(3, event)" maxlength="1" id="digit3-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                    <input type="text" name="code[]" class="form-control form-control-lg bg-light text-center" onkeyup="moveToNext(4, event)" maxlength="1" id="digit4-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('2fa.resend') }}">Re-Send OTP Code?</a>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col">
                                            <a class="btn btn-outline-danger w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary w-100" id="submitBtn" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

@stop

@push('js')
<script type="text/javascript">
    // Set the countdown time (2 minutes in milliseconds)
    var countdownTime = 2 * 60 * 1000;

    // Function to update the countdown timer
    function updateCountdown() {
        var minutes = Math.floor(countdownTime / 60000);
        var seconds = ((countdownTime % 60000) / 1000).toFixed(0);

        // Display the countdown timer
        $("#countdown").html("Time left: " + minutes + "m " + (seconds < 10 ? '0' : '') + seconds + "s ");

        // Decrease the countdown time by 1 second
        countdownTime -= 1000;

        // If the countdown reaches 0, display a message
        if (countdownTime < 0) {
            clearInterval(timer);
            $("#countdown").html("Time's up!");
            $("#submitBtn").prop("disabled", true);
        }
    }

    // Call the updateCountdown function every second
    var timer = setInterval(updateCountdown, 1000);

    // Initialize the countdown when the page loads
    updateCountdown();

</script>
@endpush
