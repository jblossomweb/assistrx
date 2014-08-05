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
					<i class="fa fa-users"></i>
					<span><?php echo $patient['name'];?></span>
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
				<form id="frmEditPatient" method="post" action="/admin/ajax/patients/edit" class="form-horizontal"></form>
			</div>
		</div>
	</div>
</div>

<script id="patient-form-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/pages/patients/form');?>
</script>
<?php $this->load->view('admin/pages/patients/validate');?>

<script type="text/javascript">
function lockField(name){
	$(":input[name='"+name+"']").prop('disabled', true);
	$("."+name+" label i").removeClass("fa-unlock").addClass("fa-lock");
	$("."+name+" label").addClass("locked").attr('title','unlock');
}
function unlockField(name){
	$(":input[name='"+name+"']").prop('disabled', false);
	$("."+name+" label i").removeClass("fa-lock").addClass("fa-unlock");
	$("."+name+" label").removeClass("locked").attr('title','lock');
}
</script>

<script type="text/javascript">
var form_selector = "#frmEditPatient";
var form_template = "#patient-form-template";
var form_data = {
	  <?php if(!empty($patient['name'])): ?>
	  patient: {
	  	id: "<?php echo $patient['id'];?>",
	  	name: "<?php echo $patient['name'];?>",
	  	age: "<?php echo $patient['age'];?>",
	  	phone: "<?php echo $patient['phone'];?>"
	  }<?php endif;?>
};
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"},
	    	{page: "patients/edit?id=<?php echo $patient['id'];?>", title: "Edit"}
		 ]);
		renderTemplate(form_template,form_selector,form_data);
		$.getScript('/assets/js/admin/guts-form.js', function(){
			loadForm(validatePatient);

			$(".locking label").click(function(){
				var field = $(this).next('div').children(':input').attr('name');
				if($(this).hasClass("locked")){
					unlockField(field);
				} else {
					lockField(field);
				}
			});
			$(".locking label").click();

		});
	});
});
</script>
<?php endif; ?>