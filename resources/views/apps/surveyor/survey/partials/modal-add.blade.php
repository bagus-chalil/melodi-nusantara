<div class="modal fade" id="modalAddSurvey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-survey">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biodata</label>
                        <select name="biodatas" id="biodatas" class="form-control select2" multiple required>
                            @foreach ($data['biodatas'] as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aspects</label>
                        <select name="aspects" id="aspects" class="form-control select2" multiple required>
                            @foreach ($data['aspects'] as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quota (Jika tidak membutuhkan diisi = 0)</label>
                        <input type="number" name="quota" id="quota" class="form-control" min="0" minlength="1" placeholder="Quota" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description(Optional)</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitAddSurvey">Submit</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

