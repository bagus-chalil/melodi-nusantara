<div class="modal fade" id="modalEditQuestions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <form id="form-edit-questions">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="questionId" name="id" class="form-control" placeholder="Id" readonly hidden>
                        <textarea type="text" name="edit_name" id="edit_name" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <select name="edit_categories" id="edit_categories" class="form-control select2" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answers</label>
                        <select name="edit_answer" id="edit_answer" class="form-control select2" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="edit_status" id="edit_status" class="form-control" required>
                            <option value="" disabled selected>Choose Status</option>
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitEditQuestions">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
