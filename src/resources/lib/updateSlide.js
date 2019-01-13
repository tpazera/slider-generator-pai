function saveSlideDB(id) {
    //VALIDATE INPUTS
    var formData = new FormData();
    formData.append('file', jQuery('#background' + id)[0].files[0]);
    formData.append('id', id);
    formData.append('color', jQuery("#bgcolor" + id).val());
    formData.append('bgsize', jQuery("input[name='bgsize" + id + "']:checked").val());

    jQuery.ajax({
        url : setting_apiUrl + '/?page=uploadslide',
        method : 'POST',
        data : formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        dataType: 'json',
        success : function(data, success) {
            console.log(success);
            alert(data);
        }
    });
}
