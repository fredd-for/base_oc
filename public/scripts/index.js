
$(document).ready(function (){
function cargar (fecha_inicio,fecha_fin,ubicacion,sector,tipo,caracteristica1,caracteristica2,caracteristica3,caracteristica4,caracteristica5,nro_publicaciones) {
	//alert(caracteristica1);
	var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'cantidad',type: 'number'},
			{ name: 'fecha_min',type: 'date'},
			{ name: 'fecha_max',type: 'date'},
			{ name: 'codigo',type: 'string'},
			{ name: 'ubicacion',type: 'string'},
			{ name: 'sector',type: 'string'},
			{ name: 'fecha',type: 'date'},
			{ name: 'tipo',type: 'string'},
			{ name: 'tipo1',type:'string'},
			{ name: 'descripcion',type:'string'},
			{ name: 'descripcion1',type:'string'},
			{ name: 'fecha_registro',type:'date'},
			{ name: 'usuario_registro',type:'number'},
			],
			url: '/bases/listafiltro/'+fecha_inicio+'/'+fecha_fin+'/'+ubicacion+'/'+sector+'/'+tipo+'/'+caracteristica1+'/'+caracteristica2+'/'+caracteristica3+'/'+caracteristica4+'/'+caracteristica5+'/'+nro_publicaciones,
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
			{ text: 'Nro Publicación', datafield: 'cantidad', filtertype: 'filter',width: '10%' },
			{ text: 'Cod. Publicación', datafield: 'codigo', filtertype: 'input',width: '10%' },
			{ text: 'Fecha Minima Publicación', datafield: 'fecha_min', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy ', align:'center'},
			{ text: 'Fecha Maxima Publicación', datafield: 'fecha_max', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Fecha Publicación', datafield: 'fecha', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Descripción', datafield: 'descripcion', filtertype: 'input',width: '42%' },
			],
			// groups: ['razon_social']
		});
}
		
// $("#Save").click(function() {
// 	cargar($("#fecha_inicio").val());
// })
 		//$("#jqxgrid").jqxGrid('expandgroup',4);
 
$("#testForm").submit(function() {
	//alert($("#ubicacion").val());
	var tipo = $("#tipo").val();
	var caracteristica1 = $("#caracteristica1").val();
	var caracteristica2 = $("#caracteristica2").val();
	var caracteristica3 = $("#caracteristica3").val();
	var caracteristica4 = $("#caracteristica4").val();
	var caracteristica5 = $("#caracteristica5").val();
	if(tipo==''){
		tipo = 0;
	}
	if(caracteristica1==''){
		caracteristica1 = 0;
	}
	if(caracteristica2==''){
		caracteristica2 = 0;
	}
	if(caracteristica3==''){
		caracteristica3 = 0;
	}
	if(caracteristica4==''){
		caracteristica4 = 0;
	}
	if(caracteristica5==''){
		caracteristica5 = 0;
	}
	cargar($("#fecha_inicio").val(),$("#fecha_fin").val(),$("#ubicacion").val(),$("#sector").val(),tipo,caracteristica1,caracteristica2,caracteristica3,caracteristica4,caracteristica5,$("#nro_publicaciones").val());
            return false; // ajax used, block the normal submit
});


$("#imprimir").click(function(){
	if ($("#fecha_inicio_habilitado").val()<=$("#fecha_actual").val() && $("#fecha_fin_habilitado").val()>=$("#fecha_actual").val()) {
		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de realizar la impresión?. Se lo cobrara "+$("#cobro_impresion").val() +" Bs. por la impresión", function(result) {
			if (result==true) {
				var tipo = $("#tipo").val();
		var caracteristica1 = $("#caracteristica1").val();
		var caracteristica2 = $("#caracteristica2").val();
		var caracteristica3 = $("#caracteristica3").val();
		var caracteristica4 = $("#caracteristica4").val();
		var caracteristica5 = $("#caracteristica5").val();
		if(tipo==''){
			tipo = 0;
		}
		if(caracteristica1==''){
			caracteristica1 = 0;
		}
		if(caracteristica2==''){
			caracteristica2 = 0;
		}
		if(caracteristica3==''){
			caracteristica3 = 0;
		}
		if(caracteristica4==''){
			caracteristica4 = 0;
		}
		if(caracteristica5==''){
			caracteristica5 = 0;
		}
		window.open('bases/exportar/'+$("#fecha_inicio").val()+'/'+$("#fecha_fin").val()+'/'+$("#ubicacion").val()+'/'+$("#sector").val()+'/'+tipo+'/'+caracteristica1+'/'+caracteristica2+'/'+caracteristica3+'/'+caracteristica4+'/'+caracteristica5+'/'+$("#nro_publicaciones").val(),"_blank");	
			}
		});
		
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Estimado Usuario, solo esta habilitado la impresión hasta el  "+$("#fecha_fin_habilitado").val()+". Comuniquese con el administrador del sistema. ");
	}

	
});


 	$("#fecha_inicio, #fecha_fin").datepicker({
 		autoclose:true,
 	});
 })