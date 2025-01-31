<div class="modal fade" id="modalAddBiodata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-biodata">
                    <div class="mb-3">
                        <label class="form-label">name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answers</label>
                        <select name="answers" id="answers" class="form-control select2" multiple required>
                            @foreach ($data['answers'] as $answer)
                                <option value="{{$answer->id}}">{{$answer->name}}</option>
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
                        <button type="button" class="btn btn-primary" id="submitAddBiodata">Submit</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

