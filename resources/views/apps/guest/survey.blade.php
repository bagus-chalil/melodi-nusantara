@extends('layouts.guest')
@section('title', 'Survey')
@section('content')
<div class="row g-2 bg-white p-3">
    <div class="col-lg-12" style="margin-top: 0px;">
        <div class="row">
            <div class="col">
                <img src="{{ asset('assets/images/logos/logo-bumn.png') }}" class="img-fluid mb-3 float-start" width="100px">
            </div>
            <div class="col">
                <img src="{{ asset('assets/images/logos/new-logo-kf.png') }}" class="img-fluid mb-3 float-end" width="100px">
            </div>
        </div>
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="text-center">
                            <h2 class="fs-9 fw-semibold my-4">{{$data['survey']->name}}✨</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-lg-12">
        <!-- Alert untuk Validasi -->
        <div id="validationAlert" class="alert alert-danger d-none" role="alert">
            <h5><strong>Harap Periksa Kesalahan Berikut:</strong></h5>
            <ul id="validationErrorsList"></ul>
        </div>

        <form id="surveyForm">
            <input type="hidden" readonly name="survey_id" value="{{$data['surveyAll']->id}}">
            <div class="d-flex flex-column gap-sm-10">

                <!-- Input Biodata Dinamis -->
                <h3 class="fw-bold  text-center text-white" style="background-color: #2E5077">Data Responden</h3>
                @php $counter = 0; @endphp
                @foreach ($data['biodata_answers'] as $answer)
                    {{-- @if ($counter % 2 == 0)
                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                    @endif --}}

                    <div class="d-flex flex-column flex-grow-1 gap-2">
                        <label class="fw-bold fs-5">{{ $answer->label }}</label>

                        <!-- Input Text -->
                        @if ($answer->type === 'input')
                            <input
                                type="hidden"
                                name="biodata[fields][{{ $answer->id }}][name]"
                                value="{{ $answer->name }}">
                            <input
                                type="text"
                                name="biodata[fields][{{ $answer->id }}][value]"
                                id="biodata_field_{{ $answer->id }}"
                                class="form-control">
                            <div id="error-biodata_field_{{ $answer->id }}" class="error-message text-danger"></div>
                        @elseif ($answer->type === 'checkbox')
                            <input
                                type="hidden"
                                name="biodata[fields][{{ $answer->id }}][name]"
                                value="{{ $answer->name }}">
                            @foreach (json_decode($answer->data) as $key => $option)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="biodata[fields][{{ $answer->id }}][value][]"
                                        value="{{ $option }}"
                                        class="form-check-input"
                                        id="checkbox_{{ $answer->id }}_{{ $key }}">
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>
                            @endforeach
                            <div id="error-checkbox_{{ $answer->id }}" class="error-message text-danger"></div>
                        @elseif ($answer->type === 'radiobutton')
                            <input
                                type="hidden"
                                name="biodata[fields][{{ $answer->id }}][name]"
                                value="{{ $answer->name }}">
                            @foreach (json_decode($answer->data) as $key => $option)
                                <div class="form-check">
                                    <input
                                        type="radio"
                                        name="biodata[fields][{{ $answer->id }}][value]"
                                        value="{{ $option }}"
                                        class="form-check-input"
                                        id="radio_{{ $answer->id }}_{{ $key }}">
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>
                            @endforeach
                            <div id="error-radio_{{ $answer->id }}" class="error-message text-danger"></div>
                        @elseif ($answer->type === 'select')
                            <input
                                type="hidden"
                                name="biodata[fields][{{ $answer->id }}][name]"
                                value="{{ $answer->name }}">
                            <select class="form-control select2" name="biodata[fields][{{ $answer->id }}][value]" id="biodata_field_{{ $answer->id }}">
                                @foreach ($data[$answer->data] as $key => $option)
                                    <option value="{{$option->id}}">{{$option->name}}</option>
                                @endforeach
                            </select>
                            <div id="error-select_{{ $answer->id }}" class="error-message text-danger"></div>
                        @endif
                    </div>

                    {{-- @php $counter++; @endphp
                    @if ($counter % 2 == 0 || $loop->last)
                        </div>
                    @endif --}}
                @endforeach

                <hr>

                <!-- Pertanyaan Aspek -->
                <h3 class="fw-bold  text-center text-white" style="background-color: #2E5077">Pertanyaan</h3>
                @php $counterq = 1; @endphp
                @foreach (json_decode($data['surveyAll']->aspect) as $aspectSurvey)
                    <input type="hidden" name="aspects[{{ $aspectSurvey }}][aspect_id]" value="{{ $aspectSurvey }}">
                    @foreach ($data['surveyForm'] as $survey)
                        @if ($survey->id == $aspectSurvey)
                            @foreach ($survey->categories as $category)
                                @if ($category->questions->isNotEmpty())
                                    {{-- <h3>{{$survey->name}} - {{ $category->name }}</h3> --}}
                                    <input type="hidden" name="aspects[{{ $aspectSurvey }}][categories][{{ $category->id }}][category_id]" value="{{ $category->id }}">

                                    @foreach ($category->questions as $question)
                                        <div class="d-flex align-items-start">
                                            <span class="me-2">{{ $counterq }}.</span>
                                            <label class="fw-bold flex-grow-1">{{ $question->name }}</label>
                                        </div>
                                        <input type="hidden" name="aspects[{{ $aspectSurvey }}][categories][{{ $category->id }}][questions][{{ $question->id }}][question_id]" value="{{ $question->id }}">

                                        @foreach (json_decode($question->answers->data) as $key => $answerOption)
                                            <div class="form-check d-inline-block">
                                                <input
                                                    type="radio"
                                                    class="form-check-input"
                                                    id="answer_{{ $question->id }}_{{ $key }}"
                                                    name="aspects[{{ $aspectSurvey }}][categories][{{ $category->id }}][questions][{{ $question->id }}][answer_id]"
                                                    value="{{ $key+1 }}">
                                                <label
                                                    class="form-check-label"
                                                    for="answer_{{ $question->id }}_{{ $key }}">
                                                    {{ $answerOption }}
                                                </label>
                                            </div>
                                        @endforeach

                                        <div id="error-aspects_{{ $aspectSurvey }}_categories_{{ $category->id }}_questions_{{ $question->id }}_answer_id" class="error-message text-danger"></div>

                                        @php $counterq++; @endphp

                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endforeach

                <hr>

                <!-- Pesan Tambahan -->
                <h3 class="fw-bold  text-center text-white" style="background-color: #2E5077">Saran</h3>
                <div class="d-flex flex-column gap-2">
                    <label for="saran_umum">Menurut Anda, saran yang dapat Anda berikan untuk meningkatkan kualitas layanan umum ?</label>
                    <textarea name="saran_umum" id="saran_umum" class="form-control"></textarea>
                    <div id="error-saran_umum" class="error-message text-danger"></div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <label for="saran_k3">Menurut Anda, apa yang saja yang perlu ditingkatkan dalam layanan K3 yang diberikan?</label>
                    <textarea name="saran_k3" id="saran_k3" class="form-control"></textarea>
                    <div id="error-saran_k3" class="error-message text-danger"></div>
                </div>

                <button type="button" id="submitSurvey" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@if ($data['surveyAll']->status_approve == 3)
    @vite('resources/js/guest/survey-form.js')
@else
    @vite('resources/js/admin/survey-detail.js')
@endif
