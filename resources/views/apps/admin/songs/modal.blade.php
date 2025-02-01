<div class="modal fade" id="songModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="songForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="songId" name="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Lagu</h5>
                    <button type="button" class="close" id="closeModal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="errorAlert" class="alert alert-danger d-none"></div> <!-- Alert Error -->

                    <div class="row">
                        <div class="col-md-6">
                            <label>Judul Lagu <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required>
                            <br>

                            <label>Kategori <span class="text-danger">*</span></label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <option value="daerah">Daerah</option>
                                <option value="nasional">Nasional</option>
                            </select>
                            <br>

                            <label>Region</label>
                            <input type="text" id="region" name="region" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>File Audio <span class="text-danger">*</span></label>
                            <input type="file" id="file" name="file" class="form-control">
                            <audio id="audioPreview" class="mt-2 w-100" controls style="display: none;"></audio>
                            <br>

                            <label>Thumbnail</label>
                            <input type="file" id="thumbnail" name="thumbnail" class="form-control">
                            <img id="thumbnail-preview" width="100" class="mt-2" style="display: none;">
                            <br>

                            <label>File Lirik (PDF/DOC)</label>
                            <input type="file" id="lyrics" name="lyrics" class="form-control">
                            <a id="lyricsPreview" href="#" class="mt-2 d-block text-primary" target="_blank" style="display: none;">Download Lirik</a>
                        </div>

                        <div class="col-12">
                            <label>Sumber</label>
                            <input type="url" id="source" name="source" class="form-control">
                            <br>
                            <label>Deskripsi</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
