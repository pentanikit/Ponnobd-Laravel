$.fn.toggleAttr = function (attr, attr1, attr2) {
    return this.each(function () {
        var self = $(this);
        if (self.attr(attr) == attr1) self.attr(attr, attr2);
        else self.attr(attr, attr1);
    });
};

// CSRF Token setup for AJAX request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Bulk Delete
$('#allSelected').on('click', function () {
    var checkboxes = document.querySelectorAll('input[id=bulkDelete]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].id !== 'allSelected') {
            checkboxes[i].checked = this.checked;
        }
    }
});

$('#deleteSelected').on('click', function (e) {
    e.preventDefault();

    var ids = [];

    $('#bulkDelete:checked').each(function () {
        ids.push($(this).val());
    });


    var confirmation = confirm('Are you sure?');

    if (ids.length > 0 && confirmation == true) {
        $.ajax({
            url: $(this).attr('href'),
            type: 'DELETE',
            data: 'ids=' + ids.join(","),
            success: function (data) {
                window.location.reload();
            },
            error: function (data) {
                alert('Whoops, Something went wrong!!');
            }
        });

    } else if (ids.length == 0) {
        alert('Please select row');
    }
});

// Add More
$('[data-toggle="add-more"]').each(function () {
    var $this = $(this);
    var content = $this.data("content");
    var target = $this.data("target");

    $this.on("click", function (e) {
        e.preventDefault();
        $(target).append(content);
    });
});

$(document).on(
    "click",
    '[data-toggle="remove-parent"]',
    function () {
        var $this = $(this);
        var parent = $this.data("parent");
        $this.closest(parent).remove();
    }
);

(function ($) {
    // USE STRICT
    "use strict";

    data = {
        csrf: $('meta[name="csrf-token"]').attr("content"),
        appUrl: $('meta[name="app-url"]').attr("content"),
    };

    let get_uploaded_url = data.appUrl + '/uploader/get_uploaded_files';
    let fileBaseUrl =  $('meta[name="file-base-url"]').attr("content");


    uploader = {
        data: {
            selectedFiles: [],
            selectedFilesObject: [],
            clickedForDelete: null,
            allFiles: [],
            multiple: false,
            type: "all",
            next_page_url: null,
            prev_page_url: null,

        },

        plugins: {
            bytesToSize: function (bytes) {
                var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
                if (bytes == 0) return "0 Byte";
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
            }
        },


        removeInputValue: function (id, array, elem) {
            var selected = array.filter(function (item) {
                return item !== id;
            });
            if (selected.length > 0) {
                $(elem)
                    .find(".file-amount")
                    .html(uploader.updateFileHtml(selected));
            } else {
                elem.find(".file-amount").html(local.choose_file);
            }
            $(elem).find(".selected-files").val(selected);
        },
        removeAttachment: function () {
            $(document).on("click",'.remove-attachment', function () {
                var value = $(this)
                    .closest(".file-preview-item")
                    .data("id");
                var selected = $(this)
                    .closest(".file-preview")
                    .prev('[data-toggle="uploader"]')
                    .find(".selected-files")
                    .val()
                    .split(",")
                    .map(Number);

                uploader.removeInputValue(
                    value,
                    selected,
                    $(this)
                        .closest(".file-preview")
                        .prev('[data-toggle="uploader"]')
                );
                $(this).closest(".file-preview-item").remove();
            });
        },
        deleteUploaderFile: function () {
            $(".uploader-delete").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    uploader.data.clickedForDelete = id;
                    $("#uploaderDelete").modal("show");

                    $(".uploader-confirmed-delete").on("click", function (
                        e
                    ) {
                        e.preventDefault();
                        if (e.detail === 1) {
                            var clickedForDeleteObject =
                                uploader.data.allFiles[
                                    uploader.data.allFiles.findIndex(
                                        (x) =>
                                            x.id ===
                                            uploader.data.clickedForDelete
                                    )
                                ];
                            $.ajax({
                                url:
                                    data.appUrl +
                                    "/uploader/destroy/" +
                                    uploader.data.clickedForDelete,
                                type: "DELETE",
                                dataType: "JSON",
                                data: {
                                    id: uploader.data.clickedForDelete,
                                    _method: "DELETE",
                                    _token: data.csrf,
                                },
                                success: function () {
                                    uploader.data.selectedFiles = uploader.data.selectedFiles.filter(
                                        function (item) {
                                            return (
                                                item !==
                                                uploader.data
                                                    .clickedForDelete
                                            );
                                        }
                                    );
                                    uploader.data.selectedFilesObject = uploader.data.selectedFilesObject.filter(
                                        function (item) {
                                            return (
                                                item !== clickedForDeleteObject
                                            );
                                        }
                                    );
                                    uploader.updateUploaderSelected();
                                    uploader.getAllUploads(
                                        get_uploaded_url
                                    );
                                    uploader.data.clickedForDelete = null;
                                    $("#uploaderDelete").modal("hide");
                                },
                            });
                        }
                    });
                });
            });
        },
        uploadSelect: function () {
            $(".uploader-select").each(function () {
                var elem = $(this);
                elem.on("click", function (e) {
                    var value = $(this).data("value");
                    var valueObject =
                        uploader.data.allFiles[
                            uploader.data.allFiles.findIndex(
                                (x) => x.id === value
                            )
                        ];
                    // console.log(valueObject);

                    elem.closest(".file-box-wrap").toggleAttr(
                        "data-selected",
                        "true",
                        "false"
                    );
                    if (!uploader.data.multiple) {
                        elem.closest(".file-box-wrap")
                            .siblings()
                            .attr("data-selected", "false");
                    }
                    if (!uploader.data.selectedFiles.includes(value)) {
                        if (!uploader.data.multiple) {
                            uploader.data.selectedFiles = [];
                            uploader.data.selectedFilesObject = [];
                        }
                        uploader.data.selectedFiles.push(value);
                        uploader.data.selectedFilesObject.push(valueObject);
                    } else {
                        uploader.data.selectedFiles = uploader.data.selectedFiles.filter(
                            function (item) {
                                return item !== value;
                            }
                        );
                        uploader.data.selectedFilesObject = uploader.data.selectedFilesObject.filter(
                            function (item) {
                                return item !== valueObject;
                            }
                        );
                    }
                    uploader.addSelectedValue();
                    uploader.updateUploaderSelected();
                });
            });
        },
        updateFileHtml: function (array) {
            var fileText = "";
            if (array.length > 1) {
                var fileText = local.files_selected;
            } else {
                var fileText = local.file_selected;
            }
            return array.length + " " + fileText;
        },
        updateUploaderSelected: function () {
            $(".uploader-selected").html(
                uploader.updateFileHtml(uploader.data.selectedFiles)
            );
        },
        clearUploaderSelected: function () {
            $(".uploader-selected-clear").on("click", function () {
                uploader.data.selectedFiles = [];
                uploader.addSelectedValue();
                uploader.addHiddenValue();
                uploader.resetFilter();
                uploader.updateUploaderSelected();
                uploader.updateUploaderFiles();
            });
        },
        resetFilter: function () {
            $('[name="uploader-search"]').val("");
            $('[name="show-selected"]').prop("checked", false);
            $('[name="uploader-sort"] option[value=newest]').prop(
                "selected",
                true
            );
        },
        getAllUploads: function (url, search_key = null, sort_key = null) {

            $(".uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );
            var params = {};
            if (search_key != null && search_key.length > 0) {
                params["search"] = search_key;
            }
            if (sort_key != null && sort_key.length > 0) {
                params["sort"] = sort_key;
            }
            else{
                params["sort"] = 'newest';
            }
            $.get(url, params, function (data, status) {
                // console.log(data);
                if(typeof data == 'string'){
                    data = JSON.parse(data);
                }
                uploader.data.allFiles = data.data;
                uploader.allowedFileType();
                uploader.addSelectedValue();
                uploader.addHiddenValue();
                //uploader.resetFilter();
                uploader.updateUploaderFiles();
                if (data.next_page_url != null) {
                    uploader.data.next_page_url = data.next_page_url;
                    $("#uploader_next_btn").removeAttr("disabled");
                } else {
                    $("#uploader_next_btn").attr("disabled", true);
                }
                if (data.prev_page_url != null) {
                    uploader.data.prev_page_url = data.prev_page_url;
                    $("#uploader_prev_btn").removeAttr("disabled");
                } else {
                    $("#uploader_prev_btn").attr("disabled", true);
                }
            });
        },
        showSelectedFiles: function () {
            $('[name="showSelected"]').on("change", function () {
                if ($(this).is(":checked")) {
                    // for (
                    //     var i = 0;
                    //     i < uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     if (uploader.data.allFiles[i].selected) {
                    //         uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = false;
                    //     } else {
                    //         uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = true;
                    //     }
                    // }
                    uploader.data.allFiles =
                        uploader.data.selectedFilesObject;
                } else {
                    // for (
                    //     var i = 0;
                    //     i < uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     uploader.data.allFiles[
                    //         i
                    //     ].aria_hidden = false;
                    // }
                    uploader.getAllUploads(
                        get_uploaded_url
                    );
                }
                uploader.updateUploaderFiles();
            });
        },
        searchUploaderFiles: function () {
            $('[name="uploader-search"]').on("keyup", function () {
                var value = $(this).val();
                uploader.getAllUploads(
                    data.appUrl + "/uploader/get_uploaded_files",
                    value,
                    $('[name="uploader-sort"]').val()
                );
                // if (uploader.data.allFiles.length > 0) {
                //     for (
                //         var i = 0;
                //         i < uploader.data.allFiles.length;
                //         i++
                //     ) {
                //         if (
                //             uploader.data.allFiles[
                //                 i
                //             ].file_original_name
                //                 .toUpperCase()
                //                 .indexOf(value) > -1
                //         ) {
                //             uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = false;
                //         } else {
                //             uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = true;
                //         }
                //     }
                // }
                //uploader.updateUploaderFiles();
            });
        },
        sortUploaderFiles: function () {
            $('[name="uploader-sort"]').on("change", function () {
                var value = $(this).val();
                uploader.getAllUploads(
                    get_uploaded_url,
                    $('[name="uploader-search"]').val(),
                    value
                );

                // if (value === "oldest") {
                //     uploader.data.allFiles = uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return (
                //                 new Date(a.created_at) - new Date(b.created_at)
                //             );
                //         }
                //     );
                // } else if (value === "smallest") {
                //     uploader.data.allFiles = uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return a.file_size - b.file_size;
                //         }
                //     );
                // } else if (value === "largest") {
                //     uploader.data.allFiles = uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return b.file_size - a.file_size;
                //         }
                //     );
                // } else {
                //     uploader.data.allFiles = uploader.data.allFiles.sort(
                //         function(a, b) {
                //             a = new Date(a.created_at);
                //             b = new Date(b.created_at);
                //             return a > b ? -1 : a < b ? 1 : 0;
                //         }
                //     );
                // }
                //uploader.updateUploaderFiles();
            });
        },
        addSelectedValue: function () {
            for (var i = 0; i < uploader.data.allFiles.length; i++) {
                if (
                    !uploader.data.selectedFiles.includes(
                        uploader.data.allFiles[i].id
                    )
                ) {
                    uploader.data.allFiles[i].selected = false;
                } else {
                    uploader.data.allFiles[i].selected = true;
                }
            }
        },
        addHiddenValue: function () {
            for (var i = 0; i < uploader.data.allFiles.length; i++) {
                uploader.data.allFiles[i].aria_hidden = false;
            }
        },
        allowedFileType: function () {
            if (uploader.data.type !== "all") {
                let type = uploader.data.type.split(',')
                uploader.data.allFiles = uploader.data.allFiles.filter(
                    function (item) {
                        return type.includes(item.type);
                    }
                );
            }
        },
        updateUploaderFiles: function () {
            $(".uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );

            var data = uploader.data.allFiles;

            setTimeout(function () {
                $(".uploader-all").html(null);

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var thumb = "";
                        var hidden = "";
                        if (data[i].type === "image") {
                            thumb =
                                '<img src="' +
                                fileBaseUrl +
                                data[i].file_name +
                                '" class="img-fit">';
                        } else {
                            thumb = '<i class="fa fa-file"></i>';
                        }
                        var html =
                            '<div class="file-box-wrap" aria-hidden="' +
                            data[i].aria_hidden +
                            '" data-selected="' +
                            data[i].selected +
                            '">' +
                            '<div class="file-box">' +
                            // '<div class="dropdown-file">' +
                            // '<a class="dropdown-link" data-toggle="dropdown">' +
                            // '<i class="faa faa-ellipsis-v"></i>' +
                            // "</a>" +
                            // '<div class="dropdown-menu dropdown-menu-right">' +
                            // '<a href="' +
                            // fileBaseUrl +
                            // data[i].file_name +
                            // '" target="_blank" download="' +
                            // data[i].file_original_name +
                            // "." +
                            // data[i].extension +
                            // '" class="dropdown-item"><i class="fa fa-download mr-2"></i>Download</a>' +
                            // '<a href="#" class="dropdown-item uploader-delete" data-id="' +
                            // data[i].id +
                            // '"><i class="fa fa-trash mr-2"></i>Delete</a>' +
                            // "</div>" +
                            // "</div>" +
                            '<div class="card card-file uploader-select" title="' +
                            data[i].file_original_name +
                            "." +
                            data[i].extension +
                            '" data-value="' +
                            data[i].id +
                            '">' +
                            '<div class="card-file-thumb">' +
                            thumb +
                            "</div>" +
                            '<div class="card-body">' +
                            '<h6 class="d-flex">' +
                            '<span class="text-truncate title">' +
                            data[i].file_original_name +
                            "</span>" +
                            '<span class="ext flex-shrink-0">.' +
                            data[i].extension +
                            "</span>" +
                            "</h6>" +
                            "<p>" +
                            uploader.plugins.bytesToSize(data[i].file_size) +
                            "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";

                        $(".uploader-all").append(html);
                    }
                } else {
                    $(".uploader-all").html(
                        '<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>No files found</h3></div></div>'
                    );
                }
                uploader.uploadSelect();
                uploader.deleteUploaderFile();
            }, 300);
        },
        inputSelectPreviewGenerate: function (elem) {
            elem.find(".selected-files").val(uploader.data.selectedFiles);
            elem.next(".file-preview").html(null);

            if (uploader.data.selectedFiles.length > 0) {

                $.post(
                    data.appUrl + "/uploader/get_file_by_ids",
                    { _token: data.csrf, ids: uploader.data.selectedFiles.toString() },
                    function (data) {

                        elem.next(".file-preview").html(null);

                        if (data.length > 0) {
                            elem.find(".file-amount").html(
                                uploader.updateFileHtml(data)
                            );
                            for (
                                var i = 0;
                                i < data.length;
                                i++
                            ) {
                                var thumb = "";
                                if (data[i].type === "image") {
                                    thumb =
                                        '<img src="' +
                                        fileBaseUrl+data[i].file_name +
                                        '" class="img-fit">';
                                } else {
                                    thumb = '<i class="fa fa-file"></i>';
                                }
                                var html =
                                    '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                    data[i].id +
                                    '" title="' +
                                    data[i].file_original_name +
                                    "." +
                                    data[i].extension +
                                    '">' +
                                    '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                    thumb +
                                    "</div>" +
                                    '<div class="col body">' +
                                    '<h6 class="d-flex">' +
                                    '<span class="text-truncate title">' +
                                    data[i].file_original_name +
                                    "</span>" +
                                    '<span class="flex-shrink-0 ext">.' +
                                    data[i].extension +
                                    "</span>" +
                                    "</h6>" +
                                    "<p>" +
                                    uploader.plugins.bytesToSize(
                                        data[i].file_size
                                    ) +
                                    "</p>" +
                                    "</div>" +
                                    '<div class="remove">' +
                                    '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                    '<i class="fa fa-close"></i>' +
                                    "</button>" +
                                    "</div>" +
                                    "</div>";

                                elem.next(".file-preview").append(html);
                            }
                        } else {
                            elem.find(".file-amount").html(local.choose_file);
                        }
                });
            } else {
                elem.find(".file-amount").html(local.choose_file);
            }

        },
        editorImageGenerate: function (elem) {
            if (uploader.data.selectedFiles.length > 0) {
                for (
                    var i = 0;
                    i < uploader.data.selectedFiles.length;
                    i++
                ) {
                    var index = uploader.data.allFiles.findIndex(
                        (x) => x.id === uploader.data.selectedFiles[i]
                    );
                    var thumb = "";
                    if (uploader.data.allFiles[index].type === "image") {
                        thumb =
                            '<img src="' +
                            fileBaseUrl +
                            uploader.data.allFiles[index].file_name +
                            '">';
                        elem[0].insertHTML(thumb);
                        // console.log(elem);
                    }
                }
            }
        },
        dismissUploader: function () {
            $("#uploaderModal").on("hidden.bs.modal", function () {
                $(".uploader-backdrop").remove();
                $("#uploaderModal").remove();
            });
        },
        ponnoUppy: function () {
            if ($("#upload-files").length > 0) {
                var ponnoUppy = Uppy.Core({
                    autoProceed: true,
                });
                ponnoUppy.use(Uppy.Dashboard, {
                    target: "#upload-files",
                    inline: true,
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false,
                    locale: {
                        strings: {
                            addMoreFiles: local.add_more_files,
                            addingMoreFiles: local.adding_more_files,
                            dropPaste: local.drop_files_here_paste_or+' %{browse}',
                            browse: local.browse,
                            uploadComplete: local.upload_complete,
                            uploadPaused: local.upload_paused,
                            resumeUpload: local.resume_upload,
                            pauseUpload: local.pause_upload,
                            retryUpload: local.retry_upload,
                            cancelUpload: local.cancel_upload,
                            xFilesSelected: {
                                0: '%{smart_count} '+local.file_selected,
                                1: '%{smart_count} '+local.files_selected
                            },
                            uploadingXFiles: {
                                0: local.uploading+' %{smart_count} '+local.file,
                                1: local.uploading+' %{smart_count} '+local.files
                            },
                            processingXFiles: {
                                0: local.processing+' %{smart_count} '+local.file,
                                1: local.processing+' %{smart_count} '+local.files
                            },
                            uploading: local.uploading,
                            complete: local.complete,
                        }
                    }
                });
                ponnoUppy.use(Uppy.XHRUpload, {
                    endpoint: data.appUrl + "/uploader/upload",
                    fieldName: "file",
                    formData: true,
                    headers: {
                        'X-CSRF-TOKEN': data.csrf,
                    },
                });
                ponnoUppy.on("upload-success", function () {
                    uploader.getAllUploads(
                        get_uploaded_url
                    );
                });
            }
        },
        trigger: function (
            elem = null,
            from = "",
            type = "all",
            selectd = "",
            multiple = false,
            callback = null
        ) {
            // $("body").append('<div class="uploader-backdrop"></div>');

            var elem = $(elem);
            var multiple = multiple;
            var type = type;
            var oldSelectedFiles = selectd;
            if (oldSelectedFiles !== "") {
                uploader.data.selectedFiles = oldSelectedFiles
                    .split(",")
                    .map(Number);
            } else {
                uploader.data.selectedFiles = [];
            }
            if ("undefined" !== typeof type && type.length > 0) {
                uploader.data.type = type;
            }

            if (multiple) {
                uploader.data.multiple = true;
            }else{
                uploader.data.multiple = false;
            }
            // setTimeout(function() {
            $.post(
                data.appUrl + "/uploader",
                { _token: data.csrf },
                function (data) {
                    $("body").append(data);
                    $("#uploaderModal").modal("show");
                    uploader.ponnoUppy();
                    uploader.getAllUploads(
                        get_uploaded_url,
                        null,
                        $('[name="uploader-sort"]').val()
                    );
                    uploader.updateUploaderSelected();
                    uploader.clearUploaderSelected();
                    uploader.sortUploaderFiles();
                    uploader.searchUploaderFiles();
                    uploader.showSelectedFiles();
                    uploader.dismissUploader();

                    $("#uploader_next_btn").on("click", function () {
                        if (uploader.data.next_page_url != null) {
                            $('[name="show-selected"]').prop(
                                "checked",
                                false
                            );
                            uploader.getAllUploads(
                                uploader.data.next_page_url
                            );
                        }
                    });

                    $("#uploader_prev_btn").on("click", function () {
                        if (uploader.data.prev_page_url != null) {
                            $('[name="show-selected"]').prop(
                                "checked",
                                false
                            );
                            uploader.getAllUploads(
                                uploader.data.prev_page_url
                            );
                        }
                    });

                    $(".uploader-search i").on("click", function () {
                        $(this).parent().toggleClass("open");
                    });

                    $('[data-toggle="uploaderAddSelected"]').on(
                        "click",
                        function () {
                            if (from === "input") {
                                uploader.inputSelectPreviewGenerate(elem);
                            } else if (from === "direct") {
                                callback(uploader.data.selectedFiles);
                            }
                            $("#uploaderModal").modal("hide");
                        }
                    );
                }
            );
            // }, 50);
        },
        initForInput: function () {
            $(document).on("click",'[data-toggle="uploader"]', function (e) {
                if (e.detail === 1) {
                    var elem = $(this);
                    var multiple = elem.data("multiple");
                    var type = elem.data("type");
                    var oldSelectedFiles = elem.find(".selected-files").val();

                    multiple = !multiple ? "" : multiple;
                    type = !type ? "" : type;
                    oldSelectedFiles = !oldSelectedFiles
                        ? ""
                        : oldSelectedFiles;

                    uploader.trigger(
                        this,
                        "input",
                        type,
                        oldSelectedFiles,
                        multiple
                    );
                }
            });
        },
        previewGenerate: function(){
            $('[data-toggle="uploader"]').each(function () {
                var $this = $(this);
                var files = $this.find(".selected-files").val();
                if(files != ""){
                    $.post(
                        data.appUrl + "/uploader/get_file_by_ids",
                        { _token: data.csrf, ids: files },
                        function (data) {
                            $this.next(".file-preview").html(null);

                            if (data.length > 0) {
                                $this.find(".file-amount").html(
                                    uploader.updateFileHtml(data)
                                );
                                for (
                                    var i = 0;
                                    i < data.length;
                                    i++
                                ) {
                                    var thumb = "";
                                    if (data[i].type === "image") {
                                        thumb =
                                            '<img src="' +
                                            fileBaseUrl+data[i].file_name +
                                            '" class="img-fit">';
                                    } else {
                                        thumb = '<i class="fa fa-file"></i>';
                                    }
                                    var html =
                                        '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                        data[i].id +
                                        '" title="' +
                                        data[i].file_original_name +
                                        "." +
                                        data[i].extension +
                                        '">' +
                                        '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                        thumb +
                                        "</div>" +
                                        '<div class="col body">' +
                                        '<h6 class="d-flex">' +
                                        '<span class="text-truncate title">' +
                                        data[i].file_original_name +
                                        "</span>" +
                                        '<span class="ext flex-shrink-0">.' +
                                        data[i].extension +
                                        "</span>" +
                                        "</h6>" +
                                        "<p>" +
                                        uploader.plugins.bytesToSize(
                                            data[i].file_size
                                        ) +
                                        "</p>" +
                                        "</div>" +
                                        '<div class="remove">' +
                                        '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                        '<i class="fa fa-close"></i>' +
                                        "</button>" +
                                        "</div>" +
                                        "</div>";

                                    $this.next(".file-preview").append(html);
                                }
                            } else {
                                $this.find(".file-amount").html(local.choose_file);
                            }
                    });
                }
            });
        }
    };



    setInterval(function(){
        extra.refreshToken();
    }, 3600000);

    uploader.initForInput();
    uploader.removeAttachment();
    uploader.previewGenerate();
})(jQuery);
