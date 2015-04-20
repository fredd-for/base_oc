
$(document).ready(function (){

	//cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'cliente_id',type: 'number'},
			{ name: 'contrato',type: 'string'},
			{ name: 'fecha_contrato',type: 'date'},
			{ name: 'descripcion',type: 'string'},
			{ name: 'monto_total',type: 'number'},
			{ name: 'monto_cancelado',type: 'number'},
			{ name: 'monto_cobrar',type:'number'},
			{ name: 'fecha_pago',type:'date'},
			{ name: 'dias_atraso',type:'number'},
			{ name: 'mora',type:'number'},
			],
			url: '/index/list/',
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
			{ text: 'Nro Publicación', datafield: 'razon_social', filtertype: 'filter',width: '10%' },
			{ text: 'Cod. Publicación', datafield: 'contrato', filtertype: 'input',width: '10%' },
			{ text: 'Fecha Minima Publicación', datafield: 'fecha_contrato', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Fecha Maxima Publicación', datafield: 'fecha_pago', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Fecha Publicación', datafield: 'monto_total', filtertype: 'range', width: '12%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Descripción', datafield: 'descripcion', filtertype: 'input',width: '42%' },
			],
			// groups: ['razon_social']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
 	}

 	$("#fecha_inicio, #fecha_fin").datepicker({
 		autoclose:true,
 	});
 })