jQuery(document).ready(function () {
    jQuery('.summernote').summernote({
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["fontname", ["fontname"]],
            ["color", ["color"]],
            ["para", ["ul", "ol"]],
            //["table", ["table"]],
            //["insert", ["link", "picture", "video"]],
            //["view", ["fullscreen", "codeview", "help"]]
        ],
        disableResizeEditor: true,
        height: 200
    });
});