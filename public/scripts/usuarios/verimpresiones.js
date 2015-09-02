
$(document).ready(function (){

impresiones();	
	function impresiones(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'usuario_id',type: 'number'},
			{ name: 'costo_impresion',type: 'number'},
			{ name: 'fecha_reg',type: 'date'},
			{ name: 'estado',type:'number'},
			],
			url: '/usuarios/listimpresiones/'+$("#usuario_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		$("#jqxgrid_impresiones").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            pageable: true,
            pagerMode: 'advanced',
            groupable: false,
            statusbarheight:25,
            showaggregates: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Fecha Impresión', datafield: 'fecha_reg', filtertype: 'range', width: '47%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy',align:'center'},
			{ text: 'Monto por Impresión Bs.', datafield: 'costo_impresion', filtertype: 'number',width: '49%' ,cellsformat: "c2", cellsalign: 'center',aggregates: [{ '<b>Total</b>':
                            function (aggregatedValue, currentValue, column, record) {
                                // var total = currentValue + parseInt(record['costo_impresion']);
                                var s =aggregatedValue + currentValue;
                                $("#total_impresion").val(s); 
                                saldo();
                                return s;
                            }
                      }]                  
            },
	        ]
	});

}

depositos();	
	function depositos(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'usuario_id',type: 'number'},
			{ name: 'costo_impresion',type: 'number'},
			{ name: 'fecha_reg',type: 'date'},
			{ name: 'estado',type:'number'},
			],
			url: '/usuarios/listdepositos/'+$("#usuario_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		$("#jqxgrid_depositos").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            pageable: true,
            pagerMode: 'advanced',
            groupable: false,
            statusbarheight:25,
            showaggregates: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Fecha Deposito', datafield: 'fecha_reg', filtertype: 'range', width: '47%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy',align:'center'},
			{ text: 'Monto Deposito Bs.', datafield: 'costo_impresion', filtertype: 'number',width: '49%' ,cellsformat: "c2", cellsalign: 'center',aggregates: [{ '<b>Total</b>':
                            function (aggregatedValue, currentValue, column, record) {
                                // var total = currentValue + parseInt(record['costo_impresion']);
                                var s =aggregatedValue + currentValue;
                                $("#total_deposito").val(s); 
                                saldo();
                                return s;
                            }
                      }]                  
            },
	        ]
	});

}

function saldo() {
	var diff = $("#total_impresion").val()-$("#total_deposito").val();
	$("#saldo").text(diff);	
}

/*
Eliminar Contrato
*/
$("#delete_impresion").click(function(){
	var rowindex = $('#jqxgrid_impresiones').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_impresiones").jqxGrid('getrowdata', rowindex);
		
			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
				if (result == true) {
					var v = $.ajax({
						url: '/usuarios/deleteimpresion/',
						type: 'POST',
						datatype: 'json',
						data: {id: dataRecord.id},
						success: function(data) {
                            impresiones(); //alert('Guardado Correctamente'); 
                            depositos(); //alert('Guardado Correctamente'); 
                            $("#divMsjeExito2").show();
                            $("#divMsjeExito2").addClass('alert alert-warning alert-dismissable');
                            $("#aMsjeExito2").html(data); 
                        }, //mostramos el error
                        error: function() {
                        	alert('Se ha producido un error Inesperado');
                        }
                    });
				}
			});
		
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
	}
});

$("#delete_deposito").click(function(){
	var rowindex = $('#jqxgrid_depositos').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_depositos").jqxGrid('getrowdata', rowindex);
		
			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
				if (result == true) {
					var v = $.ajax({
						url: '/usuarios/deleteimpresion/',
						type: 'POST',
						datatype: 'json',
						data: {id: dataRecord.id},
						success: function(data) {
                            impresiones(); //alert('Guardado Correctamente'); 
                            depositos(); //alert('Guardado Correctamente'); 
                            $("#divMsjeExito2").show();
                            $("#divMsjeExito2").addClass('alert alert-warning alert-dismissable');
                            $("#aMsjeExito2").html(data); 
                        }, //mostramos el error
                        error: function() {
                        	alert('Se ha producido un error Inesperado');
                        }
                    });
				}
			});
		
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
	}
});



})