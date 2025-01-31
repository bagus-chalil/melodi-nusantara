<div id="modalEditAnswers" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editAnswersForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="answersId" name="id">

                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control">
                    </div>

                    <!-- Type Dropdown -->
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Type</label>
                        <select id="edit_type" name="type" class="form-control select2" required>
                            <option value="checkbox">Checkbox</option>
                            <option value="select">Select</option>
                            <option value="textarea">Textarea</option>
                            <option value="input">Input</option>
                            <option value="radiobutton">Radiobutton</option>
                        </select>
                    </div>

                    <!-- Conditional Input for "select" -->
                    <div class="mb-3" id="edit-input-container" style="display:none;">
                        <label class="form-label">Data Select</label>
                        <input type="text" name="data" id="edit_data_input" class="form-control" placeholder="Enter data">
                    </div>

                    <!-- Conditional Select2 for "checkbox" -->
                    <div class="mb-3" id="edit-checkbox-container" style="display:none;">
                        <label class="form-label">Data Checkboxes</label>
                        <select name="data[]" id="edit_data_checkbox" class="form-control select2" multiple></select>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select name="edit_status" id="edit_status" class="form-control" required>
                            <option value="" disabled selected>Choose Status</option>
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEditAnswers">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
