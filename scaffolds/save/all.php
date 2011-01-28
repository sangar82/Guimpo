<?php
$scaffold = '{
                "name"  : "categoria",
                "campos": {
            
                            "name" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "1",
                                        "type"       : "text",
                                        "minlength"  : "1",
                                        "maxlength"  : "60",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },

                            "cantidad" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "1",
                                        "type"       : "numeric",
                                        "minlength"  : "-4",
                                        "maxlength"  : "1000",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },
                                        
                                        
                            "publico" : {                                        
                                        "class"      : "",
                                        "value"      : "1",
                                        "mandatory"  : "0",
                                        "type"       : "checkbox",
                                        "checked"    : "false",
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },
                                        
                            "idioma" : {                                        
                                        "class"               : "",
                                        "mandatory"           : "1",
                                        "type"                : "select",
                                        "with_language"       : "0",
                                        "default_language"    : "es",
                                        "with_default_value"  : "1",
                                        "lng"                 : "es",
                                        "size"                : "1", 
                                        "multiple"            : "false", 
                                        "disabled"            : "false", 
                                        "readonly"            : "false",
                                        "tabindex"            : "0", 
                                        "options"             : {
                                                                "castellano" : {
                                                                              "text"      : "Castellano",                                        
                                                                              "selected"  : "true",
                                                                              "value"     : "castellano"
                                                                              }, 
                                                                        
                                                                "ingles" : {
                                                                              "text"      : "Ingles",                                        
                                                                              "selected"  : "false",
                                                                              "value"     : "ingles"
                                                                           }                                           
                                                                }
                                        }, 
                                                                               
                                        
            
                            "tipo" : {                                        
       
                                        "type"       : "radio",
                                        "mandatory"  : "0",
                                        "options"    : {
                                                        "masculino" : {
                                                                      "class"      : "",
                                                                      "value"      : "masculino",                                        
                                                                      "checked"    : "true",
                                                                      "disabled"   : "false", 
                                                                      "readonly"   : "false",
                                                                      "tabindex"   : "0"
                                                                      }, 
                                                                
                                                        "femenino" : {
                                                                      "class"      : "",
                                                                      "value"      : "femenino",
                                                                      "checked"    : "false",
                                                                      "disabled"   : "false", 
                                                                      "readonly"   : "false",
                                                                      "tabindex"   : "0"
                                                                      } 
                                                       }
                                        }, 
                                        
                            "descripcion" : {
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "0",
                                        "type"       : "textarea",
                                        "cols"       : "57",
                                        "rows"       : "8",
                                        "minlength"  : "0",
                                        "maxlength"  : "500",
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },
										
                            "poblacion" : {                                        
                                        "class"               : "",
                                        "mandatory"           : "1",
                                        "type"                : "selectbd",
                                        "with_language"       : "0",
                                        "default_language"    : "es",
                                        "with_default_value"  : "1",
                                        "lng"                 : "es",
                                        "size"                : "1", 
                                        "multiple"            : "false", 
                                        "disabled"            : "false", 
                                        "readonly"            : "false",
                                        "tabindex"            : "0", 
                                        "options"             : {
                                                                "table" : "poblaciones",
                                                                "idshow":  "id",
                                                                "nameshow": "poblacion" ,
                                                                "queryoptions": "",
                                                                "default":""
                                                                }
                                        },                            
										
                            "image" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "0",
                                        "type"       : "image",
                                        "minlength"  : "0",
                                        "maxlength"  : "200",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" }
                          }
             }';

$scaffold = '{
                "name"  : "test",
                "campos": {
                            "name" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "0",
                                        "type"       : "text",
                                        "minlength"  : "1",
                                        "maxlength"  : "60",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },


                                        

                                        
  
                                                                               
                            "categoria_id" : {                                        
                                        "class"               : "",
                                        "mandatory"           : "0",
                                        "type"                : "selectbd",
                                        "with_language"       : "0",
                                        "default_language"    : "es",
                                        "with_default_value"  : "0",
                                        "lng"                 : "es",
                                        "size"                : "1", 
                                        "multiple"            : "false", 
                                        "disabled"            : "false", 
                                        "readonly"            : "false",
                                        "tabindex"            : "0", 
                                        "options"             : {
                                                                    "table"         :    "categoria",
                                                                    "nameshow"      :    "name",
                                                                    "idshow"        :    "id",
                                                                    "default"       :    "",
                                                                    "queryoptions"  :    ""
                                                                }
                                        }
                                        
            

                          }
             }';

?>