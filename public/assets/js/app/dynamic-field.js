function updateAssetFields(data) {
    // Update kolom yang sudah ada (statik)
    $('#tipe-fixed-asset').text(data.tipe_fixed_asset);
    $('#no-inventory').text(data.no_inventory);
    $('#no-asset').text(data.no_asset);
    $('#nama-asset').text(data.nama);
    $('#brand').text(data.brand ? data.brand.nama : '-');
    $('#nilai-perolehan').text(data.nilai_perolehan);
    $('#kategori-asset').text(data.kategori_asset ? data.kategori_asset.nama : '-');
    $('#golongan').text(data.golongan ? data.golongan.nama : '-');
    $('#entitas').text(data.entitas.entitas_code);
    $('#kategori-lokasi').text(data.kategori_lokasi ? data.kategori_lokasi.nama : '-');
    $('#informasi-lokasi').text(data.informasi_lokasi);
    $('#placement').text(data.placement ? data.placement.nama : '-');

    // Menampilkan dynamic_fields di bagian terpisah
    var dynamicFields = JSON.parse(data.dynamic_fields); // Parse JSON dynamic_fields
    var dynamicDetails = $('#dynamic-details'); // Bagian khusus untuk dynamic fields
    dynamicDetails.empty(); // Hapus data lama dynamic fields

    // Loop melalui key-value dari dynamic_fields
    $.each(dynamicFields, function (key, value) {
        if (value !== null) {
            var formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()); // Format key jadi lebih rapi
            dynamicDetails.append(`
                <div class="col-6 mb-2">
                    <dt class="form-label text-muted mb-1">${formattedKey}</dt>
                    <dl class="form-label">${value}</dl>
                </div>
            `);
        }
    });
}

function resetAssetFields() {
    // Reset semua field statik
    $('#tipe-fixed-asset').text('-');
    $('#no-inventory').text('-');
    $('#no-asset').text('-');
    $('#nama-asset').text('-');
    $('#brand').text('-');
    $('#nilai-perolehan').text('-');
    $('#kategori-asset').text('-');
    $('#golongan').text('-');
    $('#entitas').text('-');
    $('#kategori-lokasi').text('-');
    $('#informasi-lokasi').text('-');
    $('#placement').text('-');

    // Kosongkan dynamic fields
    $('#dynamic-details').empty();
}

$('#submit-button').on('click', function (e) {
    e.preventDefault();

    // Disable button and show spinner
    $('#submit-button').attr('disabled', true);
    $('#button-spinner').removeClass('d-none');

    // Submit the form
    $('form').submit();
});

// Cek apakah ada fixed_asset_id dari URL dan jalankan fetchAssetData jika ada
var urlParams = new URLSearchParams(window.location.search);
var fixedAssetId = urlParams.get('fixed_asset_id');
if (fixedAssetId) {
    $('#fixed_asset_id').val(fixedAssetId).trigger('change');
    fetchAssetData(fixedAssetId); // Memanggil fungsi saat halaman pertama kali dimuat
}

// Menjalankan fungsi saat fixed_asset_id diubah
$('#fixed_asset_id').change(function () {
    var assetId = $(this).val();
    fetchAssetData(assetId); // Memanggil fungsi saat asset ID berubah
});

