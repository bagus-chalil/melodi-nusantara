<div class="modal fade" id="modalExportResult" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Modal Export Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-export-result">
                    <div class="mb-3">
                        <input type="text" name="id_survey" id="id_survey" hidden readonly>
                        <label class="form-label">Divisi</label>
                        <select name="division" id="division" class="form-control select2" required>
                            <option value="999">Semua</option>
                            @foreach ($data['allDivision'] as $division)
                                <option value="{{$division->id}}">{{$division->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="exportDataResult">Export</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

