
<script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

<!-- Core Js -->
<script src="{{ asset('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Datatables -->
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

<script src="{{ asset('/assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('/assets/js/theme/app.init.js') }}"></script>
<script src="{{ asset('/assets/js/theme/theme.js') }}"></script>
<script src="{{ asset('/assets/js/theme/app.min.js') }}"></script>
<script src="{{ asset('/assets/js/theme/sidebarmenu.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('/assets/js/theme/custom.js') }}"></script>

<!-- Iconify -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('/assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/forms/select2.init.js') }}"></script>

<!-- Sweet Alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Fontawesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Dropzone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<!-- Quill -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<!-- CSRF Token -->
<script src="{{asset('assets/js/csrf-token.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

@stack('js')


@include('sweetalert::alert')
