.fl-node-<?php echo $id; ?> .bbvl-preview-wrap .bbvl-preview-icon {
	background: <?php echo $module->getColor($settings->icon_bg) ?>;
	color: <?php echo $module->getColor($settings->icon_color) ?>;
	box-shadow: 0 0 29px 0 <?php echo $module->getColor($settings->icon_bg) ?>;
	<?php if ( 'on' == $settings->pulse ): ?>
		animation: play-icon-fade-in 2s ease-in-out infinite alternate;
	<?php endif; ?>
}
.fl-node-<?php echo $id; ?> .bbvl-preview-wrap:hover .bbvl-preview-icon {
	background: <?php echo $module->getColor($settings->icon_hover_bg) ?>;
	color: <?php echo $module->getColor($settings->icon_hover_color) ?>;
}
.fl-node-<?php echo $id; ?> .bbvl-preview-wrap .bbvl-preview-image:after {
	background: <?php echo $module->getColor($settings->overlay_color) ?>;
}
.fl-node-<?php echo $id; ?> .bbvl-preview-wrap:hover .bbvl-preview-image:after {
	background: <?php echo $module->getColor($settings->overlay_hover) ?>;
}

.mfp-wrap.mfp-<?php echo $id ?> .mfp-content button.mfp-close {
	position: absolute;
	text-align:center;
	padding: 0;
	width: 44px;
	height: 44px;
	background: <?php echo $module->getColor($settings->close_bg) ?> !important;
	<?php if ( 'top_out_right' == $settings->close_pos ) {
		echo 'right: 0px;';
		echo 'top: -45px !important;';
	} elseif ( 'bottom_out_right' == $settings->close_pos ) {
		echo 'right: 0px;';
		echo 'bottom: -45px !important;';
	} elseif ( 'top_out_left' == $settings->close_pos ) {
		echo 'left: 0px;';
		echo 'top: -45px !important;';
	} elseif ( 'bottom_out_left' == $settings->close_pos ) {
		echo 'left: 0px;';
		echo 'bottom: -45px !important;';
	} elseif ( 'top_in_right' == $settings->close_pos ) {
		echo 'right: 0px;';
		echo 'top: 0px !important;';
	} elseif ( 'bottom_in_right' == $settings->close_pos ) {
		echo 'right: 0px;';
		echo 'bottom: 0px !important;';
	} elseif ( 'top_in_left' == $settings->close_pos ) {
		echo 'left: 0px;';
		echo 'top: 0px !important;';
	} elseif ( 'bottom_in_left' == $settings->close_pos ) {
		echo 'left: 0px;';
		echo 'bottom: 0px !important;';
	} ?>
}

.mfp-wrap.mfp-<?php echo $id ?> .mfp-content button.mfp-close:hover {
	background: <?php echo $module->getColor($settings->close_hover_bg) ?> !important;
}
