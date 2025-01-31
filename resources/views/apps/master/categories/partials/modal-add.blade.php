<div class="modal fade" id="modalAddCategories" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-categories">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Roles(Optional)</label>
                        <select name="role" id="role" class="form-control select2" required multiple>
                            @foreach ($data['roles'] as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aspects</label>
                        <select name="aspect" id="aspect" class="form-control" required>
                            <option value="" selected disabled>Choosen Aspect</option>
                            @foreach ($data['aspects'] as $aspect)
                                <option value="{{$aspect->id}}">{{$aspect->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="" disabled selected>Choose Status</option>
                            <option value="0">Not Active</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description(Optional)</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitAddCategories">Submit</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

