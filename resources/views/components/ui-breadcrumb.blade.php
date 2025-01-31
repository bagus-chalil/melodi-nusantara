<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4 d-print-none">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $breadcrumbTitle }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach($breadcrumbItems as $item)
                            <li class="breadcrumb-item" aria-current="page">{{ $item }}</li>
                        @endforeach
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('/assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>
