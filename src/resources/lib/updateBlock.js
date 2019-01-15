jQuery(document).ready(function () {
    //UPDATE BLOCK POSITION
    jQuery(".blockcontainer").draggable({
        cursor: "move",
        stop: function() {
            var x = jQuery(this).css("left");
            var y = jQuery(this).css("top");
            var l = ( 100 * parseFloat(jQuery(this).position().left / parseFloat($(this).parent().width())) );
            var t = ( 100 * parseFloat(jQuery(this).position().top / parseFloat($(this).parent().height())) );
            var id = jQuery(this).attr("data-el");
            jQuery.ajax({
                url : setting_apiUrl + '/?page=updateblockpos',
                method : "POST",
                data : {
                    id_block: id,
                    x: l,
                    y: t
                },
                success: function(msg) {
                    if (msg == "cheater") alert("Do not try to cheat!");
                    else console.log("Position of text updated!");
                    console.log("Position of block updated!");

                },
                error: function() {
                    console.log("Something went wrong! Please contact with admin.");
                }
            });
        }
    });


    jQuery( ".blockcontainer" ).each(function( index ) {
        var id = jQuery(this).attr("data-el");
        var dialog = jQuery( "#dialogBlock" + id ).dialog({
            autoOpen: false,
            height: 500,
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

});

function updateTips( t, id ) {
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

    if(jQuery("#height"+ id).val() < 1 || jQuery("#height"+ id).val() > 100) {
        valid = false;
        jQuery("#height"+ id).addClass( "ui-state-error" );
        updateTips("Block's height must be from 1% to 100%!", id);
    }
    if(jQuery("#width"+ id).val() < 1 || jQuery("#width"+ id).val() > 100) {
        valid = false;
        jQuery("#width"+ id).addClass( "ui-state-error" );
        updateTips("Block's width must be from 1% to 100%!", id);
    }
    if(isNaN(jQuery("#zindexBlock"+ id).val())) {
        valid = false;
        jQuery("#zindexBlock"+ id).addClass( "ui-state-error" );
        updateTips("Wage must be a number!", id);
    }
    var colorpattern = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
    console.log(id);
    console.log(jQuery("#color"+ id).val().toString());
    console.log(colorpattern.test(jQuery("#color"+ id).val().toString()));

    if(!colorpattern.test(jQuery("#color"+ id).val().toString())) {
        valid = false;
        jQuery("#color"+ id).addClass( "ui-state-error" );
        updateTips("Must be a color!", id);
    }

    if ( valid ) {
        var height = jQuery("#height"+ id).val();
        var width = jQuery("#width"+ id).val();
        var zindex = jQuery("#zindexBlock"+ id).val();
        var color = jQuery("#color" + id).val();
        jQuery.ajax({
            url : setting_apiUrl + '/?page=updateblock',
            method : "POST",
            data : {
                id_block: id,
                height: height,
                width: width,
                zindex: zindex,
                color: color
            },
            success: function() {
                console.log("Block updated!");
                jQuery("#blockcontainer"+ id).css("height", height + "%");
                jQuery("#blockcontainer"+ id).css("width", width + "%");
                jQuery("#blockcontainer"+ id).css("z-index", zindex);
                jQuery("#blockcontainer"+ id).css("background-color", color);
                dialog.dialog( "close" );

            },
            error: function() {
                updateTips("Something went wrong! Please contact with admin.", id);
            }
        });
    }

    return valid;
}

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
                jQuery("#bgcontainer"+id).append('<div id="blockcontainer' + JSON.parse(data)[0] + '" class="blockcontainer element" style="position: absolute; left: ' + pos + '%; top: ' + pos + '%; z-index: ' + zindex + '; width: 10%; height: 10%; background-color: ' + color + ';"></div>')
                jQuery("#blockcontainer" + JSON.parse(data)[0]).draggable({
                    cursor: "move",
                    stop: function() {
                        var x = jQuery(this).css("left");
                        var y = jQuery(this).css("top");
                        var l = ( 100 * parseFloat(jQuery(this).position().left / parseFloat(jQuery(this).parent().width())) );
                        var t = ( 100 * parseFloat(jQuery(this).position().top / parseFloat(jQuery(this).parent().height())) );
                        var id = jQuery(this).attr("data-el");
                        jQuery.ajax({
                            url : setting_apiUrl + '/?page=updateblockpos',
                            method : "POST",
                            data : {
                                id_block: JSON.parse(data)[0],
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
                var dialog = jQuery('<div class="dialogBlock' + JSON.parse(data)[0] + 'dialog" id="dialogBlock' + JSON.parse(data)[0] + '" title="Block #' + JSON.parse(data)[0] + '">' +
                    '                        <p class="validateTips">Edit settings of this block!</p>' +
                    '                        <form class="dialogForm" id="dialogForm' + JSON.parse(data)[0] + '">' +
                    '                            <fieldset>\n' +
                    '                                <label for="height">Height</label><br>' +
                    '                                <input type="number" name="height" id="height' + JSON.parse(data)[0] + '" value="10" class="form-control text ui-widget-content ui-corner-all"><br>\n' +
                    '                                <label for="width">Width</label><br>' +
                    '                                <input type="number" name="width" id="width' + JSON.parse(data)[0] + '" value="10" class="form-control text ui-widget-content ui-corner-all"><br>\n' +
                    '                                <label for="zindex">Wage (z-index)</label><br>\n' +
                    '                                <input type="number" min=0 name="zindex" id="zindexBlock' + JSON.parse(data)[0] + '" value="' + zindex + '" class="form-control text ui-widget-content ui-corner-all"><br>\n' +
                    '                                <label for="color">Color</label><br>\n' +
                    '                                <input type="color" min=0 name="color" id="color' + JSON.parse(data)[0] + '" value="' + color + '" class="form-control text ui-widget-content ui-corner-all">\n' +
                    '                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">\n' +
                    '                            </fieldset>\n' +
                    '                        </form>\n' +
                    '                    </div>').dialog({
                                                    autoOpen: false,
                                                    height: 500,
                                                    width: 350,
                                                    modal: true,
                                                    buttons: {
                                                        "Save in database":  function() {
                                                            updateBlockDB(JSON.parse(data)[0], jQuery(this));
                                                        },
                                                        Cancel: function() {
                                                            jQuery(this).dialog( "close" );
                                                        }
                                                    },
                                                    close: function() {
                                                        jQuery(".validateTips").removeClass( "ui-state-error" );
                                                    }
                                                });
                jQuery( "#blockcontainer" + JSON.parse(data)[0]).on( "click", function() {
                    dialog.dialog( "open" );
                    console.log(id);
                });

                jQuery("#elements"+id).append('' +
                    '<li class="element' + JSON.parse(data)[0] + ' Block ?> list-group-item d-flex justify-content-between align-items-center">' +
                    '   Block #' + JSON.parse(data)[0] +
                    '   <div class="badges">' +
                    '       <span class="badge badge-danger badge-pill">DELETE</span>' +
                    '   </div>' +
                    '</li>');
                jQuery(".element" + JSON.parse(data)[0] + " > div > span").on("click", function () {
                    var label = jQuery(this);
                    console.log("Deleting " + JSON.parse(data)[0] + " of " + id);
                    jQuery.ajax({
                        url : setting_apiUrl + '/?page=deleteblock',
                        method : "POST",
                        data : {
                            id_block: JSON.parse(data)[0],
                            id_slide: id
                        },
                        success: function() {
                            console.log("Block deleted!");
                            label.parent().parent().remove();
                            jQuery("#bgcontainer" + id + " #blockcontainer" + JSON.parse(data)[0]).remove();

                        },
                        error: function() {}
                    });
                });
            },
            error: function(xhr, textStatus, error) {
                if(JSON.parse(xhr.responseText)[0] == "cheater") {
                    alert("Do not try to cheat!");
                }
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        });
    } else {
        jQuery("#addBlock"+id).addClass("disabled");
        alert("You can only add 10 elements to one slide!")
    }

}
