$(document).ready(function () {
    let dataTable;
    // Inisialisasi DataTable
    dataTable = $('#datatable-survey-result').DataTable({
        processing: true,
        serverSide: true,
        pagination: true,
        searching: true,
        ajax: {
            url: "/survey/survey-results",
        },
        columns: [
            { data: 'aspect_id', name: 'aspect_id' },
            { data: 'aspect_name', name: 'aspect_name' },
            { data: 'category_id', name: 'category_id' },
            { data: 'category_name', name: 'category_name' },
            { data: 'question_id', name: 'question_id' },
            { data: 'answer_id', name: 'answer_id' },
        ],
        order: [[0, 'asc'], [2, 'asc']],
    });

    document.getElementById('filterButton').addEventListener('click', function() {
        let division = document.getElementById('division').value;
        let sort = document.getElementById('sort').value;
        let direction = document.getElementById('direction').value;
        let perPage = document.getElementById('per_page').value;

        let url = `?division=${division}&sort=${sort}&direction=${direction}&per_page=${perPage}`;
        window.location.href = url;
    });
});


