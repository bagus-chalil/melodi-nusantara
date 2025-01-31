<!-- Song Modal -->
<div class="modal fade" id="songModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="songForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Song Form</h5>
                    <button type="button" class="close" id="closeModal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="songId" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="form-group">
                                <label>Artist <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="artist" required>
                            </div>

                            <div class="form-group">
                                <label>Genre <span class="text-danger">*</span></label>
                                <select class="form-control" name="genre_id" required>
                                    <option value="">Select Genre</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Audio File <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="fileInput" accept="audio/*">
                                    <label class="custom-file-label" for="fileInput">Choose file</label>
                                </div>
                                <small class="form-text text-muted">Allowed formats: MP3, WAV (Max 10MB)</small>
                                <div id="filePreview" class="mt-2"></div>
                            </div>

                            <div class="form-group">
                                <label>Region</label>
                                <input type="text" class="form-control" name="region">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Lyrics</label>
                        <textarea class="form-control" name="lyrics" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
