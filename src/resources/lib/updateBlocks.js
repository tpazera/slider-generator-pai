jQuery(document).ready(function () {
    jQuery("ol li:nth-child(1) .badge-primary").addClass("disabled");
    jQuery("ol li:nth-last-child(1) .badge-secondary").addClass("disabled");

    //UPDATE TEXT POSITION
    jQuery(".textcontainer").draggable({
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

    //UPDATE BLOCK POSITION
    jQuery(".blockcontainer").draggable({
        cursor: "move",
        stop: function() {
            var x = jQuery(this).css("left");
            var y = jQuery(this).css("top");
            var id = jQuery(this).attr("data-el");
            jQuery.ajax({
                url : setting_apiUrl + '/?page=updateblockpos',
                method : "POST",
                data : {
                    id_block: id,
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

    //EDITOR FOR TEXT
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

        jQuery( ".textcontainer" ).each(function( index ) {
            var id = jQuery(this).attr("data-el");
            var dialog = jQuery( "#dialogText" + id ).dialog({
                autoOpen: false,
                height: 400,
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

    //EDITOR FOR BLOCK
    jQuery( function() {
        //FROM https://jqueryui.com/dialog/#modal-form
        var dialog;

        function updateTips( t ) {
            jQuery(".dialogBlock" + id + " .validateTips")
                .html( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                jQuery(".dialogBlock" + id + " .validateTips").removeClass( "ui-state-highlight", 500 );
            }, 500 );
        }

        function updateBlockDB(id, dialog) {
            var valid = true;
            jQuery("#text"+ id + ",  #zindexBlock" + id).removeClass( "ui-state-error" );

            if(jQuery("#height"+ id).val() < 100 || jQuery("#height"+ id).val() > 1000) {
                valid = false;
                jQuery("#height"+ id).addClass( "ui-state-error" );
                updateTips("Block's height must be from 5px to 5000px!");
            }
            if(jQuery("#width"+ id).val() < 5 || jQuery("#width"+ id).val() > 5000) {
                valid = false;
                jQuery("#width"+ id).addClass( "ui-state-error" );
                updateTips("Block's width must be from 5px to 5000px!");
            }
            if(isNaN(jQuery("#zindexBlock"+ id).val())) {
                valid = false;
                jQuery("#zindexBlock"+ id).addClass( "ui-state-error" );
                updateTips("Wage must be a number!");
            }

            if ( valid ) {
                var height = jQuery("#height"+ id).val();
                var width = jQuery("#width"+ id).val();
                var zindex = jQuery("#zindexBlock"+ id).val();
                jQuery.ajax({
                    url : setting_apiUrl + '/?page=updateblock',
                    method : "POST",
                    data : {
                        id_block: id,
                        height: height,
                        width: width,
                        zindex: zindex
                    },
                    success: function() {
                        console.log("Block updated!");
                        jQuery("#blockcontainer"+ id).css("height", height);
                        jQuery("#blockcontainer"+ id).css("width", width);
                        jQuery("#blockcontainer"+ id).css("z-index", zindex);
                        dialog.dialog( "close" );

                    },
                    error: function() {
                        updateTips("Something went wrong! Please contact with admin.");
                    }
                });
            }

            return valid;
        }

        jQuery( ".blockcontainer" ).each(function( index ) {
            var id = jQuery(this).attr("data-el");
            var dialog = jQuery( "#dialogBlock" + id ).dialog({
                autoOpen: false,
                height: 400,
                width: 350,
                modal: true,
                buttons: {
                    "Save in database":  function() {
                        updateBlockDB(id, dialog);
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
                updateBlockDB(id);
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

function addBlock(id) {
    var bgcontainer = jQuery("#bgcontainer"+id+" .element");
    if(bgcontainer.length <= 10) {
        console.log("Adding block!");
        var color = "#" + Math.floor(Math.random()*16777215).toString(16);
        var positions = [5, 20, 30, 40, 50, 60, 70, 80, 90];
        var pos = positions[Math.floor(Math.random()*positions.length)];
        var zindex = getMaxZindex(bgcontainer) + 1;
        jQuery.ajax({
            url : setting_apiUrl + '/?page=addblock',
            method : "POST",
            data : {
                id_slide: id,
                color: color,
                pos: pos,
                zindex: zindex
            },
            success: function (data, textStatus, status) {
                console.log(JSON.parse(data)[0]);
                console.log(textStatus);
                console.log(status);
                jQuery("ol li .badge-secondary").removeClass("disabled");
                jQuery("#bgcontainer"+id).append('<div id="blockcontainer' + JSON.parse(data)[0] + '" class="blockcontainer element" style="position: absolute; left: ' + pos + 'px; top: ' + pos + 'px; z-index: ' + zindex + '; width: 100px; height: 100px; background-color: ' + color + ';"></div>')
                jQuery("#blockcontainer" + JSON.parse(data)[0]).draggable({
                    cursor: "move",
                    stop: function() {
                        var x = jQuery(this).css("left");
                        var y = jQuery(this).css("top");
                        var id = jQuery(this).attr("data-el");
                        jQuery.ajax({
                            url : setting_apiUrl + '/?page=updateblockpos',
                            method : "POST",
                            data : {
                                id_block: id,
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
                    var id = JSON.parse(data)[0];
                    var dialog;

                    function updateTips( t ) {
                        jQuery(".dialogBlock" + id + " .validateTips")
                            .html( t )
                            .addClass( "ui-state-highlight" );
                        setTimeout(function() {
                            jQuery(".dialogBlock" + id + " .validateTips").removeClass( "ui-state-highlight", 500 );
                        }, 500 );
                    }

                    function updateBlockDB(id, dialog) {
                        var valid = true;
                        jQuery("#text"+ id + ",  #zindexBlock" + id).removeClass( "ui-state-error" );

                        if(jQuery("#height"+ id).val() < 100 || jQuery("#height"+ id).val() > 1000) {
                            valid = false;
                            jQuery("#height"+ id).addClass( "ui-state-error" );
                            updateTips("Block's height must be from 5px to 5000px!");
                        }
                        if(jQuery("#width"+ id).val() < 5 || jQuery("#width"+ id).val() > 5000) {
                            valid = false;
                            jQuery("#width"+ id).addClass( "ui-state-error" );
                            updateTips("Block's width must be from 5px to 5000px!");
                        }
                        if(isNaN(jQuery("#zindexBlock"+ id).val())) {
                            valid = false;
                            jQuery("#zindexBlock"+ id).addClass( "ui-state-error" );
                            updateTips("Wage must be a number!");
                        }

                        if ( valid ) {
                            var height = jQuery("#height"+ id).val();
                            var width = jQuery("#width"+ id).val();
                            var zindex = jQuery("#zindexBlock"+ id).val();
                            jQuery.ajax({
                                url : setting_apiUrl + '/?page=updateblock',
                                method : "POST",
                                data : {
                                    id_block: id,
                                    height: height,
                                    width: width,
                                    zindex: zindex
                                },
                                success: function() {
                                    console.log("Block updated!");
                                    jQuery("#blockcontainer"+ id).css("height", height);
                                    jQuery("#blockcontainer"+ id).css("width", width);
                                    jQuery("#blockcontainer"+ id).css("z-index", zindex);
                                    dialog.dialog( "close" );

                                },
                                error: function() {
                                    updateTips("Something went wrong! Please contact with admin.");
                                }
                            });
                        }

                        return valid;
                    }

                    var dialog = jQuery( "#dialogBlock" + id ).dialog({
                        autoOpen: false,
                        height: 400,
                        width: 350,
                        modal: true,
                        buttons: {
                            "Save in database":  function() {
                                updateBlockDB(id, dialog);
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
                        updateBlockDB(id);
                    });

                    jQuery( "#dialogBlock" + id ).on( "click", function() {
                        dialog.dialog( "open" );
                        console.log(id);
                    });

                } );
                jQuery("#elements"+id).append('' +
                    '<li class="element' + JSON.parse(data)[0] + ' Block ?> list-group-item d-flex justify-content-between align-items-center">' +
                    '   Block #' + JSON.parse(data)[0] +
                    '   <div class="badges">' +
                    '       <span class="badge badge-danger badge-pill">DELETE</span>' +
                    '   </div>' +
                    '</li>');
            },
            error: function(xhr, textStatus, error) {
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
                jQuery("#bgcontainer"+id).append('<div id="textcontainer' + JSON.parse(data)[0] + ' " class="textcontainer element" style="position: absolute; left: ' + pos + 'px; top: ' + pos + 'px; z-index: ' + zindex + '"><p>Hello world</p></div></div>');
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
                        height: 400,
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
