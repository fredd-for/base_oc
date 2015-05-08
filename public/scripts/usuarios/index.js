
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
			{ name: 'paterno',type:'string'},
			{ name: 'materno',type:'string'},
			{ name: 'nombre_completo',type: 'string'},
			{ name: 'email',type: 'string'},
			{ name: 'fecha_creacion',type: 'date'},
			{ name: 'nivel',type:'number'},
			{ name: 'cedula_identidad',type:'number'},
			{ name: 'expedido',type:'string'},
			{ name: 'ci_texto',type:'string'},
			{ name: 'telefono',type:'number'},
			{ name: 'celular',type:'number'},
			{ name: 'direccion',type:'string'},
			{ name: 'habilitado',type:'number'},
			{ name: 'habilitado_text',type:'string'},
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
			{ text: 'Nombre Completo', datafield: 'nombre_completo', filtertype: 'filter',width: '17%' },
			{ text: 'Cedula Identidad', datafield: 'ci_texto', filtertype: 'input',width: '8%' },
			{ text: 'Correo Electronico', datafield: 'email', filtertype: 'input',width: '17%' },
			{ text: 'Usuario', datafield: 'username', filtertype: 'input',width: '10%' },
			{ text: 'Telefono', datafield: 'telefono', filtertype: 'number', width: '10%',cellsalign: 'right'},
			{ text: 'Celular', datafield: 'celular', filtertype: 'number', width: '10%',cellsalign: 'right'},
			{ text: 'Dirección', datafield: 'direccion', filtertype: 'number', width: '15%',cellsalign: 'right'},
			{ text: 'Estado', datafield: 'habilitado_text', filtertype: 'number', width: '10%',cellsalign: 'right'},
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
	$("#nivel").val("");
	$("#nombre").val("");
	$("#paterno").val("");
	$("#materno").val("");
	$("#cedula_identidad").val("");
	$("#expedido").val("");
	$("#email").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#habilitado").val("");
	$("#direccion").val("");
	$("#habilitado").val("");
	$(".ocultar").show();
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
		$("#titulo").text("Editar Usuario");
		$(".ocultar").hide();
		$("#id").val(dataRecord.id);
		$("#nivel").val(dataRecord.nivel);
		$("#nombre").val(dataRecord.nombre);
		$("#paterno").val(dataRecord.paterno);
		$("#materno").val(dataRecord.materno);
		$("#cedula_identidad").val(dataRecord.cedula_identidad);
		$("#expedido").val(dataRecord.expedido);
		$("#email").val(dataRecord.email);
		$("#telefono").val(dataRecord.telefono);
		$("#celular").val(dataRecord.celular);
		$("#habilitado").val(dataRecord.habilitado);
		$("#direccion").val(dataRecord.direccion);
		$("#habilitado").val(dataRecord.habilitado);
		$('#myModal').modal('show');
		// alert(dataRecord.habilitado);
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

/*
guardar 
 */
$("#testForm").submit(function() {
	//alert($("#habilitado").val());
	var v=$.ajax({
            	url:'/usuarios/save/',
            	type:'POST',
            	datatype: 'json',
            	data:{id:$("#id").val(),nombre:$("#nombre").val(),paterno:$("#paterno").val(),materno:$("#materno").val(),cedula_identidad:$("#cedula_identidad").val(),expedido:$("#expedido").val(),email:$("#email").val(),telefono:$("#telefono").val(),celular:$("#celular").val(),direccion:$("#direccion").val(),habilitado:$("#habilitado").val(),username:$("#username").val(),password:$("#password").val(),nivel:$("#nivel").val()},
				success: function(data) { cargar(); 
					$("#divMsjeExito").show();
                    $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    $("#aMsjeExito").html(data); 
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});
            $('#myModal').modal('hide');
            return false; // ajax used, block the normal submit
});


})