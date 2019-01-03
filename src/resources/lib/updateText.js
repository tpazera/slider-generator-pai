jQuery(document).ready(function () {
    jQuery("ol li:nth-child(1) .badge-primary").addClass("disabled");
    jQuery("ol li:nth-last-child(1) .badge-secondary").addClass("disabled");

    //UPDATE TEXT POSITION
    jQuery(".textcontainer").draggable({
        cursor: "move",
        stop: function() {
            var x = jQuery(this).css("left");
            var y = jQuery(this).css("top");
            var l = ( 100 * parseFloat(jQuery(this).position().left / parseFloat($(this).parent().width())) );
            var t = ( 100 * parseFloat(jQuery(this).position().top / parseFloat($(this).parent().height())) );
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

    //EDITOR FOR TEXT
    jQuery( function() {
        //FROM https://jqueryui.com/dialog/#modal-form
        function updateTips( t, id ) {
            jQuery(".dialogText" + id + " .validateTips")
                .html( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                jQuery(".dialogText" + id + " .validateTips").removeClass( "ui-state-highlight", 500 );
            }, 500 );
        }

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
    } );

});

function getMaxZindex(selector){
    return Math.max.apply(null, $(selector).map(function(){
        var z;
        return isNaN(z = parseInt($(this).css("z-index"), 10)) ? 0 : z;
    }));
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
                jQuery("ol li .badge-secondary").removeClass("disabled");
                jQuery("#bgcontainer"+id).append('<div id="textcontainer' + JSON.parse(data)[0] + ' " class="textcontainer element" style="position: absolute; left: ' + pos + '%; top: ' + pos + '%; z-index: ' + zindex + '"><p>Hello world</p></div></div>');
                jQuery("#textcontainer" + JSON.parse(data)[0]).draggable({
                    cursor: "move",
                    stop: function() {
                        var x = jQuery(this).css("left");
                        var y = jQuery(this).css("top");
                        var id = jQuery(this).attr("data-el");
                        jQuery.ajax({
                            url : setting_apiUrl + '/?page=updatetextpos',
                            method : "POST",
                            data : {
                                id_text: id,
                                x: x,
                                y: y
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
                jQuery( function() {
                    //FROM https://jqueryui.com/dialog/#modal-form
                    function updateTips( t ) {
                        jQuery(".dialogText" + id + " .validateTips")
                            .html( t )
                            .addClass( "ui-state-highlight" );
                        setTimeout(function() {
                            jQuery(".dialogText" + id + " .validateTips").removeClass( "ui-state-highlight", 500 );
                        }, 500 );
                    }

                    function updateTextDB(id, dialog) {
                        var valid = true;
                        jQuery("#text"+ id + ",  #zindexText" + id).removeClass( "ui-state-error" );

                        if(jQuery("#text"+ id).val().includes("<script>")) {
                            valid = false;
                            jQuery("#text"+ id).addClass( "ui-state-error" );
                            updateTips("Do not try to put scripts!");
                        }
                        if(isNaN(jQuery("#zindexText"+ id).val())) {
                            valid = false;
                            jQuery("#zindex"+ id).addClass( "ui-state-error" );
                            updateTips("Wage must be a number!");
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
                                    updateTips("Something went wrong! Please contact with admin.");
                                }
                            });
                        }

                        return valid;
                    }

                    var id = JSON.parse(data)[0];
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

                    jQuery( "#dialogText" + id ).on( "click", function() {
                        dialog.dialog( "open" );
                        console.log(id);
                    });
                });

                jQuery("#elements"+id).append('' +
                    '<li class="element' + JSON.parse(data)[0] + ' Text ?> list-group-item d-flex justify-content-between align-items-center">' +
                    '   Text #' + JSON.parse(data)[0] +
                    '   <div class="badges">' +
                    '       <span class="badge badge-danger badge-pill">DELETE</span>' +
                    '   </div>' +
                    '</li>');
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
