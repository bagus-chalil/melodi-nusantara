<table id="datatable-survey-result1" border="1" class="table table-bordered text-nowrap align-middle">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Indikator</th>
            <th class="text-center">IPA</th>
            <th class="text-center">Kepuasan (Performance)</th>
            <th class="text-center">Harapan (Importance)</th>
            <th class="text-center">GAP</th>
            <th class="text-center">KN * KP</th>
            <th class="text-center">IKM(%)</th>
            <th class="text-center">NMP</th>
            <th class="text-center">KIP</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['report'] as $index => $category)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $category['name'] }}</td>
                <td>{{ $category['ipa'] }}</td>
                <td>{{ $category['performance'] }}</td>
                <td>{{ $category['importance'] }}</td>
                <td>{{ $category['gap'] }}</td>
                <td>{{ $category['performance_importance'] }}</td>
                <td>{{ $category['ikm'].'%' }}</td>
                <td>{{ $category['nmp'] }}</td>
                <td>{{ $category['kup'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-center">Jumlah</th>
            <th>-</th>
            <th>{{ $data['totalPerformance'] }}</th>
            <th>{{ $data['totalImportance'] }}</th>
            <th colspan="1"></th>
            <th>{{ $data['totalPerformanceImportance'] }}</th>
            <th>{{ $data['totalIKM'].'%' }}</th>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Rata-rata</th>
            <th>-</th>
            <th>{{ $data['averagePerformance'] }}</th>
            <th>{{ $data['averageImportance'] }}</th>
            <th colspan="1"></th>
            <th>{{ $data['averageMultiplicationPerformanceImportance'] }}</th>
            <th>{{ $data['averageIKM'].'%' }}</th>
        </tr>
    </tfoot>
</table>
