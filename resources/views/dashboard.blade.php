@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="row align-items-center">
                <div class="col-12 col-md-5 col-lg-6 p-4 pt-0">
                    <!-- Image -->
                    <img src="{{ asset('assets/images/backgrounds/img-cover.png') }}" alt="..."
                         class="img-fluid mb-6 mb-md-0">
                </div>
                <div class="col-12 col-md-7 col-lg-6 p-4">
                    <!-- Heading -->
                    <h2 class="mt-2">
                        Efficient <span class="text-primary">Survey Management</span> for Optimal Insights
                    </h2>
                    <!-- Text -->
                    <p class="fs-lg text-gray-700 mb-6">
                        <b>Aplikasi i-Survey</b> adalah solusi terintegrasi yang dirancang khusus untuk memantau dan
                        mengelola
                        kegiatan survei di PT Kimia Farma. Aplikasi ini memberikan kemampuan untuk merancang,
                        melaksanakan, dan menganalisis data survei secara menyeluruh, mulai dari perencanaan hingga
                        pelaporan, guna memastikan hasil survei yang akurat dan relevan.
                    </p>
                    <p class="fs-lg text-gray-700 mb-6">
                        Dengan aplikasi ini, perusahaan dapat mengoptimalkan proses survei melalui pemantauan real-time,
                        perencanaan yang lebih efisien, serta pengelolaan data survei secara terintegrasi. Hal ini
                        mendukung pengambilan keputusan yang lebih tepat, efisiensi operasional, dan penghematan sumber
                        daya.
                    </p>
                    <!-- Stats -->
                    <div class="d-flex">
                        <div class="pe-5">
                            <h3 class="mb-0">
                                <span data-countup="{&quot;startVal&quot;: 0}" data-to="100" data-aos=""
                                      data-aos-id="countup:in" class="aos-init aos-animate">100</span>%
                            </h3>
                            <p class="text-gray-700 mb-0">
                                Keamanan
                            </p>
                        </div>
                        <div class="border-start border-gray-300"></div>
                        <div class="px-5">
                            <h3 class="mb-0">
                                <span data-countup="{&quot;startVal&quot;: 0}" data-to="24" data-aos=""
                                      data-aos-id="countup:in" class="aos-init aos-animate">24</span>/
                                <span data-countup="{&quot;startVal&quot;: 0}" data-to="7" data-aos=""
                                      data-aos-id="countup:in" class="aos-init aos-animate">7</span>
                            </h3>
                            <p class="text-gray-700 mb-0">
                                Dukungan
                            </p>
                        </div>
                        <div class="border-start border-gray-300"></div>
                        <div class="ps-5">
                            <h3 class="mb-0">
                                <span data-countup="{&quot;startVal&quot;: 0}" data-to="100" data-aos=""
                                      data-aos-id="countup:in" class="aos-init aos-animate">230k</span>+
                            </h3>
                            <p class="text-gray-700 mb-0">
                                Data Realtime
                            </p>
                        </div>
                    </div>

                </div>
            </div> <!-- / .row -->
        </div>

        <div class="card">
            <section class="py-8 py-md-11 border-bottom">
                <div class="container">
                    <div class="row p-4">
                        <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up">
                            <!-- Icon -->
                            <div class="icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" fill-rule="evenodd">
                                        <path d="M0 0h24v24H0z"></path>
                                        <path d="M7 3h10a4 4 0 110 8H7a4 4 0 110-8zm0 6a2 2 0 100-4 2 2 0 000 4z"
                                              fill="#335EEA"></path>
                                        <path d="M7 13h10a4 4 0 110 8H7a4 4 0 110-8zm10 6a2 2 0 100-4 2 2 0 000 4z"
                                              fill="#335EEA" opacity=".3"></path>
                                    </g>
                                </svg>
                            </div>
                            <!-- Heading -->
                            <h3>
                                Survey Design
                            </h3>
                            <!-- Text -->
                            <p class="text-muted mb-6 mb-md-0">
                                Aplikasi ini memungkinkan pengguna untuk merancang survei, termasuk pembuatan
                                pertanyaan, format jawaban, serta target responden.
                            </p>
                        </div>
                        <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">
                            <!-- Icon -->
                            <div class="icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" fill-rule="evenodd">
                                        <path d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M5.5 4h4A1.5 1.5 0 0111 5.5v1A1.5 1.5 0 019.5 8h-4A1.5 1.5 0 014 6.5v-1A1.5 1.5 0 015.5 4zm9 12h4a1.5 1.5 0 011.5 1.5v1a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-1a1.5 1.5 0 011.5-1.5z"
                                            fill="#335EEA"></path>
                                        <path
                                            d="M5.5 10h4a1.5 1.5 0 011.5 1.5v7A1.5 1.5 0 019.5 20h-4A1.5 1.5 0 014 18.5v-7A1.5 1.5 0 015.5 10zm9-6h4A1.5 1.5 0 0120 5.5v7a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-7A1.5 1.5 0 0114.5 4z"
                                            fill="#335EEA" opacity=".3"></path>
                                    </g>
                                </svg>
                            </div>
                            <!-- Heading -->
                            <h3>
                                Survey Management
                            </h3>
                            <!-- Text -->
                            <p class="text-muted mb-6 mb-md-0">
                                Ini membantu perusahaan dalam mengelola pelaksanaan survei di seluruh unit bisnis, mulai
                                dari distribusi hingga pemantauan pengumpulan data.
                            </p>
                        </div>
                        <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <!-- Icon -->
                            <div class="icon text-primary mb-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" fill-rule="evenodd">
                                        <path d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M17.272 8.685a1 1 0 111.456-1.37l4 4.25a1 1 0 010 1.37l-4 4.25a1 1 0 01-1.456-1.37l3.355-3.565-3.355-3.565zm-10.544 0L3.373 12.25l3.355 3.565a1 1 0 01-1.456 1.37l-4-4.25a1 1 0 010-1.37l4-4.25a1 1 0 011.456 1.37z"
                                            fill="#335EEA"></path>
                                        <rect fill="#335EEA" opacity=".3" transform="rotate(15 12 12)" x="11" y="4"
                                              width="2" height="16" rx="1"></rect>
                                    </g>
                                </svg>
                            </div>
                            <!-- Heading -->
                            <h3>
                                Reports and Analysis
                            </h3>
                            <!-- Text -->
                            <p class="text-muted mb-0">
                                likasi ini dapat menghasilkan laporan yang menyajikan data hasil survei, termasuk
                                analisis tren, pola jawaban, dan rekomendasi berdasarkan temuan.
                            </p>
                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .container -->
            </section>
        </div>
    </div>
@endsection
