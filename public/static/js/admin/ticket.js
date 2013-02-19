$(function(){
    
    var url = "/admin/ingresos/buscar-alumno";
    
    
    var ingresos = {
        
        init : function() {
           this.medioPagoHide("#idMedioPago");
           //this.ComboDependiente("#nivel", "#grado", "-- Seleccionar --", "/admin/grados/get-grados-por-nivel-ajax", "id", "descripcion");
           this.ComboDependiente("#idServicio", "#precio");
           this.ComboDependienteTipo("#idTipoConcepto", "#idConcepto", "-- Seleccionar --", "/admin/concepto/get-concepto-ajax", "id", "descripcion");
           this.ComboDependienteBanco("#idBanco", "#idCuentaBancaria", "-- Seleccionar --", "/admin/cuenta-bancaria/get-cuenta-bancaria-ajax", "id", "numerocuenta");
           this.appendTableIngresos("#agregarItem", "#idPanelTablaDetalleIngreso");
           this.deleteRowTableIngreso();           
        },        
        ComboDependiente : function (c, p) {
            $(c).live("change blur", function(){
                //var data = $(c).attr("value").toString();
                //var data = $(c).attr('data');
                //alert(data);
            });
       }
        ,
        ComboDependienteTipo : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change blur", function(){
                var actual = $(this);
                if (actual.val()!=0) {                    
                    $(cd).removeAttr("disabled");
                    $(cd).attr("disabled", "disabled");
                    $(cd).html("<option>Cargando...</option>");
                    $("#idMedioPago").val(0);
                    $("#idMedioPago").change();
                    
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',
                        success: function(response){                            
                            if (response.status==true) {
                                var data = response.data;
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                    
                                });
                                $(cd).removeAttr("disabled")
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       },
       ComboDependienteBanco : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change blur", function(){
                var actual = $(this);
                var concepto = $("#idConcepto");
                if (actual.val()!=0) {                    
                    $(cd).removeAttr("disabled");
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val(),
                           idc : concepto.val()
                        },
                        dataType: 'json',
                        success: function(response){                            
                            if (response.status==true) {
                                var data = response.data;
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                    
                                });
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       },
        medioPagoHide : function(content) {
            $(content).bind("change", function(){
                var medio = $(this).val();
                if (medio == 1) {
                    $("#panelInstitucionFinanciera").removeClass("hide");
                } else {
                    $("#panelInstitucionFinanciera").addClass("hide");
                }
                    
                
                
            });
        },
        appendTableIngresos : function(btn, tabla) {
            $(btn).bind("click", function(){
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                //Obteniendo valores
                var servicio     = $("#idServicio").val();                
                var precio     = $("#precio").val();
                
                //MEDIO PAGO
                var inputMediopago = "<input type='hidden' name='detalleServicio[]' value='"+servicio+"' />";
                var inputMediopagoValor = $("#idServicio option:selected").text();
                
                //COSTO
                var inputCosto = "<input type='hidden' name='detalleCosto[]' value='"+precio+"' />";
                var inputCostoValor = "S/."+precio;                
                
                     
                $("th:eq(0)", row).html(inputMediopagoValor+inputMediopago);
                $("th:eq(1)", row).html(inputCostoValor+inputCosto);
                $(tabla+' tbody>tr:first').addClass("hide");
            });
        },
        deleteRowTableIngreso : function() {
           $(".eliminarDetalleIngreso").live("click", function(e){
               e.preventDefault();
               $(this).parents("tr").remove();    
           });
        }
        
        
    }
    
    ingresos.init();
    
    
    
});
$("#frmTicket").validate({   
  rules: {
    precio: "required"
  }
});