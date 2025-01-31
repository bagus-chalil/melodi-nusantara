<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- Core Css -->
<link rel="stylesheet" href="{{ asset('/assets/css/styles.css') }}" />

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}" />

<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.css">

<!-- Owl Carousel  -->
<link rel="stylesheet" href="{{ asset('/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/assets/libs/select2/dist/css/select2.min.css') }}">

<!-- Fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Dropzone -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />

<!-- Quill -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
{{-- <script src="{{ asset('assets') }}/js/config.js"></script> --}}

<!-- Page Styles -->
@yield('page-style')
