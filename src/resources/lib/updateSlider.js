jQuery(document).ready(function () {
    jQuery("#saveSlider").click(function () {
        console.log("Updating slider...");
        updateSliderDB();
    });

    jQuery("#sliderName, #sliderSpeed, #sliderHeight").change(function () {
        jQuery("#saveSlider").removeClass("btn-success").addClass("btn-danger");
        //jQuery("#saveSlider").addClass("btn-error");
    });
});

function updateSliderDB() {
    //VALIDATE INPUTS
    var height = jQuery("#sliderHeight").val();
    var speed = jQuery("#sliderSpeed").val();
    var name = jQuery("#sliderName").val();
    jQuery(".errors").empty();
    if(height < 100 || height > 1000) {
        jQuery(".errors").append("<h5 class='error'>Wrong height, 100px-1000px</h5>");
        return;
    }
    if((/[^A-Z a-z0-9]/.test(name))) {
        jQuery(".errors").append("<h5 class='error'>Wrong name, only letters, spaces nad numbers</h5>");
        return;
    }
    if(speed > 20000 || speed < 500) {
        jQuery(".errors").append("<h5 class='error'>Wrong speed, 500ms-20000ms</h5>");
        return;
    }
    jQuery.ajax({
        url : setting_apiUrl + '/?page=updateslider',
        method : "POST",
        data : {
            height: height,
            speed: speed,
            name: name
        },
        success: function() {
            console.log("Slider updated!");
            jQuery("#sliderHeader").html(jQuery("#sliderName").val());
            jQuery(".bgcontainer").css("height", height+"px");
            jQuery("#saveSlider").removeClass("btn-danger").addClass("btn-success");

        },
        error: function() {
            console.log("Error! Slider not updated!");
        }
    });
}
