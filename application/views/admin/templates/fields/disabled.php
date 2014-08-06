<div class="form-group <?php echo $name; ?> has-feedback">
	<label class="col-sm-3 control-label"><?php echo $label; ?></label>
	<div class="col-sm-5">
		<input disabled type="text" class="form-control" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<span class="fa <?php echo $icon; ?> form-control-feedback"></span>
	</div>
</div>