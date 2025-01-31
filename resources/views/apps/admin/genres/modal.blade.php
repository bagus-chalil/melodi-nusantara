<!-- Modal Form -->
<div class="modal fade" id="genreModal">
    <div class="modal-dialog">
        <form id="genreForm">
            @csrf
            <input type="hidden" id="genreId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Genre</h5>
                    <button type="button" class="close" id="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nama Genre:</label>
                    <input type="text" id="name" name="name" class="form-control" required>

                    <label>Upload Cover:</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-control">
                    <img id="cover-preview" width="100" style="display:none;">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
