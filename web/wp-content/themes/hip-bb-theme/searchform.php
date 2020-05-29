<?php
/**
 * Template for displaying search forms
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" class="field" name="s" id="s" placeholder="Search..." />		
	<button type="submit" class="submit" name="submit" id="searchsubmit">
		<i class="fa fa-search"></i>
	</button>
</form>
