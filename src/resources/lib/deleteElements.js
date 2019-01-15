jQuery(document).ready(function () {
    jQuery(".elements-list > .Text > div > span").on("click", function () {
        var label = jQuery(this);
        console.log("Deleting " + jQuery(this).attr("data-element") + " of " + jQuery(this).attr("data-slide"));
        jQuery.ajax({
            url : setting_apiUrl + '/?page=deletetext',
            method : "POST",
            data : {
                id_text: label.attr("data-element"),
                id_slide: label.attr("data-slide")
            },
            success: function() {
                console.log("Text deleted!");
                label.parent().parent().remove();
                jQuery("#bgcontainer" + label.attr("data-slide") + " #textcontainer" + label.attr("data-element")).remove();

            },
            error: function() {}
        });
    });

    jQuery(".elements-list > .Block > div > span").on("click", function () {
        var label = jQuery(this);
        console.log("Deleting " + jQuery(this).attr("data-element") + " of " + jQuery(this).attr("data-slide"));
        jQuery.ajax({
            url : setting_apiUrl + '/?page=deleteblock',
            method : "POST",
            data : {
                id_block: label.attr("data-element"),
                id_slide: label.attr("data-slide")
            },
            success: function() {
                console.log("Block deleted!");
                label.parent().parent().remove();
                jQuery("#bgcontainer" + label.attr("data-slide") + " #blockcontainer" + label.attr("data-element")).remove();

            },
            error: function() {}
        });
    });
});