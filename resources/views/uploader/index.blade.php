
@push('js')
@once
<script src="{{ asset('assets/js/uppy.min.js') }}"></script>
@endonce
@endpush

@once
<link rel="stylesheet" href="{{ asset('assets/css/uppy.min.css') }}">
@endonce
<div class="modal fade" id="uploaderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="uploaderModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-light">
            {{-- <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link font-weight-medium text-dark active" data-toggle="tab"
                        href="#select-file" aria-controls="select-file">Select File</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-medium text-dark" data-toggle="tab"
                        href="#upload-new" aria-controls="upload-new">Upload New
                    </a>
                </li>
            </ul> --}}
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link font-weight-medium text-dark active" data-bs-toggle="tab" href="#select-file" role="tab" aria-selected="false">
                        Select File
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-medium text-dark" data-bs-toggle="tab" href="#upload-new" role="tab" aria-selected="false">
                        Upload New
                    </a>
                </li>
            </ul>
            <button type="button" class="close border-none" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-close"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="tab-content">
                <div class="tab-pane h-100 active" id="select-file" role="tabpanel">
                    <div class="uploader-filter pt-1 pb-3 border-bottom mb-4">
                        <div class="row align-items-center gutters-5 gutters-md-10 position-relative">
                            <div class="col-xl-2 col-md-3 col-5">
                                <div class="">
                                    <!-- Input -->
                                    <select class="form-select" name="uploader-sort">
                                        <option value="newest" selected="">Sort by newest</option>
                                        <option value="oldest">Sort by oldest</option>
                                        <option value="smallest">Sort by smallest</option>
                                        <option value="largest">Sort by largest</option>
                                    </select>
                                    <!-- End Input -->
                                </div>
                            </div>
                            <div class="col-md-3 col-5">
                                <div class="">
                                    <input type="checkbox" class="form-checkbox" name="showSelected"
                                        id="showSelected">
                                    <label class="form-label" for="showSelected"> Selected Only </label>
                                </div>
                            </div>
                            <div class="col-5 m-auto position-static">
                                <div class="uploader-search text-right">
                                    <input type="text" class="form-control" name="uploader-search"
                                        placeholder="Search your files" autocomplete="off"> <i
                                        class="search-icon d-md-none"><span></span></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uploader-all scrollbar-light">

                    </div>
                </div>
                <div class="tab-pane h-100" id="upload-new" role="tabpanel">
                    <div id="upload-files" class="h-100"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between bg-light">
            <div class="flex-grow-1 overflow-hidden d-flex">
                <div class="">
                    <div class="uploader-selected">0 File selected</div>
                    <button type="button" class="btn-link btn btn-sm p-0 uploader-selected-clear">Clear</button>
                </div>
                <div class="mb-0 ms-3">
                    <button type="button" class="btn btn-sm btn-primary" id="uploader_prev_btn" disabled="disabled">Prev</button>
                    <button type="button" class="btn btn-sm btn-primary" id="uploader_next_btn">Next</button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="uploaderAddSelected">Add Files</button>
        </div>
    </div>

</div>
</div>
