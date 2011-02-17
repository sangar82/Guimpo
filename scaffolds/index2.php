<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Droppable - Shopping Cart Demo</title>
	<link rel="stylesheet" href="http://www.guimpo.com/css/cupertino/jquery-ui-1.8.9.custom.css?1">
	<script src="http://www.guimpo.com/js/jquery.js?1"></script>
	<script src="http://www.guimpo.com/js/jquery-ui-1.8.9.custom.min.js?1"></script>

	<link rel="stylesheet" href="../demos.css">
	<style>


	.demo{
		width:1200px;
		height:auto;
		margin:0px auto;
		position:relative
	}
	
	#forms{
		width:260px;
		height:auto;
		float:left;
	}
	
	#forms div{
		width:200px;
		height:50px;
		line-height:50px;
		font-family:verdana;
		padding:5px;
		text-align:center;
		font-size:14px;
		font-weight:bold;
		display:block;
		float:left;
		border:1px #0070A3 solid;
		color:#0070A3;
		margin-bottom:5px;
		cursor:pointer;
		-webkit-border-radius: 10px; 
          -moz-border-radius: 10px; 
	}
	
	#cart { 
		width: 300px; 
		height:auto;
		min-height:200px;
		float: left; 
		margin:0px auto;
		text-align:center;
		float:left;
		padding:10px;
		margin-right:140px
	}
	
	#options{
	   width: 450px; 
	   height:auto;
	   float:left;
	}
	
	.drops{
	     position:relative;
	     left:44px;
		width:200px;
		height:50px;
		font-family:verdana;
		padding:5px;
		text-align:center;
		font-size:14px;
		font-weight:bold;
		border:1px #0070A3 solid;
		color:#0070A3;
		margin-bottom:5px;
		cursor:pointer;
		-webkit-border-radius: 10px; 
          -moz-border-radius: 10px; 		
          background:#fff;
	}
	
	.clear{
	     clear:both;
	}
	
	.optionsdrop{
	 display:inline;
	 font-size:11px;
	}
	
	.dnone{
	 display:none;
	}
	
	.dblock{
	 display:block;
	}

	
	</style>
	<script>
	
	var c = 0;
	
	$(function() {

		$( "#forms div" ).draggable({
			helper: "clone"
		});
		
		$( "#cart" ).droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ":not(.optionsdrop, .drops )",
			drop: function( event, ui ) {
				$( this ).find( ".placeholder" ).remove();
				
				var x =$( "<div class='drops'></div>" ).text( ui.draggable.text()  );
				//var d = $( "<div class='optionsdrop'><br/><span>view</span> |<span>edit</span> | <span class='dropdelete'>delete</span></div>" ).appendTo(x);
				var d = $( "<br /><div id='"+c+"' class='optionsdrop'></div>" ).appendTo(x);
				
				x.appendTo( this );
				
				var aux = $('#dialog-'+ui.draggable.text());
				
				aux = aux.clone();
				
				aux.children().children().children().children().first().next().children().addClass("o"+c);
				
				aux.appendTo('#choosen');
				
				
		$( "#choosen #dialog-"+ui.draggable.text() ).dialog({
			autoOpen: true,
			position: 'center',
			height: 550,
			width: 350,
			modal: true,
			buttons: {
				"Guardar": function() {
					$( this ).dialog( "close" );
					
					//añadimos el nombre al drop
				     var name = $(".o"+ (c-1)).val();
                          $('#'+c).html('fdf');	                        
                          var x =setTimeout("printname("+c+", '"+name+"')", 100);
                          
                          //añadimos el nombre si es un text al select
                          if (ui.draggable.text() == "Text"){
                            var selected = (c == 1)  ? "selected" : "";
                            getNuevoCombo="<option value='"+name+"' "+selected+">"+name+"</option>";
                            $("#stripped").append(getNuevoCombo);
                          }
                          
                          //si añade el primer campo mostramos las opciones de guardado
                          $("#generator").fadeIn('slow');
  
					}
				}
		});

				
           c++;
           
			}
		})/*.sortable({
			items: ":not(.optionsdrop, .optionsdrop span)",
			sort: function() {
				// gets added unintentionally by droppable interacting with sortable
				// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
				$( this ).removeClass( "ui-state-default" );
			}
		});*/
		
		
	});
	
	
	function printname(c, name){
	 
	  $('#'+ (c-1)).html("("+name+")");
	  
	}
	  
      $(document).ready(function() {
   
         $('#enviar').click(function() {
            
            var code = "";
            var mname = $("#name_rel").val();
            var mtype = $("input[name='typerel']:checked").val();
            var mstripped =  $( '#stripped option:selected' ).val();
            var campos = recupera_dades();
            
            if (mtype == "webform"){
              code += "{ \"name\" : \""+mname+"\" , \"type\" : \""+mtype+"\",";
              
              if (mstripped != 0){
                  code += "  \"stripped\"    : \""+mstripped+"\", ";
              }
              
              code += campos;

            }else{
              
            }
            
            code +="}";
            
            //añadimos el codigo generado al formulario para enviarlo a procesar
            $( '#scaffold' ).val(code);
            
            //alert(code);
            $("#dragdropform").submit();
           
         });

         
         $("input[name='typerel']").change(function(){
           
            if ($("input[name='typerel']:checked").val() == 'webform'){
                
              $("#rs").hide();
              $("#rm").hide();
                
            }else if ($("input[name='typerel']:checked").val() ==  'webform_relational'){
              
              $("#rs").show();
              $("#rm").show();
              
            }

        });

        
      }); //end document.ready
      
      
      function recupera_dades(){
        
        var campos = "\"campos\":{";

        $('.tform:not(#templates .tform)').each(function(index) {

          if ($(this).hasClass('text')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = $(this).find('.i_value').val();
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            tmultilanguage   = ($(this).find('.i_multilanguage:checked').val() == '1') ? '1' : '0';
            ttype   = $(this).find('.i_type').val();
            tminlenght   = $(this).find('.i_minlenght').val();
            tmaxlenght   = $(this).find('.i_maxlenght').val();
            tsize   = $(this).find('.i_size').val();
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = $(this).find('.i_tabindex').val();
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\", \"multilanguage\":\""+tmultilanguage+"\", \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"size\":\""+tsize+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";
            
          }else if ($(this).hasClass('textarea')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = $(this).find('.i_value').val();
            tcols   = $(this).find('.i_cols').val();
            trows   = $(this).find('.i_rows').val();
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            tmultilanguage   = ($(this).find('.i_multilanguage:checked').val() == '1') ? '1' : '0';
            tckeditor   = ($(this).find('.i_ckeditor:checked').val() == '1') ? '1' : '0';
            ttype   = $(this).find('.i_type').val();
            tminlenght   = $(this).find('.i_minlenght').val();
            tmaxlenght   = $(this).find('.i_maxlenght').val();
            tsize   = $(this).find('.i_size').val();
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = $(this).find('.i_tabindex').val();
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\", \"multilanguage\":\""+tmultilanguage+"\", \"cols\":\""+tcols+"\", \"rows\":\""+trows+"\", \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"ckeditor\":\""+tckeditor+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";

          }else if ($(this).hasClass('image')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = "";
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            tmultilanguage   = ($(this).find('.i_multilanguage:checked').val() == '1') ? '1' : '0';
            ttype   = "image";
            tminlenght   = "0";
            tmaxlenght   = "300";
            tsize   = $(this).find('.i_size').val();
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = "0";
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\", \"multilanguage\":\""+tmultilanguage+"\", \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";
         
          }else if ($(this).hasClass('file')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = "";
            textensions   = $(this).find('.i_extensions').val();
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            tmultilanguage   = ($(this).find('.i_multilanguage:checked').val() == '1') ? '1' : '0';
            ttype   = "file";
            tminlenght   = "0";
            tmaxlenght   = "300";
            tsize   = $(this).find('.i_size').val();
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = "0";
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\",  \"extensions\":\""+textensions+"\", \"multilanguage\":\""+tmultilanguage+"\", \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";

          }else if ($(this).hasClass('datepicker')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = $(this).find('.i_value').val();
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            ttype   = "datepicker";
            tminlenght   = "0";
            tmaxlenght   = "10";
            tsize   = "10";
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = "0";
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\",  \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";
                     
           }else if ($(this).hasClass('checkbox')){
            
            tname  = $(this).find('.i_name').val();
            tclass   = $(this).find('.i_class').val();
            tvalue   = "1";
            tmandatory   = ($(this).find('.i_mandatory:checked').val() == '1') ? '1' : '0';
            tchecked   = ($(this).find('.i_checked:checked').val() == '1') ? '1' : '0';
            ttype   = "checkbox";
            tminlenght   = "0";
            tmaxlenght   = "5";
            tdisabled   = ($(this).find('.i_disabled:checked').val() == '1') ? '1' : '0';
            treadonly   = ($(this).find('.i_readonly:checked').val() == '1') ? '1' : '0';
            ttabindex   = "0";
            
            var json = "\""+tname+"\":{\"class\":\""+tclass+"\", \"value\":\""+tvalue+"\", \"mandatory\":\""+tmandatory+"\",  \"checked\":\""+tchecked+"\", \"type\":\""+ttype+"\", \"minlength\":\""+tminlenght+"\", \"maxlength\":\""+tmaxlenght+"\", \"disabled\":\""+tdisabled+"\", \"readonly\":\""+treadonly+"\", \"tabindex\":\""+ttabindex+"\"},";
                     
                                               
          }else{
            
            alert('es nada');
            
          }
          
          campos += json;
             
        }); 
         
        //eliminamos la ultima coma
        var lcampos = campos.length;
        campos = campos.slice (0, lcampos-1); 
        
         campos += "}";
         
         return(campos);
      }
      
	</script>
</head>
<body>

<div class="demo">
	
	<div id='forms'>

		<div id='text' class='forms_items'>Text</div>
		<div id='textarea' class='forms_items'>Textarea</div>
		<div id='checkbox' class='forms_items'>Checkbox</div>
		<div id='image' class='forms_items'>Image</div>
		<div id='file' class='forms_items'>File</div>
		<div id='datepicker' class='forms_items'>Datepicker</div>

	</div>

	
    <div id="cart" class="ui-widget-content">
    
      <span class="placeholder">Añade aqui los campos del formulario</span>

    </div>
    
    
    <div id='options'>
      
        <b>Modelo</b><br><br>
      
        <input type='radio' name='typerel'  id='rel_new' value='webform'  checked='checked' /> <label for='rel_new'>Nuevo modelo</label>  <input type='radio' name='typerel'  id='rel_1n' value='webform_relational' /> <label for='rel_1n'>Relación 1:n</label> <br/><br/>
      
        Nombre del modelo/relación <input type='text' name='name_rel' id='name_rel'  /> <br/><br/>
        
        Stripped &nbsp;&nbsp;
        
        <select name='stripped' id='stripped'>
          <option value='0'>Sin stripped</option>
        </select> <br /><br/>
                
        <div id='rs' class='dnone'>Relation stripped <input type='radio' name='rel_stripped'  id='rel_stripped_true' value='true'  /> <label for='rel_stripped_true'>True</label>  <input type='radio' name='rel_stripped'  id='rel_stripped_false' value='false' checked /> <label for='rel_stripped_false'>False</label> <br /><br /></div>        
        
        <div id='rm' class='dnone'>Relation multilanguage <input type='radio' name='rel_multilanguage'  id='rel_multi_true' value='true'  /> <label for='rel_stripped_true'>True</label>  <input type='radio' name='rel_multilanguage'  id='rel_multi_false' value='false' checked /> <label for='rel_stripped_false'>False</label> <br /><br /></div>        
        
        <div id='generator' class='dnone'>
        
        <br><b>Generador</b><br><br>
        
          <form name='dragdropform' id='dragdropform'  method="POST" action="index.php">
      
            <input type='checkbox' name='secuencia' id='secuencia'> <label for='secuencia'>Crear secuencia</label>
            
            &nbsp;&nbsp; <input type='checkbox' name='tabla' id='tabla'> <label for='tabla'>Crear tabla</label>
            
            &nbsp;&nbsp; <input type='checkbox' name='droptabla' id='droptabla'> <label for='droptabla'>Drop tabla</label>
            
            <br><br><input type='checkbox' name='htaccess' id='htaccess'><label for='htaccess'>Modificar htaccess</label>
        
            &nbsp;&nbsp;<input type='checkbox' name='cambios' id='cambios'><label for='cambios'>Cambios en el codigo</label>
            
            &nbsp;&nbsp;<input type='checkbox' name='admin' id='admin'><label for='admin'>Crear en admin</label> 
            
            <br><br>
            
            <input type='hidden' name='scaffold' id='scaffold' value='' />
            
            <input type='button' id='enviar' value='Generar'>
          
        </div>
        
        </form>
     
      </div>

    <div class='clear'></div>

</div><!-- End demo -->


<div id='templates' style='display:none'>
  
  <div id='dialog-Text' title='Nuevo campo text' style='display:none;font-size:11px;'>
    <table class='text tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name" value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Value</td><td><input type='text'  class="i_value" value=''  /></td>
    	</tr>
    	
    	 <tr>
    		<td width="80">Type</td><td><input type='text'  class="i_type" value='text' readonly value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Minlenght</td><td><input type='text'  class="i_minlenght"  size=4  value='1' value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Maxlenght</td><td><input type='text'  class="i_maxlenght" size=4 value='60' value='' /></td>
    	</tr>
    	
    	 <tr>
    		<td width="80">TabIndex</td><td><input type='text'  class="i_tabindex"  size=4  value='0'  value=''/></td>
    	</tr>
    	
     	<tr>
    		<td width="80">Size</td><td><input type='text'  class="i_size" size=4  value='60' value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Multilanguage</td><td><input type='checkbox'  class="i_multilanguage" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>



    </table>
  </div>
  
  
  <div id='dialog-Textarea' title='Nuevo campo textarea' style='display:none; font-size:11px;''>
    <table class='textarea tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Value</td><td><input type='text'  class="i_value"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Type</td><td><input type='text'  class="i_type" value='textarea' readonly value='' /></td>
    	</tr>
    	
    	<tr>
    		<td width="80">Columns</td><td><input type='text'  class="i_cols"  value='57'  size=4 /> </td>
    	</tr>

    	<tr>
    		<td width="80">Rows</td><td><input type='text'  class="i_rows"  value='8' size=4 /> </td>
    	</tr>

    	<tr>
    		<td width="80">Minlenght</td><td><input type='text'  class="i_minlenght"  size=4  value='1'  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Maxlenght</td><td><input type='text'  class="i_maxlenght" size=4 value='500'  value='' /></td>
    	</tr>
    	
    	<tr>
    		<td width="80">TabIndex</td><td><input type='text'  class="i_tabindex"  size=4  value='0'  value=''/></td>
    	</tr>

    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Multilanguage</td><td><input type='checkbox'  class="i_multilanguage" value='1'> </td>
    	</tr>    
    	   	
      <tr>
    		<td width="80">With CKEditor</td><td><input type='checkbox'  class="i_ckeditor"  value='1' /> </td>
    	</tr>	    	
    	
    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>


    </table>
  </div>
  

    <div id='dialog-Image' title='Nuevo campo imagen' style='display:none;font-size:11px;'>
    <table class='image tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name" value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>
    	
     	<tr>
    		<td width="80">Size</td><td><input type='text'  class="i_size" size=4  value='60' value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Multilanguage</td><td><input type='checkbox'  class="i_multilanguage" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>



    </table>
  </div>
  
  
  
   <div id='dialog-File' title='Nuevo campo archivo' style='display:none;font-size:11px;'>
    <table class='file tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name" value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Valid extensions</td><td><input type='text'  class="i_extensions"  value='pdf,doc' /></td>
    	</tr>
    	
     	<tr>
    		<td width="80">Size</td><td><input type='text'  class="i_size" size=4  value='60' value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Multilanguage</td><td><input type='checkbox'  class="i_multilanguage" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>

    </table>
  </div>

  
  <div id='dialog-Datepicker' title='Nuevo campo datepicker' style='display:none;font-size:11px;'>
    <table class='datepicker tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name" value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Value</td><td><input type='text'  class="i_value" value=''  /></td>
    	</tr>
    	
    	 <tr>
    		<td width="80">TabIndex</td><td><input type='text'  class="i_tabindex"  size=4  value='0'  value=''/></td>
    	</tr>

    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>

    </table>
  </div>  

  
  <div id='dialog-Checkbox' title='Nuevo campo checkbox' style='display:none;font-size:11px;'>
    <table class='checkbox tform' cellpadding="2" cellspacing="5">
    
    	<tr>
    		<td width="80">Name</td><td><input type='text'  class="i_name" value='' /></td>
    	</tr>

    	<tr>
    		<td width="80">Class</td><td><input type='text'  class="i_class"  value='' /></td>
    	</tr>

    	 <tr>
    		<td width="80">TabIndex</td><td><input type='text'  class="i_tabindex"  size=4  value='0'  value=''/></td>
    	</tr>
    	
    	<tr>
    		<td width="80">Mandatory</td><td><input type='checkbox'  class="i_mandatory" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Checked</td><td><input type='checkbox'  class="i_checked" value='1'> </td>
    	</tr>

    	<tr>
    		<td width="80">Disabled</td><td><input type='checkbox'  class="i_disabled" name='i_disabled' value='1' /></td>
    	</tr>

    	<tr>
    		<td width="80">Readonly</td><td><input type='checkbox'  class="i_readonly" name='i_readonly' value='1' /></td>
    	</tr>



    </table>
  </div>  
  
  
</div>


<div id='choosen'>

</div>




</body>
</html>
