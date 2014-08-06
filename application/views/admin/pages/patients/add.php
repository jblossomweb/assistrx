<?php if(!$form):?>
<?php echo $return; ?>
<?php else: ?>
<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-user"></i>
					<span>Add New Patient</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<form id="frmAddPatient" method="post" action="/admin/ajax/patients/add" class="form-horizontal"></form>
			</div>
		</div>
	</div>
</div>

<script id="patient-form-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/pages/patients/form');?>
</script>
<?php $this->load->view('admin/pages/patients/validate');?>

<script type="text/javascript">
var form_selector = "#frmAddPatient";
var form_template = "#patient-form-template";
var form_data = {
	  <?php if(!empty($patient['name'])): ?>,
	  patient: {
	  	name: "<?php echo $patient['name'];?>"
	  }<?php endif;?>
};
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"},
	    	{page: "patients/add", title: "Add New"}
		 ]);
		renderTemplate(form_template,form_selector,form_data);
		$.getScript('/assets/js/admin/guts-form.js', function(){
			loadForm(validatePatient);
		});
	});
});
</script>
<?php endif; ?>