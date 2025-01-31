<table id="datatable-survey-result1" border="1" class="table table-bordered text-nowrap align-middle">
    <thead>
        <tr>
            <th colspan="4" class="text-center">Biodata</th>
            @foreach ($data['aspects'] as $aspect)
                <th colspan="{{ $aspect->categories_count }}" class="text-center">{{ $aspect->name }}</th>
            @endforeach
            @if ($data['menu'] == 'DWN')
            <th rowspan="2">Saran Umum</th>
            <th rowspan="2">Saran K3</th>
            @endif
        </tr>
        <tr>
            <th>Division</th>
            <th>Unit</th>
            <th>Level Position</th>
            <th>Status</th>
            @foreach ($data['aspects'] as $aspect)
                @foreach ($aspect->categories as $category)
                    <th>{{ $category->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data['surveys'] as $survey)
            @php
                $decodedData = json_decode($survey->data, true);
            @endphp
            <tr>
                {{-- Biodata --}}
                @foreach ($data['allDivision'] as $division)
                    @if ($decodedData['biodata'][0]['division_work'] == $division->id)
                        <td>{{ $division->name ?? 'N/A' }}</td>
                    @endif
                @endforeach
                @foreach ($data['allUnit'] as $unit)
                    @if ($decodedData['biodata'][1]['unit_work'] == $unit->id)
                        <td>{{ $unit->name ?? 'N/A' }}</td>
                    @endif
                @endforeach
                <td>{{ $decodedData['biodata'][2]['level_jabatan'] ?? 'N/A' }}</td>
                <td>{{ $decodedData['biodata'][3]['status_pegawai'] ?? 'N/A' }}</td>

                {{-- Aspects and Categories --}}
                @foreach ($decodedData['aspects'] as $aspect)
                    @foreach ($aspect['categories'] as $category)
                        @php
                            $answers = collect($category['questions'])->pluck('answer_id');
                            $average = $answers->count() > 0 ? round($answers->avg(), 2) : 'N/A';
                        @endphp
                        <td>{{ $average }}</td>
                    @endforeach
                @endforeach

                {{-- Saran --}}
                @if ($data['menu'] == 'DWN')
                <td>{{ $decodedData['saran_umum'] ?? 'N/A' }}</td>
                <td>{{ $decodedData['saran_k3'] ?? 'N/A' }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
