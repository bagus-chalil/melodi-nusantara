<div class="modal fade" id="modalAddAnswers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-answers">
                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" id="label" class="form-control" placeholder="label" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        @php
                            $typeData = ["checkbox","select","textarea","input","radiobutton"];
                        @endphp
                        <select name="type" id="type" class="form-control select2" required>
                            @foreach ($typeData as $item)
                                <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Conditional Input for "select" -->
                    <div class="mb-3" id="input-container" style="display:none;">
                        <label class="form-label">Data Select</label>
                        <input type="text" name="data" id="data-input" class="form-control" placeholder="Enter data">
                    </div>

                    <!-- Conditional Select2 for "checkbox" -->
                    <div class="mb-3" id="checkbox-container" style="display:none;">
                        <label class="form-label">Data Checkboxes</label>
                        <select name="data[]" id="data-checkbox" class="form-control select2" multiple>
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
                        <button type="button" class="btn btn-primary" id="submitAddAnswers">Submit</button>
                    </div>
                </div>
                </form>
        </div>
    </div>
</div>
<!-- end modal-->

