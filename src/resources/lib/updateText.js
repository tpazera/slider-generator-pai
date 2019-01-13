jQuery(document).ready(function () {
    //UPDATE TEXT POSITION
    jQuery(".textcontainer").draggable({
        cursor: "move",
        stop: function() {
            var x = jQuery(this).css("left");
            var y = jQuery(this).css("top");
            var l = ( 100 * parseFloat(jQuery(this).position().left / parseFloat(jQuery(this).parent().width())) );
            var t = ( 100 * parseFloat(jQuery(this).position().top / parseFloat(jQuery(this).parent().height())) );
            var id = jQuery(this).attr("data-el");
            jQuery.ajax({
                url : setting_apiUrl + '/?page=updatetextpos',
                method : "POST",
                data : {
                    id_text: id,
                    x: l,
                    y: t
                },
                success: function() {
                    console.log("Position of block updated!");

                },
                error: function() {
                    console.log("Something went wrong! Please contact with admin.");
                }
            });
        }
    });

    jQuery( ".textcontainer" ).each(function( index ) {
        var id = jQuery(this).attr("data-el");
        var dialog = jQuery( "#dialogText" + id ).dialog({
            autoOpen: false,
            height: 500,
            width: 350,
            modal: true,
            buttons: {
                "Save in database": function() {
                    updateTextDB(id, dialog);
                },
                Cancel: function() {
                    dialog.dialog( "close" );
                }
            },
            close: function() {
                jQuery(".validateTips").removeClass( "ui-state-error" );
            }
        });

        dialog.dialog("close");

        dialog.css("display", "block");

        dialog.find( "form.dialogForm" ).on( "submit", function( event ) {
            event.preventDefault();
            updateTextDB(id);
        });

        jQuery( this ).on( "click", function() {
            dialog.dialog( "open" );
            console.log(id);
        });
    });

});

function updateTextDB(id, dialog) {
    var valid = true;
    jQuery("#text"+ id + ",  #zindexText" + id).removeClass( "ui-state-error" );

    if(jQuery("#text"+ id).val().includes("<script>")) {
        valid = false;
        jQuery("#text"+ id).addClass( "ui-state-error" );
        updateTips("Do not try to put scripts!", id);
    }
    if(isNaN(jQuery("#zindexText"+ id).val())) {
        valid = false;
        jQuery("#zindex"+ id).addClass( "ui-state-error" );
        updateTips("Wage must be a number!", id);
    }

    if ( valid ) {
        var text = jQuery("#text"+ id).val();
        var zindex = jQuery("#zindexText"+ id).val();
        jQuery.ajax({
            url : setting_apiUrl + '/?page=updatetext',
            method : "POST",
            data : {
                id_text: id,
                text: text,
                zindex: zindex
            },
            success: function() {
                console.log("Text updated!");
                jQuery("#textcontainer"+ id).html(text);
                jQuery("#textcontainer"+ id).css("z-index", zindex);
                dialog.dialog( "close" );

            },
            error: function() {
                updateTips("Something went wrong! Please contact with admin.", id);
            }
        });
    }

    return valid;
}

function addText(id) {
    var bgcontainer = jQuery("#bgcontainer"+id+" .element");
    if(bgcontainer.length <= 10) {
        console.log("Adding text!");
        var positions = [5, 20, 30, 40, 50, 60, 70, 80, 90];
        var pos = positions[Math.floor(Math.random() * positions.length)];
        var zindex = getMaxZindex(bgcontainer) + 1;
        jQuery.ajax({
            url: setting_apiUrl + '/?page=addtext',
            method: "POST",
            data: {
                id_slide: id,
                pos: pos,
                zindex: zindex
            },
            success: function (data, textStatus, status) {
                console.log(JSON.parse(data)[0]);
                console.log(textStatus);
                console.log(status);
                jQuery("#bgcontainer"+id).append('<div id="textcontainer' + JSON.parse(data)[0] + '" class="textcontainer element" style="position: absolute; left: ' + pos + '%; top: ' + pos + '%; z-index: ' + zindex + '"><p>Hello world</p></div></div>');
                jQuery("#textcontainer" + JSON.parse(data)[0]).draggable({
                    cursor: "move",
                    stop: function() {
                        var x = jQuery(this).css("left");
                        var y = jQuery(this).css("top");
                        var l = ( 100 * parseFloat(jQuery(this).position().left / parseFloat(jQuery(this).parent().width())) );
                        var t = ( 100 * parseFloat(jQuery(this).position().top / parseFloat(jQuery(this).parent().height())) );
                        var id = jQuery(this).attr("data-el");
                        jQuery.ajax({
                            url : setting_apiUrl + '/?page=updatetextpos',
                            method : "POST",
                            data : {
                                id_text: JSON.parse(data)[0],
                                x: l,
                                y: t
                            },
                            success: function() {
                                console.log("Position of block updated!");

                            },
                            error: function() {
                                console.log("Something went wrong! Please contact with admin.");
                            }
                        });
                    }
                });
                var dialog = jQuery('<div class="dialogText' + JSON.parse(data)[0] + ' dialog" id="dialogText' + JSON.parse(data)[0] + '" title="Text #' + JSON.parse(data)[0] + '">' +
                    '                        <p class="validateTips">Edit settings of this block!</p>' +
                    '                        <form class="dialogForm" id="dialogForm' + JSON.parse(data)[0] + '">' +
                    '                            <fieldset>' +
                    '                                <label for="text">Text</label><br>' +
                    '                                <textarea type="text" name="text" id="text' + JSON.parse(data)[0] + '" value="' + 'Hello world' + '" class="form-control text ui-widget-content ui-corner-all vresize" ></textarea>' +
                    '                                <label for="zindex">Wage (z-index)</label><br>' +
                    '                                <input type="number" min=0 name="zindex" id="zindexText' + JSON.parse(data)[0] + '" value="' + zindex + '" class="form-control text ui-widget-content ui-corner-all">' +
                    '                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">' +
                    '                            </fieldset>' +
                    '                        </form>' +
                    '                    </div>').dialog({
                                            autoOpen: false,
                                            height: 500,
                                            width: 350,
                                            modal: true,
                                            buttons: {
                                                "Save in database":  function() {
                                                    updateTextDB(JSON.parse(data)[0], jQuery(this));
                                                },
                                                Cancel: function() {
                                                    jQuery(this).dialog( "close" );
                                                }
                                            },
                                            close: function() {
                                                jQuery(".validateTips").removeClass( "ui-state-error" );
                                            }
                                        });
                jQuery( "#textcontainer" + JSON.parse(data)[0]).on( "click", function() {
                    dialog.dialog( "open" );
                    console.log(id);
                });

                jQuery("#elements"+id).append('' +
                    '<li class="element' + JSON.parse(data)[0] + ' Text ?> list-group-item d-flex justify-content-between align-items-center">' +
                    '   Text #' + JSON.parse(data)[0] +
                    '   <div class="badges">' +
                    '       <span class="badge badge-danger badge-pill">DELETE</span>' +
                    '   </div>' +
                    '</li>');
                jQuery(".element" + JSON.parse(data)[0] + " > div > span").on("click", function () {
                    var label = jQuery(this);
                    console.log("Deleting " + JSON.parse(data)[0] + " of " + id);
                    jQuery.ajax({
                        url : setting_apiUrl + '/?page=deletetext',
                        method : "POST",
                        data : {
                            id_text: JSON.parse(data)[0],
                            id_slide: id
                        },
                        success: function() {
                            console.log("Text deleted!");
                            label.parent().parent().remove();
                            jQuery("#bgcontainer" + id + " #textcontainer" + JSON.parse(data)[0]).remove();

                        },
                        error: function() {}
                    });
                });
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);

            }
        });
    } else {
        jQuery("#addText"+id).addClass("disabled");
        alert("You can only add 10 elements to one slide!")
    }
}

