
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- Import Js Files -->
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/theme/app.init.js')}}"></script>
<script src="{{asset('assets/js/theme/theme.js')}}"></script>
<script src="{{asset('assets/js/theme/app.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/owl.carousel/dist/owl.carousel.min.js')}}"></script>
<script src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/js/frontend-landingpage/homepage.js"></script>

<!-- Select2 -->
<script src="{{ asset('/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/forms/select2.init.js') }}"></script>

<!-- Sweet Alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Fontawesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- CSRF Token -->
<script src="{{asset('assets/js/csrf-token.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.0/purify.min.js"></script>

@stack('js')

@include('sweetalert::alert')
