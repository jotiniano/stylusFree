$(function(){
    
    $('#clienteReserva').typeahead({
            source: function(typeahead, query) {
                if (query.length < 1)
                    return [];
                $.post('/agenda/listar-clientes', { query: query}, function(data) {
                    return typeahead.process(JSON.parse(data));
                });
            },
            onselect: function(obj) {
                $("#otroCliente").val(obj.id);                
            }
        });
    
    var url = "/admin/ingresos/buscar-alumno";
    
    
    var ingresos = {
        
        init : function() {
           this.ComboDependiente("#idServicio", "#idUsuario", "-- Seleccionar --", "/admin/user/get-usuarios", "idUsuario", "nombreUsuario");
           this.appendTableIngresos("#agregarItem", "#idPanelTablaDetalleIngreso");
           this.deleteRowTableIngreso();           
        },        
        ComboDependiente : function (c, cd, def, url, fieldv, fields) {
            $(c).live("change blur", function(){                
                var actual = $(this);
                
                if (actual.val() != 0) {
                    var precio = $("#idServicio option:selected").attr("precio");
                    $("#idPrecio").val(precio);
                    
                    
                    $(cd).removeAttr("disabled");
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',
                        
                        success: function(data){                                
                                $(cd).html("");
                                $.each(data, function(index, value){                                    
                                    $(cd).append("<option id='user'  data ='"+ value[fields]+"' value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                });
                        }                         
                    });
                    
                } else {                    
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       },
        appendTableIngresos : function(btn, tabla) {
            $(btn).bind("click", function(){
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                //Obteniendo valores
                var servicio     = $("#idServicio").val();                
                var precio     = $("#idPrecio").val();                
                var idworker     = $("#idUsuario").val();
                
                
                //MEDIO PAGO
                var inputMediopago = "<input type='hidden' name='detalleServicio[]' value='"+servicio+"' />";
                var inputMediopagoValor = $("#idServicio option:selected").text();
                //worker
                var inputWorker = "<input type='hidden' name='detalleWorker[]' value='"+idworker+"' />";
                var inputWorkerValor = $("#idUsuario option:selected").text();
                
                //COSTO
                var inputCosto = "<input type='hidden' name='detalleCosto[]' value='"+precio+"' />";
                var inputCostoValor = "S/."+precio;                
                
                     
                $("th:eq(0)", row).html(inputMediopagoValor+inputMediopago);
                $("th:eq(1)", row).html(inputCostoValor+inputCosto);
                $("th:eq(2)", row).html(inputWorkerValor+inputWorker);
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
