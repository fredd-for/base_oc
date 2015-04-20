
$(document).ready(function (){

cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'username',type: 'string'},
			{ name: 'password',type: 'string'},
			{ name: 'nombre',type: 'string'},
			{ name: 'mosca',type: 'string'},
			{ name: 'cargo',type: 'string'},
			{ name: 'email',type: 'string'},
			{ name: 'fecha_creacion',type: 'date'},
			{ name: 'nivel',type:'number'},
			{ name: 'cedula_identidad',type:'number'},
			{ name: 'expedido',type:'string'},
			{ name: 'paterno',type:'string'},
			{ name: 'materno',type:'string'},
			{ name: 'nombre_completo',type:'string'},
			{ name: 'ci_texto',type:'string'},
			{ name: 'telefono',type:'number'},
			{ name: 'celular',type:'number'},
			{ name: 'habilitado'},
			],
			url: '/usuarios/list/',
			cache: false
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
            groupable: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Nombre Completo', datafield: 'nombre_completo', filtertype: 'filter',width: '15%' },
			{ text: 'Cedula Identidad', datafield: 'ci_texto', filtertype: 'input',width: '8%' },
			{ text: 'Correo Electronico', datafield: 'email', filtertype: 'input',width: '15%' },
			{ text: 'Ocupación', datafield: 'cargo', filtertype: 'input',width: '15%' },
			{ text: 'Usuario', datafield: 'username', filtertype: 'input',width: '10%' },
			{ text: 'Fecha Creación', datafield: 'fecha_creacion', filtertype: 'range', width: '8%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Telefono', datafield: 'telefono', filtertype: 'number', width: '10%',cellsalign: 'right'},
			{ text: 'Celular', datafield: 'celular', filtertype: 'number', width: '10%',cellsalign: 'right'},
			{ text: 'Estado', datafield: 'habilitado', filtertype: 'number', width: '5%',cellsalign: 'right'},
	        ]
	});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}


/*
adicionar 
*/
$("#add").click(function(){
	$("#titulo").text("Adicionar Usuario");
	$("#id").val("");
	$('#myModal').modal('show');
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

/*
Eliminar
*/
$("#delete").click(function() {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		//$("#id").val(dataRecord.id);
 		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
 			if (result == true) {
 				var v = $.ajax({
 					url: '/productos/delete/',
 					type: 'POST',
 					datatype: 'json',
 					data: {id: dataRecord.id},
 					success: function(data) {
                            cargar(); //alert('Guardado Correctamente'); 
                            $("#divMsjeExito").show();
                            $("#divMsjeExito").addClass('alert alert-warning alert-dismissable');
                            $("#aMsjeExito").html(data); 
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