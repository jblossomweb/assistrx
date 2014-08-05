<div class="form-group locking <?php echo $name; ?> has-feedback">
	<label class="col-sm-3 control-label"><i class="fa fa-unlock"></i>&nbsp;<?php echo $label; ?></label>
	<div class="col-sm-5">
		<input type="number" class="form-control" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<span class="fa <?php echo $icon; ?> form-control-feedback"></span>
	</div>
</div>