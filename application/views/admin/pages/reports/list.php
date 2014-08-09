<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>
<div id="guts" class="row dashboard-header" style="display:none;">
	<div class="col-xs-12 col-sm-12 dashboard-row">
		<h3>Reports</h3>
	</div>
	<div class="col-xs-12 col-sm-12 dashboard-row">
		<?php foreach($reports as $report): ?>
		<div class="btn btn-primary btn-app" 
			onClick="LoadAjaxContent('/admin/ajax/reports/<?php echo $report['name'];?>');">
			<i class="fa <?php echo $report['icon'];?>"></i>
			<span class="font-myriad"><?php echo $report['title'];?></span>
		</div>
		<?php endforeach;?>
	</div>
</div>
<div style="height: 40px;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "reports", title: "Reports"}
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