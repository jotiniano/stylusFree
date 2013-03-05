$(function(){
    
    $('#clienteReserva').typeahead({
            source: function(typeahead, query) {
                if (query.length < 1)
                    return [];
                $.post('/agenda/listar-clientes', {query: query}, function(data) {
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
           this.ComboDependiente("#idTipo", "#idItem", "#idUsuario", "-- Seleccionar --", "/admin/ticket/productotipo", "idProducto", "nombreProducto");
           this.ComboDependienteDos("#idTipo", "#idItem", "#idUsuario", "-- Seleccionar --", "/admin/user/get-usuarios", "idUsuario", "nombreUsuario");
           this.appendTableIngresos("#agregarItem", "#idPanelTablaDetalleIngreso");
           this.deleteRowTableIngreso();           
        },        
        ComboDependiente : function (c, cd, cus, def, url, fieldv, fields) {
            $(c).live("change blur", function(){                
                var actual = $(this);                
                if (actual.val() != 0) {
                    $(cus).html("");
                    $(cus).append("<option value='0'>"+def+"</option>");
                    $(cus).attr("disabled", "disabled");
                    
                    $(cd).removeAttr("disabled");
                    $("#agregarItem").removeAttr("disabled");
                    
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',                        
                        success: function(data){
                                $(cd).html("<option> --Seleccionar-- </option>");
                                $.each(data, function(index, value){
                                    $(cd).append("<option precio='" + value["precio"] + "' id='idItem'  data ='"+ value[fields]+"' value='"+value[fieldv]+"'>"+value[fields]+"</option>");
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
       ComboDependienteDos : function (tipo, c, cd, def, url, fieldv, fields) {           
           $(c).bind("change blur", function(){
               var actual = $(this);
               var precio = $("#idItem option:selected").attr("precio");
               $("#idPrecio").val(precio);
               
                var tipoVal = $(tipo).val();
                if (actual.val() != 0 && tipoVal == '2') {
                    $(cd).removeAttr("disabled");
                    $("#agregarItem").removeAttr("disabled");                    
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
                                    $(cd).append("<option id='idUsuario'  data ='"+ value[fields]+"' value='"+value[fieldv]+"'>"+value[fields]+"</option>");
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
                if($(this).attr("disabled")== "" || $(this).attr("disabled")== undefined){
                    
                $("#generar").removeAttr("disabled");
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                //Obteniendo valores
                var tipo     = $("#idTipo").val();
                var servicio     = $("#idItem").val();
                var precio     = $("#idPrecio").val();
                if (tipo == '2') {
                    var idworker     = $("#idUsuario").val();
                } else {
                    var idworker     = '';
                }
                
                var total     = $("#totalValue").val();
                
                if (total != "") {
                    var sum = parseFloat($("#totalValue").val()) + parseFloat(precio);
                    $("#totalValue").val(sum);
                } else {
                    $("#totalValue").val(precio);
                }
                
                //MEDIO PAGO
                var inputMediopago = "<input type='hidden' name='detalleServicio[]' value='"+servicio+"' />";
                var inputMediopagoValor = $("#idItem option:selected").text();
                //worker
                var inputWorker = "<input type='hidden' name='detalleWorker[]' value='"+idworker+"' />";
                if (tipo == '2') {
                    var inputWorkerValor = $("#idUsuario option:selected").text();
                } else {
                    var inputWorkerValor = "--";
                }
                
                
                
                //COSTO
                var inputCosto = "<input type='hidden' name='detalleCosto[]' value='"+precio+"' />";
                var inputCostoValor = "S/. <span class='precio'>"+precio+"</span>";
                     
                $("th:eq(0)", row).html(inputMediopagoValor+inputMediopago);
                $("th:eq(1)", row).html(inputCostoValor+inputCosto); 
                $("th:eq(2)", row).html(inputWorkerValor+inputWorker);
                $(tabla+' tbody>tr:first').addClass("hide");
                var tfinal = parseFloat($("#totalValue").val());
                $("#totalfinal").html(tfinal.toFixed(2));
                }
            });
            
        },
        deleteRowTableIngreso : function() {
           $(".eliminarDetalleIngreso").live("click", function(e){
               var va = $(this).parents("tr").find("th");
               var les = $($(va[1]).find("span")).html();               
               var sum = parseFloat($("#totalValue").val()) - parseFloat(les);
               $("#totalValue").val(sum);
               $("#totalfinal").html(sum);
               e.preventDefault();
               $(this).parents("tr").remove();
               
           });
        }
    }
    
    ingresos.init();
    
    
    
});
