
$(document).ready(function (){
	cargar();
	function cargar() {
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'codigo',type: 'string'},
			{ name: 'ubicacion',type: 'string'},
			{ name: 'sector',type: 'string'},
			{ name: 'tipo',type: 'string'},
			{ name: 'tipo1',type: 'string'},
			{ name: 'fecha',type: 'date'},
			{ name: 'descripcion',type:'string'},
			{ name: 'descripcion1',type:'string'},
			],
			url: '/bases/list/',
			root: 'Rows',
			beforeprocessing: function (data) {
				source.totalrecords = data[0].TotalRows;
			},
			sort: function () {
				$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
			},
			filter: function () {
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
			}
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		$("#jqxgrid").jqxGrid({

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
            virtualmode: true,
            rendergridrows: function () {
                    return dataAdapter.records;
            },
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Código', datafield: 'codigo', filtertype: 'input',width: '10%' },
			{ text: 'Ubicación', datafield: 'ubicacion', filtertype: 'input',width: '10%' },
			{ text: 'Sector', datafield: 'sector', filtertype: 'input',width: '10%' },
			{ text: 'Tipo', datafield: 'tipo', filtertype: 'input',width: '10%' },
			{ text: 'Tipo1', datafield: 'tipo1', filtertype: 'input',width: '10%' },
			{ text: 'Fecha', datafield: 'fecha', filtertype: 'range', width: '8%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Descripción', datafield: 'descripcion', filtertype: 'input', width: '20%'},
			{ text: 'Concatenación ', datafield: 'descripcion1', filtertype: 'input', width: '20%'},
	        ]
	});

	}
		
 		//$("#jqxgrid").jqxGrid('expandgroup',4);



/*
adicionar 
*/
$("#cargar_csv").click(function(){
	$("#titulo").text("Cargar Archivo CSV");
	// $("#id").val("");
	$('#myModal').modal('show');
});


/*
Eliminar registros 
*/
$("#delete").click(function(){
	$('#myModal_delete').modal('show');
});

/*
Editar
*/

$("#edit").click(function() {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#id").val(dataRecord.id);
		$("#titulo").text("Editar Producto");

		$("#grupo_id").val(dataRecord.grupo_id);
		$("#linea_id").val(dataRecord.linea_id);
		$("#producto").val(dataRecord.producto);
		$("#codigo").val(dataRecord.codigo);
		$("#descripcion").val(dataRecord.descripcion);
		$("#precio_unitario").val(dataRecord.precio_unitario);
		$("#cantidad").val(dataRecord.cantidad);
		$("#tiempo").val(dataRecord.tiempo);
		select_estacion(dataRecord.linea_id,dataRecord.estacion_id);
		$('#myModal').modal('show');
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}

});

$("#testForm_delete").submit(function(){
var v=$.ajax({
   url:'/bases/delete/',
   type:'POST',
   datatype: 'json',
   data:{fecha_inicio:$("#fecha_inicio").val(),fecha_fin:$("#fecha_fin").val()},
   success: function(data) { alert(data); cargar();
                        }, //mostramos el error
                        error: function() { alert('Se ha producido un error Inesperado'); }
                      });

   $('#myModal_delete').modal('hide');
   return false; // ajax used, block the normal submit
 
});


$("#fecha_inicio, #fecha_fin").datepicker({
						autoclose:true,
	});


})