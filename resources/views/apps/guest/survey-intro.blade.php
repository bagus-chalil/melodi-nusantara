@extends('layouts.guest')
@section('title', 'Survey Intro')
@section('content')
    <div class="row g-7 bg-white p-3">
        <div class="col-lg-12" style="margin-top: 0px;">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('assets/images/logos/logo-bumn.png') }}" class="img-fluid mb-3 float-start"
                         width="100px">
                </div>
                <div class="col">
                    <img src="{{ asset('assets/images/logos/new-logo-kf.png') }}" class="img-fluid mb-3 float-end"
                         width="100px">
                </div>
            </div>
            <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="text-center">
                                <h2 class="fs-9 fw-semibold my-4">Selamat Datang di Aplikasi Survey Kimia Farma✨</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body border-top p-4">
                <h4 class="fs-9 fw-semibold my-4">{{$data['survey']->name}}</h4>
                <p class="mb-3">
                    {!!$data['survey']->description!!}
                </p>
                <div class="border-top mt-7 pt-7">
                    <h3 class="fw-semibold mb-2">Pilih Tipe Survey</h3>
                    <div class="p-3 bg-light rounded border-start border-2 border-primary">
                        <form action="{{url($data['url'],Crypt::encrypt($data['survey']->id))}}" method="POST">
                            @csrf
                            <select class="form-select select2" name="type_coresponden" id="type_coresponden">
                                <option value="99" selected disabled>Silahkan Pilih</option>
                                @foreach (json_decode($data['survey']->biodata) as $biodataCoresponden)
                                    @foreach ($data['typeCorespondens'] as $corespondens)
                                        @if ($biodataCoresponden == $corespondens->id)
                                            <option value="{{$corespondens->id}}">{{$corespondens->name}}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                            <button class="btn btn-primary my-2" type="submit"> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
