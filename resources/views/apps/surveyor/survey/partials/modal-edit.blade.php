<div id="modalEditSurvey" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editSurveyForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="surveyId" name="id">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biodata</label>
                        <select name="edit_biodatas" id="edit_biodatas" class="form-control select2" multiple required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aspects</label>
                        <select name="edit_aspects" id="edit_aspects" class="form-control select2" multiple required>

                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="edit_start_date" id="edit_start_date" class="form-control" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="edit_end_date" id="edit_end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quota (Jika tidak membutuhkan diisi = 0)</label>
                        <input type="number" name="edit_quota" id="edit_quota" class="form-control" min="0" minlength="1" placeholder="Quota" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description(Optional)</label>
                        <textarea name="edit_description" id="edit_description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEditSurvey">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
