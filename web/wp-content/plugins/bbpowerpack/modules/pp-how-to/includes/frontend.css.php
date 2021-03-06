<?php
	// Box - Border
	FLBuilderCSS::border_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'box_border',
			'selector'     => ".fl-node-$id .pp-how-to-container",
		)
	);
	// Box - Padding
	FLBuilderCSS::dimension_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'box_padding',
			'selector'     => ".fl-node-$id .pp-how-to-container",
			'unit'         => 'px',
			'props'        => array(
				'padding-top'    => 'box_padding_top',
				'padding-right'  => 'box_padding_right',
				'padding-bottom' => 'box_padding_bottom',
				'padding-left'   => 'box_padding_left',
			),
		)
	);
	// Title - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'title_typography',
			'selector'     => ".fl-node-$id .pp-how-to-title",
		)
	);
	// Description - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'description_typography',
			'selector'     => ".fl-node-$id .pp-how-to-description p, .fl-node-$id .pp-how-to-description a",
		)
	);
	?>
.fl-node-<?php echo $id; ?> .pp-how-to-container {
	<?php if ( isset( $settings->box_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->box_bg_color ); ?>;
	<?php } ?>
	text-align: <?php echo $settings->box_align; ?>;
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-title {
	<?php if ( isset( $settings->title_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->title_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->title_margin ) ) { ?>
		margin-bottom: <?php echo $settings->title_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-description {
	<?php if ( isset( $settings->description_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->description_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->description_margin ) ) { ?>
		margin-bottom: <?php echo $settings->description_margin; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-image {
	text-align: <?php echo $settings->image_align; ?>;
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-image img {
	<?php if ( isset( $settings->image_width ) ) { ?>
		width: <?php echo $settings->image_width . $settings->image_width_unit; ?>;
	<?php } ?>
}

<?php
	// Image - Border
	FLBuilderCSS::border_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'image_border',
			'selector'     => ".fl-node-$id .pp-how-to-image img",
		)
	);

	// Image - Padding
	FLBuilderCSS::dimension_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'image_padding',
			'selector'     => ".fl-node-$id .pp-how-to-image",
			'unit'         => 'px',
			'props'        => array(
				'padding-top'    => 'image_padding_top',
				'padding-right'  => 'image_padding_right',
				'padding-bottom' => 'image_padding_bottom',
				'padding-left'   => 'image_padding_left',
			),
		)
	);
	// Total Time - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'total_time_typography',
			'selector'     => ".fl-node-$id .pp-how-to-total-time",
		)
	);
	// Estimated Cost - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'estimated_cost_typography',
			'selector'     => ".fl-node-$id .pp-how-to-estimated-cost",
		)
	);
	// Supply Title - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'supply_title_typography',
			'selector'     => ".fl-node-$id .pp-how-to-supply-title",
		)
	);
	// Supply Text - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'supply_text_typography',
			'selector'     => ".fl-node-$id .pp-supply",
		)
	);
	// Tool Title - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'tool_title_typography',
			'selector'     => ".fl-node-$id .pp-how-to-tool-title",
		)
	);
	// Tool Text - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'tool_text_typography',
			'selector'     => ".fl-node-$id .pp-tool",
		)
	);
	?>

.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-total-time {
	<?php if ( isset( $settings->total_time_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->total_time_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->total_time_margin ) ) { ?>
		margin-bottom: <?php echo $settings->total_time_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-estimated-cost {
	<?php if ( isset( $settings->estimated_cost_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->estimated_cost_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->estimated_cost_margin ) ) { ?>
		margin-bottom: <?php echo $settings->estimated_cost_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-supply {
	<?php if ( isset( $settings->supply_box_margin ) ) { ?>
		margin-bottom: <?php echo $settings->supply_box_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-supply-title {
	<?php if ( isset( $settings->supply_title_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->supply_title_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->supply_title_margin ) ) { ?>
		margin-bottom: <?php echo $settings->supply_title_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-supply {
	<?php if ( isset( $settings->supply_text_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->supply_text_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-supply:not(:last-child) {
	<?php if ( isset( $settings->supply_text_margin ) ) { ?>
		margin-bottom: <?php echo $settings->supply_text_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-supply .pp-supply-icon {
	margin-right: <?php echo $settings->supply_icon_space; ?>px;
	font-size: <?php echo $settings->supply_icon_size; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-tool {
	<?php if ( isset( $settings->tool_box_margin ) ) { ?>
		margin-bottom: <?php echo $settings->tool_box_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-tool-title {
	<?php if ( isset( $settings->tool_title_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->tool_title_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->tool_title_margin ) ) { ?>
		margin-bottom: <?php echo $settings->tool_title_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-tool {
	<?php if ( isset( $settings->tool_text_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->tool_text_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-tool:not(:last-child) {
	<?php if ( isset( $settings->tool_text_margin ) ) { ?>
		margin-bottom: <?php echo $settings->tool_text_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-tool .pp-tool-icon {
	margin-right: <?php echo $settings->tool_icon_space; ?>px;
	font-size: <?php echo $settings->tool_icon_size; ?>px;
}
<?php
	// Step Section Title - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'step_section_title_typography',
			'selector'     => ".fl-node-$id .pp-how-to-step-section-title",
		)
	);
	// Step Title - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'step_title_typography',
			'selector'     => ".fl-node-$id .pp-how-to-step-title",
		)
	);
	// Step Description - Typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'step_description_typography',
			'selector'     => ".fl-node-$id .pp-how-to-step-description",
		)
	);
	?>
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step {
	<?php if ( isset( $settings->steps_spacing ) ) { ?>
		margin-bottom: <?php echo $settings->steps_spacing; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-steps .pp-how-to-step-section-title {
	<?php if ( isset( $settings->step_section_title_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->step_section_title_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->step_section_title_margin ) ) { ?>
		margin-bottom: <?php echo $settings->step_section_title_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-no-img .pp-how-to-step-content {
	width: 100%;
}
<?php if ( 'top' === $settings->step_img_position ) { ?>
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-top {
		flex-direction: column-reverse;
		align-items: <?php echo $settings->step_align_horizontal; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-top .pp-how-to-step-image {
		width: <?php echo $settings->step_image_width; ?>%;
		margin-bottom: <?php echo $settings->step_image_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
		width: 100%;
	}
<?php } elseif ( 'bottom' === $settings->step_img_position ) { ?>
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-bottom {
		flex-direction: column;
		align-items: <?php echo $settings->step_align_horizontal; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-bottom .pp-how-to-step-image {
		width: <?php echo $settings->step_image_width; ?>%;
		margin-top: <?php echo $settings->step_image_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
		width: 100%;
	}
<?php } elseif ( 'left' === $settings->step_img_position ) { ?>
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-left {
		flex-direction: row-reverse;
		align-items: <?php echo $settings->step_align_vertical; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-left .pp-how-to-step-image {
		width: <?php echo $settings->step_image_width; ?>%;
		margin-right: <?php echo $settings->step_image_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
		width: <?php echo '100' - ( isset( $settings->step_image_width ) ? $settings->step_image_width : '0' ); ?>%;
	}
<?php } elseif ( 'right' === $settings->step_img_position ) { ?>
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-right {
		flex-direction: row;
		align-items: <?php echo $settings->step_align_vertical; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img.pp-step-img-right .pp-how-to-step-image {
		width: <?php echo $settings->step_image_width; ?>%;
		margin-left: <?php echo $settings->step_image_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
		width: <?php echo '100' - ( isset( $settings->step_image_width ) ? $settings->step_image_width : '0' ); ?>%;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step .pp-how-to-step-title {
	<?php if ( isset( $settings->step_title_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->step_title_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->step_title_margin ) ) { ?>
		margin-bottom: <?php echo $settings->step_title_margin; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step .pp-how-to-step-description {
	<?php if ( isset( $settings->step_description_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->step_description_color ); ?>;
	<?php } ?>
}


@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	<?php if ( 'top' === $settings->step_img_position_responsive ) { ?>
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img {
			flex-direction: column-reverse !important;
			align-items: <?php echo $settings->step_align_responsive; ?> !important;
		}
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-image {
			width: <?php echo $settings->step_image_width_responsive; ?>% !important;
			margin-bottom: <?php echo $settings->step_image_spacing_responsive; ?>px !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
			width: 100% !important;
		}
	<?php } elseif ( 'bottom' === $settings->step_img_position_responsive ) { ?>
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img {
			flex-direction: column !important;
			align-items: <?php echo $settings->step_align_responsive; ?> !important;
		}
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-image {
			width: <?php echo $settings->step_image_width_responsive; ?>% !important;
			margin-top: <?php echo $settings->step_image_spacing_responsive; ?>px !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		.fl-node-<?php echo $id; ?> .pp-how-to-container .pp-how-to-step.pp-has-img .pp-how-to-step-content {
			width: 100% !important;
		}
	<?php } ?>
}
