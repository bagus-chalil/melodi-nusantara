document.getElementById('filterButton').addEventListener('click', function() {
    const division = document.getElementById('division').value;
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('division', division);
    window.location.search = urlParams.toString();
});
