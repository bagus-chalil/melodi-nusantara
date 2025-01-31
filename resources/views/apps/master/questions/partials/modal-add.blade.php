<div class="modal fade" id="modalAddQuestions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-questions">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <textarea type="text" name="name" id="name" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <select name="categories" id="categories" class="form-control select2" required>
                            @foreach ($data['categories'] as $category)
                                <option value="{{$category->id}}">{{$category->aspects->name}}-{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answers</label>
                        <select name="answers" id="answers" class="form-control select2" required>
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
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitAddQuestions">Submit</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

