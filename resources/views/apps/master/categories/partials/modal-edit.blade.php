<div id="modalEditCategories" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <form id="editAspectForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Aspect</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoriesId" name="id">

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit_roles" class="form-label">Roles(Optional)</label>
                        <select id="edit_roles" name="role_id" class="form-select select2" multiple>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_aspects" class="form-label">Aspects</label>
                        <select id="edit_aspects" name="aspect_id" class="form-select">

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select name="edit_status" id="edit_status" class="form-control" required>
                            <option value="" disabled selected>Choose Status</option>
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea id="edit_description" name="description" class="form-control"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEditCategories">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
