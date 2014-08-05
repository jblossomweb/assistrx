function loadForm(validator){
	// Initialize datepicker
	$('.datepicker').datepicker({setDate: new Date()});
	
	LoadSelect2Script(function(){
		$('select.select2').select2();
	});

	// Add tooltip to form-controls
	$('.form-control').tooltip();
	// Load example of form validation
	LoadBootstrapValidatorScript(validator);
	// Add drag-n-drop feature to boxes
	WinMove();
}