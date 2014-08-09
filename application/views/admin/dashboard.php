<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<!--Start Dashboard 1-->
<div id="dashboard-header" class="row dashboard-header">
	<div class="col-xs-12 col-sm-12 dashboard-row">
		<h3>Hello, <?php echo $admin_fname.' '.$admin_lname; ?>!</h3>
	</div>
	<div class="col-xs-12 col-sm-12 dashboard-row">
		<div class="btn btn-primary btn-app" 
		onClick="LoadAjaxContent('/admin/ajax/patients');">
			<i class="fa fa-users"></i>
			<span class="font-myriad">Patients</span>
		</div>
		<div class="btn btn-primary btn-app" 
		onClick="LoadAjaxContent('/admin/ajax/reports');">
			<i class="fa fa-file-text-o"></i>
			<span class="font-myriad">Reports</span>
		</div>
	</div>
</div>
<!--End Dashboard 1-->
<div style="height: 40px;"></div>
<script src="../assets/js/admin/dashboard.js"></script>
