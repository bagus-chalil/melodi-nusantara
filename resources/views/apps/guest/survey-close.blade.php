@extends('layouts.guest')
@section('title', 'Survey Close')
@section('content')
<div class="row g-7 bg-white p-3">
    <div class="col-lg-12">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="text-center">
                            {{-- <img src="{{asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" /> --}}
                            <h2 class="fs-9 fw-semibold my-4">Terima Kasih Telah Mengisi di Aplikasi Survey Kimia Farma✨</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card overflow-hidden">
            <div class="position-relative">
                <a href="javascript:void(0)">
                <img src="{{asset('assets/images/backgrounds/blog-img5.jpg')}}" class="card-img-top rounded-0 object-fit-cover" alt="modernize-img" height="440">
                </a>
                <span class="badge text-bg-light mb-9 me-9 position-absolute bottom-0 end-0">2
                min Read</span>
                <img src="{{asset('assets/images/profile/user-5.jpg')}}" alt="modernize-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Esther Lindsey">
            </div>
            <div class="card-body p-4">
                <h2 class="fs-9 fw-semibold my-4">Selamat Datang di Aplikasi Survey Kimia Farma✨</h2>
                <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center fs-2 ms-auto">
                    <i class="ti ti-point text-dark"></i>{{\Carbon\Carbon::now()->format('d, M Y')}}
                </div>
                </div>
            </div> --}}
            <div class="card-body border-top p-4">
                <h4 class="fs-9 fw-semibold my-4"></h4>
                <p class="mb-3">
                    Demikian survei kepuasan karyawan terhadap layanan umum & K3 dilakukan untuk  peningkatan kualitas dan inovasi pelayanan di lingkungan PT Kimia Farma Tbk.  Atas perhatian dan partisipasi Bapak/Ibu  kami ucapkan terima kasih,  dan semoga sehat selalu.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
