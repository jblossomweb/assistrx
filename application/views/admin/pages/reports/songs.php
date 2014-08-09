<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>
<div class="row" id="guts" style="display:none;">
	songs.php
</div>
<div style="height: 40px;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "reports", title: "Reports"},
		    {page: "reports/songs", title: "Chosen Songs"}
		 ]);
		$.getScript('/assets/js/admin/guts-list.js', function(){
			// Load Datatables and run plugin on tables 
			LoadDataTablesScripts(AllTables);
			// Add Drag-n-Drop feature
			WinMove();
		});
	});		
});
</script>