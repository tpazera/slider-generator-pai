function updateTips(e,t){jQuery(".dialogBlock"+t+" .validateTips").html(e).addClass("ui-state-highlight"),setTimeout(function(){jQuery(".dialogBlock"+t+" .validateTips").removeClass("ui-state-highlight",500)},500)}function updateBlockDB(e,t){var o=!0;jQuery("#text"+e+",  #zindexBlock"+e).removeClass("ui-state-error"),(jQuery("#height"+e).val()<1||100<jQuery("#height"+e).val())&&(o=!1,jQuery("#height"+e).addClass("ui-state-error"),updateTips("Block's height must be from 1% to 100%!",e)),(jQuery("#width"+e).val()<1||100<jQuery("#width"+e).val())&&(o=!1,jQuery("#width"+e).addClass("ui-state-error"),updateTips("Block's width must be from 1% to 100%!",e)),isNaN(jQuery("#zindexBlock"+e).val())&&(o=!1,jQuery("#zindexBlock"+e).addClass("ui-state-error"),updateTips("Wage must be a number!",e));var a=/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;if(console.log(e),console.log(jQuery("#color"+e).val().toString()),console.log(a.test(jQuery("#color"+e).val().toString())),a.test(jQuery("#color"+e).val().toString())||(o=!1,jQuery("#color"+e).addClass("ui-state-error"),updateTips("Must be a color!",e)),o){var r=jQuery("#height"+e).val(),i=jQuery("#width"+e).val(),n=jQuery("#zindexBlock"+e).val(),l=jQuery("#color"+e).val();jQuery.ajax({url:setting_apiUrl+"/?page=updateblock",method:"POST",data:{id_block:e,height:r,width:i,zindex:n,color:l},success:function(){console.log("Block updated!"),jQuery("#blockcontainer"+e).css("height",r+"%"),jQuery("#blockcontainer"+e).css("width",i+"%"),jQuery("#blockcontainer"+e).css("z-index",n),jQuery("#blockcontainer"+e).css("background-color",l),t.dialog("close")},error:function(){updateTips("Something went wrong! Please contact with admin.",e)}})}return o}function getMaxZindex(e){return Math.max.apply(null,$(e).map(function(){var e;return isNaN(e=parseInt($(this).css("z-index"),10))?0:e}))}function addBlock(r){var e=jQuery("#bgcontainer"+r+" .element");if(e.length<=10){console.log("Adding block!");var i="#"+Math.floor(16777215*Math.random()).toString(16),t=[5,20,30,40,50,60,70,80,90],n=t[Math.floor(Math.random()*t.length)],l=getMaxZindex(e)+1;jQuery.ajax({url:setting_apiUrl+"/?page=addblock",method:"POST",data:{id_slide:r,color:i,pos:n,zindex:l},success:function(o,e,t){console.log(JSON.parse(o)[0]),console.log(e),console.log(t),jQuery("#bgcontainer"+r).append('<div id="blockcontainer'+JSON.parse(o)[0]+'" class="blockcontainer element" style="position: absolute; left: '+n+"%; top: "+n+"%; z-index: "+l+"; width: 10%; height: 10%; background-color: "+i+';"></div>'),jQuery("#blockcontainer"+JSON.parse(o)[0]).draggable({cursor:"move",stop:function(){jQuery(this).css("left"),jQuery(this).css("top");var e=100*parseFloat(jQuery(this).position().left/parseFloat(jQuery(this).parent().width())),t=100*parseFloat(jQuery(this).position().top/parseFloat(jQuery(this).parent().height()));jQuery(this).attr("data-el");jQuery.ajax({url:setting_apiUrl+"/?page=updateblockpos",method:"POST",data:{id_block:JSON.parse(o)[0],x:e,y:t},success:function(){console.log("Position of block updated!")},error:function(){console.log("Something went wrong! Please contact with admin.")}})}});var a=jQuery('<div class="dialogBlock'+JSON.parse(o)[0]+'dialog" id="dialogBlock'+JSON.parse(o)[0]+'" title="Block #'+JSON.parse(o)[0]+'">                        <p class="validateTips">Edit settings of this block!</p>                        <form class="dialogForm" id="dialogForm'+JSON.parse(o)[0]+'">                            <fieldset>\n                                <label for="height">Height</label><br>                                <input type="number" name="height" id="height'+JSON.parse(o)[0]+'" value="10" class="form-control text ui-widget-content ui-corner-all"><br>\n                                <label for="width">Width</label><br>                                <input type="number" name="width" id="width'+JSON.parse(o)[0]+'" value="10" class="form-control text ui-widget-content ui-corner-all"><br>\n                                <label for="zindex">Wage (z-index)</label><br>\n                                <input type="number" min=0 name="zindex" id="zindexBlock'+JSON.parse(o)[0]+'" value="'+l+'" class="form-control text ui-widget-content ui-corner-all"><br>\n                                <label for="color">Color</label><br>\n                                <input type="color" min=0 name="color" id="color'+JSON.parse(o)[0]+'" value="'+i+'" class="form-control text ui-widget-content ui-corner-all">\n                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">\n                            </fieldset>\n                        </form>\n                    </div>').dialog({autoOpen:!1,height:500,width:350,modal:!0,buttons:{"Save in database":function(){updateBlockDB(JSON.parse(o)[0],jQuery(this))},Cancel:function(){jQuery(this).dialog("close")}},close:function(){jQuery(".validateTips").removeClass("ui-state-error")}});jQuery("#blockcontainer"+JSON.parse(o)[0]).on("click",function(){a.dialog("open"),console.log(r)}),jQuery("#elements"+r).append('<li class="element'+JSON.parse(o)[0]+' Block ?> list-group-item d-flex justify-content-between align-items-center">   Block #'+JSON.parse(o)[0]+'   <div class="badges">       <span class="badge badge-danger badge-pill">DELETE</span>   </div></li>'),jQuery(".element"+JSON.parse(o)[0]+" > div > span").on("click",function(){var e=jQuery(this);console.log("Deleting "+JSON.parse(o)[0]+" of "+r),jQuery.ajax({url:setting_apiUrl+"/?page=deleteblock",method:"POST",data:{id_block:JSON.parse(o)[0],id_slide:r},success:function(){console.log("Block deleted!"),e.parent().parent().remove(),jQuery("#bgcontainer"+r+" #blockcontainer"+JSON.parse(o)[0]).remove()},error:function(){}})})},error:function(e,t,o){console.log(e.responseText),console.log(e.statusText),console.log(t),console.log(o)}})}else jQuery("#addBlock"+r).addClass("disabled"),alert("You can only add 10 elements to one slide!")}function saveSlideDB(e){var t=new FormData;t.append("file",jQuery("#background"+e)[0].files[0]),t.append("id",e),t.append("color",jQuery("#bgcolor"+e).val()),t.append("bgsize",jQuery("input[name='bgsize"+e+"']:checked").val()),jQuery.ajax({url:setting_apiUrl+"/?page=uploadslide",method:"POST",data:t,processData:!1,contentType:!1,dataType:"json",success:function(e,t){console.log(t),alert(e)}})}function updateSliderDB(){var e=jQuery("#sliderHeight").val(),t=jQuery("#sliderSpeed").val(),o=jQuery("#sliderName").val();jQuery(".errors").empty(),e<100||1e3<e?jQuery(".errors").append("<h5 class='error'>Wrong height, 100px-1000px</h5>"):/[^A-Z a-z0-9]/.test(o)?jQuery(".errors").append("<h5 class='error'>Wrong name, only letters, spaces nad numbers</h5>"):2e4<t||t<500?jQuery(".errors").append("<h5 class='error'>Wrong speed, 500ms-20000ms</h5>"):jQuery.ajax({url:setting_apiUrl+"/?page=updateslider",method:"POST",data:{height:e,speed:t,name:o},success:function(){console.log("Slider updated!"),jQuery("#sliderHeader").html(jQuery("#sliderName").val()),jQuery(".bgcontainer").css("height",e+"px"),jQuery("#saveSlider").removeClass("btn-danger").addClass("btn-success")},error:function(){console.log("Error! Slider not updated!")}})}function updateTextDB(e,t){var o=!0;if(jQuery("#text"+e+",  #zindexText"+e).removeClass("ui-state-error"),jQuery("#text"+e).val().includes("<script>")&&(o=!1,jQuery("#text"+e).addClass("ui-state-error"),updateTips("Do not try to put scripts!",e)),isNaN(jQuery("#zindexText"+e).val())&&(o=!1,jQuery("#zindex"+e).addClass("ui-state-error"),updateTips("Wage must be a number!",e)),o){var a=jQuery("#text"+e).val(),r=jQuery("#zindexText"+e).val();jQuery.ajax({url:setting_apiUrl+"/?page=updatetext",method:"POST",data:{id_text:e,text:a,zindex:r},success:function(){console.log("Text updated!"),jQuery("#textcontainer"+e).html(a),jQuery("#textcontainer"+e).css("z-index",r),t.dialog("close")},error:function(){updateTips("Something went wrong! Please contact with admin.",e)}})}return o}function addText(r){var e=jQuery("#bgcontainer"+r+" .element");if(e.length<=10){console.log("Adding text!");var t=[5,20,30,40,50,60,70,80,90],i=t[Math.floor(Math.random()*t.length)],n=getMaxZindex(e)+1;jQuery.ajax({url:setting_apiUrl+"/?page=addtext",method:"POST",data:{id_slide:r,pos:i,zindex:n},success:function(o,e,t){console.log(JSON.parse(o)[0]),console.log(e),console.log(t),jQuery("#bgcontainer"+r).append('<div id="textcontainer'+JSON.parse(o)[0]+'" class="textcontainer element" style="position: absolute; left: '+i+"%; top: "+i+"%; z-index: "+n+'"><p>Hello world</p></div></div>'),jQuery("#textcontainer"+JSON.parse(o)[0]).draggable({cursor:"move",stop:function(){jQuery(this).css("left"),jQuery(this).css("top");var e=100*parseFloat(jQuery(this).position().left/parseFloat(jQuery(this).parent().width())),t=100*parseFloat(jQuery(this).position().top/parseFloat(jQuery(this).parent().height()));jQuery(this).attr("data-el");jQuery.ajax({url:setting_apiUrl+"/?page=updatetextpos",method:"POST",data:{id_text:JSON.parse(o)[0],x:e,y:t},success:function(){console.log("Position of block updated!")},error:function(){console.log("Something went wrong! Please contact with admin.")}})}});var a=jQuery('<div class="dialogText'+JSON.parse(o)[0]+' dialog" id="dialogText'+JSON.parse(o)[0]+'" title="Text #'+JSON.parse(o)[0]+'">                        <p class="validateTips">Edit settings of this block!</p>                        <form class="dialogForm" id="dialogForm'+JSON.parse(o)[0]+'">                            <fieldset>                                <label for="text">Text</label><br>                                <textarea type="text" name="text" id="text'+JSON.parse(o)[0]+'" value="Hello world" class="form-control text ui-widget-content ui-corner-all vresize" ></textarea>                                <label for="zindex">Wage (z-index)</label><br>                                <input type="number" min=0 name="zindex" id="zindexText'+JSON.parse(o)[0]+'" value="'+n+'" class="form-control text ui-widget-content ui-corner-all">                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">                            </fieldset>                        </form>                    </div>').dialog({autoOpen:!1,height:500,width:350,modal:!0,buttons:{"Save in database":function(){updateTextDB(JSON.parse(o)[0],jQuery(this))},Cancel:function(){jQuery(this).dialog("close")}},close:function(){jQuery(".validateTips").removeClass("ui-state-error")}});jQuery("#textcontainer"+JSON.parse(o)[0]).on("click",function(){a.dialog("open"),console.log(r)}),jQuery("#elements"+r).append('<li class="element'+JSON.parse(o)[0]+' Text ?> list-group-item d-flex justify-content-between align-items-center">   Text #'+JSON.parse(o)[0]+'   <div class="badges">       <span class="badge badge-danger badge-pill">DELETE</span>   </div></li>'),jQuery(".element"+JSON.parse(o)[0]+" > div > span").on("click",function(){var e=jQuery(this);console.log("Deleting "+JSON.parse(o)[0]+" of "+r),jQuery.ajax({url:setting_apiUrl+"/?page=deletetext",method:"POST",data:{id_text:JSON.parse(o)[0],id_slide:r},success:function(){console.log("Text deleted!"),e.parent().parent().remove(),jQuery("#bgcontainer"+r+" #textcontainer"+JSON.parse(o)[0]).remove()},error:function(){}})})},error:function(e,t,o){console.log(e.responseText),console.log(e.statusText),console.log(t),console.log(o)}})}else jQuery("#addText"+r).addClass("disabled"),alert("You can only add 10 elements to one slide!")}jQuery(document).ready(function(){jQuery(".elements-list > .Text > div > span").on("click",function(){var e=jQuery(this);console.log("Deleting "+jQuery(this).attr("data-element")+" of "+jQuery(this).attr("data-slide")),jQuery.ajax({url:setting_apiUrl+"/?page=deletetext",method:"POST",data:{id_text:e.attr("data-element"),id_slide:e.attr("data-slide")},success:function(){console.log("Text deleted!"),e.parent().parent().remove(),jQuery("#bgcontainer"+e.attr("data-slide")+" #textcontainer"+e.attr("data-element")).remove()},error:function(){}})}),jQuery(".elements-list > .Block > div > span").on("click",function(){var e=jQuery(this);console.log("Deleting "+jQuery(this).attr("data-element")+" of "+jQuery(this).attr("data-slide")),jQuery.ajax({url:setting_apiUrl+"/?page=deleteblock",method:"POST",data:{id_block:e.attr("data-element"),id_slide:e.attr("data-slide")},success:function(){console.log("Block deleted!"),e.parent().parent().remove(),jQuery("#bgcontainer"+e.attr("data-slide")+" #blockcontainer"+e.attr("data-element")).remove()},error:function(){}})})}),jQuery(document).ready(function(){jQuery("#sliderSpeed").change(function(){jQuery("label[for='sliderSpeed']").html("Speed ("+jQuery("#sliderSpeed").val()+" ms)")})}),jQuery(document).ready(function(){jQuery(".blockcontainer").draggable({cursor:"move",stop:function(){jQuery(this).css("left"),jQuery(this).css("top");var e=100*parseFloat(jQuery(this).position().left/parseFloat($(this).parent().width())),t=100*parseFloat(jQuery(this).position().top/parseFloat($(this).parent().height())),o=jQuery(this).attr("data-el");jQuery.ajax({url:setting_apiUrl+"/?page=updateblockpos",method:"POST",data:{id_block:o,x:e,y:t},success:function(){console.log("Position of block updated!")},error:function(){console.log("Something went wrong! Please contact with admin.")}})}}),jQuery(".blockcontainer").each(function(e){var t=jQuery(this).attr("data-el"),o=jQuery("#dialogBlock"+t).dialog({autoOpen:!1,height:500,width:350,modal:!0,buttons:{"Save in database":function(){updateBlockDB(t,o)},Cancel:function(){o.dialog("close")}},close:function(){jQuery(".validateTips").removeClass("ui-state-error")}});o.dialog("close"),o.css("display","block"),o.find("form.dialogForm").on("submit",function(e){e.preventDefault(),updateBlockDB(t)}),jQuery(this).on("click",function(){o.dialog("open"),console.log(t)})})}),jQuery(document).ready(function(){jQuery("#saveSlider").click(function(){console.log("Updating slider..."),updateSliderDB()}),jQuery("#sliderName, #sliderSpeed, #sliderHeight").change(function(){jQuery("#saveSlider").removeClass("btn-success").addClass("btn-danger")})}),jQuery(document).ready(function(){jQuery(".textcontainer").draggable({cursor:"move",stop:function(){jQuery(this).css("left"),jQuery(this).css("top");var e=100*parseFloat(jQuery(this).position().left/parseFloat(jQuery(this).parent().width())),t=100*parseFloat(jQuery(this).position().top/parseFloat(jQuery(this).parent().height())),o=jQuery(this).attr("data-el");jQuery.ajax({url:setting_apiUrl+"/?page=updatetextpos",method:"POST",data:{id_text:o,x:e,y:t},success:function(){console.log("Position of block updated!")},error:function(){console.log("Something went wrong! Please contact with admin.")}})}}),jQuery(".textcontainer").each(function(e){var t=jQuery(this).attr("data-el"),o=jQuery("#dialogText"+t).dialog({autoOpen:!1,height:500,width:350,modal:!0,buttons:{"Save in database":function(){updateTextDB(t,o)},Cancel:function(){o.dialog("close")}},close:function(){jQuery(".validateTips").removeClass("ui-state-error")}});o.dialog("close"),o.css("display","block"),o.find("form.dialogForm").on("submit",function(e){e.preventDefault(),updateTextDB(t)}),jQuery(this).on("click",function(){o.dialog("open"),console.log(t)})})});