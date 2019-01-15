jQuery(document).ready(function () {
    jQuery("input[type=radio]").change(function () {
        jQuery.ajax({
            url : setting_apiUrl + '/?page=changerole',
            method : "POST",
            data : {
                id_user: jQuery(this).parent().parent().attr("data-user"),
                id_role: jQuery(this).val()
            },
            success: function(msg) {
                console.log("Role changed!" + msg);
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
});