jQuery(document).ready(function(e){
    jQuery(".formslide").on('submit', function(e){
        e.preventDefault();
        var data = new FormData(this);
        jQuery.ajax({
            method: 'POST',
            url : setting_apiUrl + '/controllers/UploadController.php',
            //url: setting_apiUrl + '/?page=updateslide',
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(msg, success){
                jQuery("#bgcontainer" + data.get('id')).css("background-size", data.get("bgsize"));
                if(msg != '') jQuery("#bgcontainer" + data.get('id')).css("background-image", "url('../../resources/upload/" + jQuery("#sliderHeader").attr("data-slider") + "/images/" + msg + "')");
                else jQuery("#bgcontainer" + data.get('id')).css("background-image", "none");
                jQuery("#bgcontainer" + data.get('id')).css("background-color", data.get('bgcolor'));
            },
            error: function(msg, e) {
                alert("Something went wrong :( Please contact with administrator!")
            }
        });
    });

    //file type validation
    jQuery("input[type=file]").change(function() {
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
            alert('Please select a valid image file (JPEG/JPG/PNG).');
            jQuery(this).val('');
            return false;
        }
        if (file.size > 5000000) {
            alert('Please select a valid image file (max 5MB).');
            jQuery(this).val('');
            return false;
        }
    });
});