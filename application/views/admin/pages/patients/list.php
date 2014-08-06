<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>
<div class="row" id="guts" style="display:none;">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span>Patient Listing</span>
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

			<div class="box-content no-padding table-responsive">
				<table class="table patients table-bordered table-striped table-hover table-heading table-datatable" id="datatable-2">
					<thead>
						<tr>
							<th><label><input type="text" name="search_name" value="name" class="search_init" /></label></th>
							<th><label><input type="text" name="search_age" value="age" class="search_init" /></label></th>
							<th><label><input type="text" name="search_phone" value="phone" class="search_init" /></label></th>
							<th><label><input type="text" name="search_has_song" value="has song" class="search_init" /></label></th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($patients as $patient): ?>
						<tr id="patients_<?php echo $patient['id']; ?>" class="patient">
							<td><i class="fa fa-user"></i>&nbsp;<?php echo $patient['name']; ?></td>
							<td><?php echo $patient['age']; ?></td>
							<td><i class="fa fa-phone"></i>&nbsp;<?php echo $patient['phone']; ?></td>
							<td>
								<?php if(intval($patient['song_id']) > 0): ?>
									<span style="display:none">1 yes true <?php echo $patient['song_id']; ?></span><i class="fa fa-check" style="color:green;"></i>
								<?php else: ?>
									<span style="display:none">0 no false</span><i class="fa fa-times" style="color:red;"></i>
								<?php endif;?>
							</td>
							<td>
								<a alt="edit" title="edit" style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/patients/edit?id=<?php echo $patient['id']; ?>');"><i class="fa fa-edit"></i></a>
								&nbsp;&nbsp;
								<a alt="song" title="song" style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/patients/song?id=<?php echo $patient['id']; ?>');"><i class="fa fa-music"></i></a>
								<?php /*
								&nbsp;&nbsp;
								<a style="cursor:pointer;" onclick="deleteRecord('patients',<?php echo $patient['id']; ?>);"><i class="fa fa-times"></i></a>
								*/ ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"><a class="btn btn-primary btn-large" style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/patients/add');"><i class="fa fa-plus"></i> Add New</a></td>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>
	</div>
</div>

<div style="height: 40px;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"}
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
