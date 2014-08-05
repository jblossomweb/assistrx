function AllTables(){
	TestTable2();
	LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
	$('select').select2();
	$('.dataTables_filter').each(function(){
		$(this).find('label input[type=text]').attr('placeholder', 'Search');
	});
	loadGuts();
}
function deleteRecord(controller,id){
	if(confirm("Are you sure?")){
		$.post( "/admin/ajax/"+controller+"/delete", { id: id }, function( data ) {
			console.log(data);
			if(data.deleted && id == data.id){
				$("#"+controller+"_"+id).hide("fast").remove();
				//todo: LoadDataTablesScripts(AllTables);
			}
		}, "json");
	}
}