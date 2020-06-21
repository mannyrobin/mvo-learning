.fl-node-<?php echo $id; ?> .rp-wrapper {
	background: #<?php echo $settings->bg_color ? $settings->bg_color : 'f4f4f4'?>;
}

.fl-node-<?php echo $id; ?> .rp-wrapper {
	text-align: <?php echo $settings->heading_text_align;?>;
}

.fl-node-<?php echo $id; ?> .rp-wrapper .rp-heading {
	font-size: <?php echo $settings->heading_font_size ? $settings->heading_font_size : 30; ?>px;
	color: #<?php echo $settings->heading_color ? $settings->heading_color : 666; ?>;
}

.fl-node-<?php echo $id; ?> .rp-wrapper .rp-summery {
	font-size: <?php echo $settings->summery_font_size ? $settings->summery_font_size : 16; ?>px;
	text-align: <?php echo $settings->summery_text_align; ?>;
	color: #<?php echo $settings->summery_color ? $settings->summery_color : 666; ?>;
}

.fl-node-<?php echo $id; ?> .rp-wrapper .rp-posts li {
	list-style: inside <?php echo $settings->list_style;?>;
	text-align: <?php echo $settings->list_text_align;?>;
}

.fl-node-<?php echo $id; ?> .rp-wrapper .rp-posts li a {
	font-size: <?php echo $settings->list_font_size ? $settings->list_font_size : 16; ?>px;
<?php echo $settings->list_color ? 'color: #'.$settings->list_color : ''; ?>;
<?php if($settings->layout == "aside"): ?> border-bottom-style: solid;
	border-bottom-width: <?php echo $settings->bottom_border ? $settings->bottom_border : 0;?>px;
	border-bottom-color: #<?php echo $settings->bottom_border_color ? $settings->bottom_border_color : 'fff'; ?>;
<?php endif; ?>
}

<?php if($settings->list_hover_color): ?>
.fl-node-<?php echo $id; ?> .rp-wrapper .rp-posts li a:hover {
	color: #<?php echo $settings->list_hover_color?>;
}

<?php endif; ?>