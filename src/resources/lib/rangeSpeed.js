jQuery(document).ready(function () {
   jQuery("#sliderSpeed").change(function () {
       jQuery("label[for='sliderSpeed']").html("Speed (" + jQuery("#sliderSpeed").val() + " ms)")
   })
});