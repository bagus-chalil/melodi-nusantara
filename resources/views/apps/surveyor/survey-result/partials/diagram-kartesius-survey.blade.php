@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<script>
    const ctx = document.getElementById('scatterChart').getContext('2d');

    // Data untuk scatterplot
    const dataPoints = @json($data['report']); // Data dari controller
    const performanceValues = dataPoints.map((point) => ({
        x: point.importance, // Sumbu X
        y: point.performance, // Sumbu Y
        name: point.name // Nama kategori untuk tooltip
    }));

    // Titik tengah berdasarkan rata-rata
    const avgX = {{ $data['averageImportance'] }}; // Rata-rata Harapan (Importance)
    const avgY = {{ $data['averagePerformance'] }}; // Rata-rata Kepuasan (Performance)

    // Menentukan kuadran untuk setiap titik
    const categorizedPoints = performanceValues.map((point) => {
        let quadrant;
        if (point.x < avgX && point.y > avgY) quadrant = 1; // Kuadran 1: Kiri Atas
        else if (point.x >= avgX && point.y > avgY) quadrant = 2; // Kuadran 2: Kanan Atas
        else if (point.x < avgX && point.y <= avgY) quadrant = 3; // Kuadran 3: Kiri Bawah
        else if (point.x >= avgX && point.y <= avgY) quadrant = 4; // Kuadran 4: Kanan Bawah
        return { ...point, quadrant };
    });

    // Render chart
    const chart = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    label: 'Kategori',
                    data: categorizedPoints,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)', // Warna titik
                    pointRadius: 5,
                },
                {
                    label: 'Titik Tengah (Rata-rata)',
                    data: [{ x: avgX, y: avgY }],
                    backgroundColor: 'rgba(255, 99, 132, 1)', // Warna titik rata-rata
                    pointRadius: 10,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const point = categorizedPoints[context.dataIndex];
                            return `${point.name}: (${point.x}, ${point.y}) - Kuadran ${point.quadrant}`;
                        },
                    },
                },
                annotation: {
                    annotations: {
                        // Garis vertikal (sumbu Y)
                        verticalLine: {
                            type: 'line',
                            xMin: avgX,
                            xMax: avgX,
                            borderColor: 'rgba(255, 99, 132, 0.8)',
                            borderWidth: 2,
                            label: {
                                display: true,
                                content: 'Rata-rata Harapan (X)',
                                position: 'start',
                            },
                        },
                        // Garis horizontal (sumbu X)
                        horizontalLine: {
                            type: 'line',
                            yMin: avgY,
                            yMax: avgY,
                            borderColor: 'rgba(75, 192, 192, 0.8)',
                            borderWidth: 2,
                            label: {
                                display: true,
                                content: 'Rata-rata Kepuasan (Y)',
                                position: 'start',
                            },
                        },
                        // Label kuadran 1
                        quadrant1Label: {
                            type: 'label',
                            xValue: avgX - 1,
                            yValue: avgY + 1,
                            content: 'Kuadran 1',
                            backgroundColor: 'rgba(255, 205, 86, 0.8)',
                        },
                        // Label kuadran 2
                        quadrant2Label: {
                            type: 'label',
                            xValue: avgX + 1,
                            yValue: avgY + 1,
                            content: 'Kuadran 2',
                            backgroundColor: 'rgba(201, 203, 207, 0.8)',
                        },
                        // Label kuadran 3
                        quadrant3Label: {
                            type: 'label',
                            xValue: avgX - 1,
                            yValue: avgY - 1,
                            content: 'Kuadran 3',
                            backgroundColor: 'rgba(255, 159, 64, 0.8)',
                        },
                        // Label kuadran 4
                        quadrant4Label: {
                            type: 'label',
                            xValue: avgX + 1,
                            yValue: avgY - 1,
                            content: 'Kuadran 4',
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        },
                    },
                },
                zoom: {
                    zoom: {
                        wheel: { enabled: true }, // Zoom menggunakan roda mouse
                        pinch: { enabled: true }, // Zoom menggunakan pinch (layar sentuh)
                        mode: 'xy', // Zoom di kedua sumbu (X dan Y)
                    },
                    pan: {
                        enabled: true, // Geser diagram
                        mode: 'xy',
                    },
                },
            },
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Harapan (Importance)',
                    },
                    min: Math.min(...categorizedPoints.map(p => p.x)) - 0.5,
                    max: Math.max(...categorizedPoints.map(p => p.x)) + 0.5,
                },
                y: {
                    title: {
                        display: true,
                        text: 'Kepuasan (Performance)',
                    },
                    min: Math.min(...categorizedPoints.map(p => p.y)) - 0.5,
                    max: Math.max(...categorizedPoints.map(p => p.y)) + 0.5,
                },
            },
        },
    });

    // Fungsi untuk reset zoom
    function resetZoom() {
        chart.resetZoom();
    }

    // Fungsi untuk print diagram
    function printChart() {
        const canvas = document.getElementById('scatterChart');
        const img = canvas.toDataURL('image/png', 1.0); // Mengambil gambar dari canvas
        const newWindow = window.open('', '_blank');
        newWindow.document.write(`<img src="${img}" />`);
        newWindow.document.close();
    }

    // Render tabel di bawah chart
    const tableContainer = document.getElementById('quadrantTableContainer');
    let tableHTML = `
        <table border="1" class="table table-bordered text-nowrap align-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kategori</th>
                    <th>Koordinat (X, Y)</th>
                    <th>Kuadran</th>
                </tr>
            </thead>
            <tbody>
    `;

    categorizedPoints.forEach((point, index) => {
        tableHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${point.name}</td>
                <td>(${point.x}, ${point.y})</td>
                <td>${point.quadrant}</td>
            </tr>
        `;
    });

    tableHTML += '</tbody></table>';
    tableContainer.innerHTML = tableHTML;
</script>
@endpush

<div>
    <canvas id="scatterChart"></canvas>
</div>
<div>
    <button onclick="resetZoom()">Reset Zoom</button>
    <button onclick="printChart()">Print</button>
</div>
<div id="quadrantTableContainer"></div>
