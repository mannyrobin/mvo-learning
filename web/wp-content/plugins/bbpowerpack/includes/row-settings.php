<?php

function pp_row_register_settings( $extensions ) {

    // if ( array_key_exists( 'gradient', $extensions['row'] ) || in_array( 'gradient', $extensions['row'] ) ) {
    //     add_filter( 'fl_builder_register_settings_form', 'pp_row_gradient', 10, 2 );
    // }
    if ( array_key_exists( 'overlay', $extensions['row'] ) || in_array( 'overlay', $extensions['row'] ) ) {
        add_filter( 'fl_builder_register_settings_form', 'pp_row_overlay', 10, 2 );
	}
	
	if ( ( array_key_exists( 'separators', $extensions['row'] ) || in_array( 'separators', $extensions['row'] ) )
		|| ( array_key_exists( 'expandable', $extensions['row'] ) || in_array( 'expandable', $extensions['row'] ) )
		|| ( array_key_exists( 'downarrow', $extensions['row'] ) || in_array( 'downarrow', $extensions['row'] ) ) )
	{
		add_filter( 'fl_builder_register_settings_form', 'pp_row_settings_tab', 10, 2 );
    }
	
	if ( array_key_exists( 'separators', $extensions['row'] ) || in_array( 'separators', $extensions['row'] ) ) {
		add_filter( 'pp_row_settings_tab_sections', 'pp_row_separators' );
	}
	if ( array_key_exists( 'expandable', $extensions['row'] ) || in_array( 'expandable', $extensions['row'] ) ) {
		add_filter( 'pp_row_settings_tab_sections', 'pp_row_expandable' );
	}
	if ( array_key_exists( 'downarrow', $extensions['row'] ) || in_array( 'downarrow', $extensions['row'] ) ) {
		add_filter( 'pp_row_settings_tab_sections', 'pp_row_downarrow' );
	}
}

function pp_row_fallback_settings( $nodes ) {
	// Loop through the nodes.
	foreach ( $nodes as $node_id => $node ) {
		// Update row settings.
		if ( 'row' === $node->type ) {
			// Gradient Background Color.
			if ( isset( $node->settings->bg_type ) && 'pp_gradient' == $node->settings->bg_type ) {
				if ( isset( $node->settings->bg_gradient ) ) {
					$gradient = array(
						'type'	=> 'linear',
						'stops'	=> array(0, 100),
						'position'	=> 'center top'
					);
					// Check gradient type.
					if ( isset( $node->settings->gradient_type ) ) {
						$gradient['type'] = $node->settings->gradient_type;
					}
					// Check gradient color.
					if ( isset( $node->settings->gradient_color ) && is_array( $node->settings->gradient_color ) ) {
						$gradient['colors'][0] = ( isset( $node->settings->gradient_color['primary'] ) ) ? $node->settings->gradient_color['primary'] : '';
						$gradient['colors'][1] = ( isset( $node->settings->gradient_color['secondary'] ) ) ? $node->settings->gradient_color['secondary'] : '';
					}
					// Check gradient direction.
					if ( 'linear' == $gradient['type'] && isset( $node->settings->linear_direction ) ) {
						$direction = $node->settings->linear_direction;
						$angle = 90;
						// Top to Bottom.
						if ( 'bottom' == $direction ) {
							$angle = 180;
						}
						// Left to Right.
						if ( 'right' == $direction ) {
							$angle = 90;
						}
						// Bottom Left to Top Right.
						if ( 'top_right_diagonal' == $direction ) {
							$angle = 45;
						}
						// Bottom Right to Top Left.
						if ( 'top_left_diagonal' == $direction ) {
							$angle = 315;
						}
						// Top Left to Bottom Right.
						if ( 'bottom_right_diagonal' == $direction ) {
							$angle = 135;
						}
						// Top Right to Bottom Left.
						if ( 'bottom_left_diagonal' == $direction ) {
							$angle = 225;
						}
						$gradient['angle'] = $angle;
					}

					$node->settings->bg_type = 'gradient';
					$node->settings->bg_gradient = $gradient;
				}
			}

			// Check for the old setting to update.
			if ( isset( $node->settings->pp_bg_overlay_type ) ) {
				// Check for PP gradient setting and assign the values to
				// BB's gradient overlay field.
				if ( 'gradient' === $node->settings->pp_bg_overlay_type ) {
					// Assign overlay type gradient.
					if ( isset( $node->settings->bg_overlay_type ) ) {
						$node->settings->bg_overlay_type = 'gradient';
					}
					// Assign PP's gradient field values to BB's gradient field.
					if ( isset( $node->settings->bg_overlay_gradient ) ) {
						$gradient = array(
							'type'	=> 'linear',
							'stops'	=> array(0, 100)
						);
						// Color 1 - "Overlay Color" - This is BB's field that we had used for Color 1.
						if ( isset( $node->settings->bg_overlay_color ) ) {
							$gradient['colors'][0] = $node->settings->bg_overlay_color;
						}
						// Color 2 - "Overlay Color 2" - This was PP's field used for Color 2.
						if ( isset( $node->settings->pp_bg_overlay_color_2 ) ) {
							$color_2 = $node->settings->pp_bg_overlay_color_2;
							if ( isset( $node->settings->bg_overlay_opacity ) ) {
								$opacity = ! empty( $node->settings->bg_overlay_opacity ) ? ( $node->settings->bg_overlay_opacity / 100 ) : 1;
								$color_2 = pp_hex2rgba( $color_2, $opacity );
							}
							// Parse opacity from Color 1 in case bg_overlay_opacity is not available.
							elseif ( isset( $node->settings->bg_overlay_color ) && ! empty( $node->settings->bg_overlay_color ) ) {
								$color_1 = $node->settings->bg_overlay_color;
								if ( false !== strpos( $color_1, 'rgba' ) ) {
									$color_1_value = str_replace( 'rgba(', '', $color_1 );
									$color_1_value = str_replace( ')', '', $color_1 );
									$color_1_opacity = explode( ',', $color_1_value );
									$color_2 = pp_hex2rgba( $color_2, trim( $color_1_opacity[3] ) );
								}
							}
							$gradient['colors'][1] = $color_2;
						}
						// PP's Gradient Direction.
						if ( isset( $node->settings->pp_bg_overlay_direction ) ) {
							$direction = $node->settings->pp_bg_overlay_direction;
							$angle = 90;
							// Top to Bottom.
							if ( 'bottom' == $direction ) {
								$angle = 180;
							}
							// Left to Right.
							if ( 'right' == $direction ) {
								$angle = 90;
							}
							// Bottom Left to Top Right.
							if ( 'top_right_diagonal' == $direction ) {
								$angle = 45;
							}
							// Bottom Right to Top Left.
							if ( 'top_left_diagonal' == $direction ) {
								$angle = 315;
							}
							// Top Left to Bottom Right.
							if ( 'bottom_right_diagonal' == $direction ) {
								$angle = 135;
							}
							// Top Right to Bottom Left.
							if ( 'bottom_left_diagonal' == $direction ) {
								$angle = 225;
							}
							$gradient['angle'] = $angle;
						}

						$node->settings->bg_overlay_gradient = $gradient;
					}

					unset( $node->settings->pp_bg_overlay_type );
				}
				// Change an old setting to a new setting.
				//$node->settings->new_setting = $node->settings->old_setting;
				// Make sure to unset the old setting so this doesn't run again.
				//unset( $node->settings->old_setting );
			}
			// Save the update settings.
			$nodes[ $node_id ]->settings = $node->settings;
		}
	}

	return $nodes;
}
add_filter( 'fl_builder_get_layout_metadata', 'pp_row_fallback_settings' );


/** Gradient */
function pp_row_gradient( $form, $id ) {

    if ( 'row' != $id ) {
        return $form;
    }

    //$border_section = $form['tabs']['style']['sections']['border'];
    //unset( $form['tabs']['style']['sections']['border'] );

    $form['tabs']['style']['sections']['background']['fields']['bg_type']['options']['pp_gradient'] = __('Gradient', 'bb-powerpack');
    $form['tabs']['style']['sections']['background']['fields']['bg_type']['toggle']['pp_gradient'] = array(
        'sections'  => array('pp_row_gradient')
    );
    $form['tabs']['style']['sections']['pp_row_gradient'] = array(
        'title'     => __('Gradient', 'bb-powerpack'),
        'fields'    => array(
            'gradient_type' => array(
                'type'      => 'pp-switch',
                'label'     => __('Gradient Type', 'bb-powerpack'),
                'default'   => 'linear',
                'options'   => array(
                    'linear'    => __('Linear', 'bb-powerpack'),
                    'radial'    => __('Radial', 'bb-powerpack'),
                ),
                'toggle'    => array(
                    'linear'    => array(
                        'fields'    => array('linear_direction')
                    ),
                ),
            ),
            'gradient_color'    => array(
                'type'      => 'pp-color',
                'label'     => __('Colors', 'bb-powerpack'),
                'show_reset'    => true,
                'default'   => array(
                    'primary'   => 'd81660',
                    'secondary' => '7d22bd',
                ),
                'options'   => array(
                    'primary'   => __('Primary', 'bb-powerpack'),
                    'secondary'   => __('Secondary', 'bb-powerpack'),
                ),
            ),
            'linear_direction'  => array(
                'type'      => 'select',
                'label'     => __('Gradient Direction', 'bb-powerpack'),
                'default'   => 'bottom',
                'options'   => array(
                    'bottom' => __('Top to Bottom', 'bb-powerpack'),
                    'right' => __('Left to Right', 'bb-powerpack'),
                    'top_right_diagonal' => __('Bottom Left to Top Right', 'bb-powerpack'),
                    'top_left_diagonal' => __('Bottom Right to Top Left', 'bb-powerpack'),
                    'bottom_right_diagonal' => __('Top Left to Bottom Right', 'bb-powerpack'),
                    'bottom_left_diagonal' => __('Top Right to Bottom Left', 'bb-powerpack'),
                ),
            ),
        )
    );

    //$form['tabs']['style']['sections']['border'] = $border_section;

    return $form;
}

/** Background overlay */
function pp_row_overlay( $form, $id ) {

    if ( 'row' != $id ) {
        return $form;
    }

	$bg_overlay_color = $form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_color'];
	$bg_overlay_opacity = false;
	if ( isset( $form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_opacity'] ) ) {
		$bg_overlay_opacity = $form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_opacity'];
	}

	unset($form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_color']);
	
	if ( $bg_overlay_opacity ) {
		unset($form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_opacity']);
	}

	if ( isset( $form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_type'] ) ) {
		$form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_type']['toggle']['color']['fields'][] = 'pp_bg_overlay_type';
	}

    $form['tabs']['style']['sections']['bg_overlay']['fields']['pp_bg_overlay_type'] = array(
        'type'      => 'select',
        'label'     => sprintf(__('Overlay Style (%s)', 'bb-powerpack'), pp_get_admin_label()),
        'default'   => 'full_width',
        'options'   => array(
            'full_width'    => __('Full', 'bb-powerpack'),
            'half_width'    => __('Half Overlay - Left', 'bb-powerpack'),
            'half_right'    => __('Half Overlay - Right', 'bb-powerpack'),
            'vertical_left' => __('Vertical Angled Left*', 'bb-powerpack'),
            'vertical_right' => __('Vertical Angled Right*', 'bb-powerpack'),
            //'gradient'      => __('Gradient', 'bb-powerpack')
        ),
        'toggle'    => array(
            'gradient'  => array(
                'fields'    => array('pp_bg_overlay_color_2', 'pp_bg_overlay_direction')
            )
		),
		'help'	=> __('* Vertical Angled Left and Vertical Angled Right will not work with Gradient overlay.', 'bb-powerpack')
    );

    $form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_color'] = $bg_overlay_color;

    // $form['tabs']['style']['sections']['bg_overlay']['fields']['pp_bg_overlay_color_2'] = array(
    //     'type'                      => 'color',
    //     'label'                     => __('Overlay Color 2', 'bb-powerpack'),
    //     'default'                   => '',
    //     'show_reset'                => true,
    //     'preview'                   => array(
    //         'type'                      => 'none',
    //     ),
    // );
    // $form['tabs']['style']['sections']['bg_overlay']['fields']['pp_bg_overlay_direction'] = array(
    //     'type'          => 'select',
    //     'label'         => __('Gradient Direction', 'bb-powerpack'),
    //     'default'       => 'bottom',
    //     'options'       => array(
    //         'bottom'                => __('Top to Bottom', 'bb-powerpack'),
    //         'right'                 => __('Left to Right', 'bb-powerpack'),
    //         'top_right_diagonal'    => __('Bottom Left to Top Right', 'bb-powerpack'),
    //         'top_left_diagonal'     => __('Bottom Right to Top Left', 'bb-powerpack'),
    //         'bottom_right_diagonal' => __('Top Left to Bottom Right', 'bb-powerpack'),
    //         'bottom_left_diagonal'  => __('Top Right to Bottom Left', 'bb-powerpack'),
    //     ),
    // );

	if ( $bg_overlay_opacity ) {
		$form['tabs']['style']['sections']['bg_overlay']['fields']['bg_overlay_opacity'] = $bg_overlay_opacity;
	}

    return $form;
}


/** Row settings tab */
function pp_row_settings_tab( $form, $id ) {
	if ( 'row' != $id ) {
        return $form;
	}
	
	$tab_name = pp_get_admin_label();

	$advanced = $form['tabs']['advanced'];
	unset( $form['tabs']['advanced'] );
	
	$form['tabs']['powerpack'] = array(
		'title'			=> $tab_name,
		'sections'		=> apply_filters( 'pp_row_settings_tab_sections', array() )
	);

	$form['tabs']['advanced'] = $advanced;

    return $form;
}

/** Separators */
function pp_row_separators( $sections ) {
	$separators = array(
		'pp_separators'	=> array( /** Separator */
			'title'			=> __('Separators', 'bb-powerpack'),
			'collapsed'		=> false,
			'fields'		=> array(
				'enable_separator'          => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Enable Separator?', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'sections'                  => array('separator_top', 'separator_bottom')
						)
					)
				)
			)
		),
		'separator_top'             => array(
			'title'                     => __('Top Separator', 'bb-powerpack'),
			'collapsed'					=> true,
			'fields'                    => array(
				'separator_type'            => array(
					'type'                      => 'select',
					'label'                     => __('Type', 'bb-powerpack'),
					'default'                   => 'none',
					'options'                   => array(
						'none'                      => __('None', 'bb-powerpack'),
						'triangle'                  => __('Big Triangle', 'bb-powerpack'),
						'triangle_shadow'           => __('Big Triangle with Shadow', 'bb-powerpack'),
						'triangle_left'             => __('Big Triangle Left', 'bb-powerpack'),
						'triangle_right'            => __('Big Triangle Right', 'bb-powerpack'),
						'triangle_small'            => __('Small Triangle', 'bb-powerpack'),
						'tilt_left'                 => __('Tilt Left', 'bb-powerpack'),
						'tilt_right'                => __('Tilt Right', 'bb-powerpack'),
						'curve'                     => __('Curve', 'bb-powerpack'),
						'wave'                      => __('Wave', 'bb-powerpack'),
						'cloud'                     => __('Cloud', 'bb-powerpack'),
						'slit'                      => __('Slit', 'bb-powerpack'),
						'water'                     => __('Water', 'bb-powerpack'),
						'zigzag'                    => __('ZigZag', 'bb-powerpack'),
					),
					'toggle'                    => array(
						'triangle_shadow'           => array(
							'fields'                    => array('separator_shadow')
						)
					)
				),
				'separator_color'           => array(
					'type'                      => 'color',
					'label'                     => __('Color', 'bb-powerpack'),
					'default'                   => 'ffffff',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-top svg',
						'property'                  => 'fill'
					)
				),
				'separator_shadow'          => array(
					'type'                      => 'color',
					'label'                     => __('Shadow Color', 'bb-powerpack'),
					'default'                   => 'f4f4f4',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-top svg .pp-shadow-color',
						'property'                  => 'fill'
					)
				),
				'separator_height'          => array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => 100,
					'size'                      => 5,
					'maxlength'                 => 3,
					'description'               => 'px',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-top svg',
						'property'                  => 'height',
						'unit'                      => 'px'
					)
				),
				'separator_position'        => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Position', 'bb-powerpack'),
					'default'                   => 'top',
					'options'                   => array(
						'top'                       => __('Top', 'bb-powerpack'),
						'bottom'                    => __('Bottom', 'bb-powerpack')
					)
				),
				'separator_tablet'          => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Show on Tablet', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'fields'                    => array('separator_height_tablet')
						)
					)
				),
				'separator_height_tablet'   => array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => '',
					'description'               => 'px',
					'size'                      => 5,
					'maxlength'                 => 3
				),
				'separator_mobile'          => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Show on Mobile', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'fields'                    => array('separator_height_mobile')
						)
					)
				),
				'separator_height_mobile'   => array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => '',
					'description'               => 'px',
					'size'                      => 5,
					'maxlength'                 => 3
				)
			)
		),
		'separator_bottom'        => array(
			'title'                     => __('Bottom Separator', 'bb-powerpack'),
			'collapsed'					=> true,
			'fields'                    => array(
				'separator_type_bottom'     => array(
					'type'                      => 'select',
					'label'                     => __('Type', 'bb-powerpack'),
					'default'                   => 'none',
					'options'                   => array(
						'none'                      => __('None', 'bb-powerpack'),
						'triangle'                  => __('Big Triangle', 'bb-powerpack'),
						'triangle_shadow'           => __('Big Triangle with Shadow', 'bb-powerpack'),
						'triangle_left'             => __('Big Triangle Left', 'bb-powerpack'),
						'triangle_right'            => __('Big Triangle Right', 'bb-powerpack'),
						'triangle_small'            => __('Small Triangle', 'bb-powerpack'),
						'tilt_left'                 => __('Tilt Left', 'bb-powerpack'),
						'tilt_right'                => __('Tilt Right', 'bb-powerpack'),
						'curve'                     => __('Curve', 'bb-powerpack'),
						'wave'                      => __('Wave', 'bb-powerpack'),
						'cloud'                     => __('Cloud', 'bb-powerpack'),
						'slit'                      => __('Slit', 'bb-powerpack'),
						'water'                     => __('Water', 'bb-powerpack'),
						'zigzag'                    => __('ZigZag', 'bb-powerpack'),
					),
					'toggle'                    => array(
						'triangle_shadow'           => array(
							'fields'                    => array('separator_shadow_bottom')
						)
					)
				),
				'separator_color_bottom'           => array(
					'type'                      => 'color',
					'label'                     => __('Color', 'bb-powerpack'),
					'default'                   => 'ffffff',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-bottom svg',
						'property'                  => 'fill'
					)
				),
				'separator_shadow_bottom'          => array(
					'type'                      => 'color',
					'label'                     => __('Shadow Color', 'bb-powerpack'),
					'default'                   => 'f4f4f4',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-bottom svg .pp-shadow-color',
						'property'                  => 'fill'
					)
				),
				'separator_height_bottom'          => array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => 100,
					'size'                      => 5,
					'maxlength'                 => 3,
					'description'               => 'px',
					'preview'                   => array(
						'type'                      => 'css',
						'selector'                  => '.pp-row-separator-bottom svg',
						'property'                  => 'height',
						'unit'                      => 'px'
					)
				),
				'separator_tablet_bottom'   => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Show on Tablet', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'fields'                    => array('separator_height_tablet_bottom')
						)
					),
					'preview'                   => array(
						'type'                      => 'none'
					)
				),
				'separator_height_tablet_bottom'=> array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => '',
					'description'               => 'px',
					'size'                      => 5,
					'maxlength'                 => 3
				),
				'separator_mobile_bottom'          => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Show on Mobile', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'fields'                    => array('separator_height_mobile_bottom')
						)
					),
					'preview'                   => array(
						'type'                      => 'none'
					)
				),
				'separator_height_mobile_bottom'   => array(
					'type'                      => 'text',
					'label'                     => __('Size', 'bb-powerpack'),
					'default'                   => '',
					'description'               => 'px',
					'size'                      => 5,
					'maxlength'                 => 3
				)
			)
		),
	);

	return array_merge( $sections, $separators );
}

/** Expandable Row */
function pp_row_expandable( $sections ) {
	$data = array(
		'enable_expandable' => array(
			'title'             => __('Expandable Row', 'bb-powerpack'),
			'collapsed'			=> true,
			'fields'            => array(
				'enable_expandable' => array(
					'type'              => 'pp-switch',
					'label'             => __('Enable Expandable Row?', 'bb-powerpack'),
					'default'           => 'no',
					'options'           => array(
						'yes'               => __('Yes', 'bb-powerpack'),
						'no'                => __('No', 'bb-powerpack')
					),
					'toggle'            => array(
						'yes'               => array(
							'sections'          => array('er_settings', 'er_title_style', 'er_arrow', 'er_background'),
							'fields'            => array('er_title', 'er_transition_speed')
						)
					)
				),
			)
		),
		'er_settings' => array(
			'title'             => __('Expandable Row Settings', 'bb-powerpack'),
			'collapsed'		=> true,
			'fields'            => array(
				'er_title'     => array(
					'type'          => 'text',
					'label'         => __('Title on Collapse', 'bb-powerpack'),
					'default'       => __('Click here to expand this row', 'bb-powerpack'),
					'preview'         => array(
						'type'             => 'text',
						'selector'         => '.pp-er-title'
					)
				),
				'er_title_e'     => array(
					'type'          => 'text',
					'label'         => __('Title on Expand', 'bb-powerpack'),
					'default'       => __('Click here to collapse this row', 'bb-powerpack')
				),
				'er_transition_speed'   => array(
					'type'                  => 'text',
					'label'                 => __('Transition Speed', 'bb-powerpack'),
					'default'               => 500,
					'description'           => 'ms',
					'class'                 => 'input-small',
					'size'                  => 5
				),
				'er_default_state'  => array(
					'type'              => 'pp-switch',
					'label'             => __('Default State', 'bb-powerpack'),
					'default'           => 'collapsed',
					'options'           => array(
						'collapsed'         => __('Collapsed', 'bb-powerpack'),
						'expanded'          => __('Expanded', 'bb-powerpack')
					)
				)
			)
		),
		'er_title_style'    => array(
			'title'             => __('Exapandable Title Style', 'bb-powerpack'),
			'collapsed'		=> true,
			'fields'            => array(
				'er_title_font' => array(
					'type'          => 'font',
					'label'         => __('Font', 'bb-powerpack'),
					'default'       => array(
						'family'    => 'Default',
						'weight'    => 400
					),
					'preview'       => array(
						'type'          => 'font',
						'selector'      => '.pp-er-title'
					)
				),
				'er_title_font_size'    => array(
					'type'                  => 'text',
					'label'                 => __('Font Size', 'bb-powerpack'),
					'default'               => 18,
					'description'           => 'px',
					'class'                 => 'input-small',
					'size'                  => 5,
					'preview'               => array(
						'type'                  => 'css',
						'selector'              => '.pp-er-title',
						'property'              => 'font-size',
						'unit'                  => 'px'
					)
				),
				'er_title_case' => array(
					'type'          => 'select',
					'label'         => __('Case', 'bb-powerpack'),
					'default'       => 'default',
					'options'       => array(
						'none'          => __('Default', 'bb-powerpack'),
						'lowercase'     => __('lowercase', 'bb-powerpack'),
						'uppercase'     => __('UPPERCASE', 'bb-powerpack')
					)
				),
				'er_title_color'    => array(
					'type'              => 'pp-color',
					'label'             => __('Color', 'bb-powerpack'),
					'options'           => array(
						'primary'           => __('Default', 'bb-powerpack'),
						'secondary'         => __('Hover', 'bb-powerpack'),
					),
					'show_reset'        => true,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-er-title',
						'property'          => 'color'
					)
				),
				'er_title_margin'   => array(
					'type'              => 'pp-multitext',
					'label'             => __('Margin', 'bb-powerpack'),
					'description'       => 'px',
					'default'           => array(
						'bottom'            => 0,
						'right'             => 0,
					),
					'options'           => array(
						'bottom'            => array(
							'placeholder'       => __('Bottom', 'bb-powerpack'),
							'maxlength'         => 3,
							'icon'              => 'fa-long-arrow-down',
							'tooltip'           => __('Bottom', 'bb-powerpack'),
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-title',
								'property'          => 'margin-bottom',
								'unit'              => 'px'
							),
						),
						'right'             => array(
							'placeholder'       => __('Right', 'bb-powerpack'),
							'maxlength'         => 3,
							'icon'              => 'fa-long-arrow-right',
							'tooltip'           => __('Right', 'bb-powerpack'),
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-title',
								'property'          => 'margin-right',
								'unit'              => 'px'
							),
						),
					)
				),
			)
		),
		'er_arrow' => array( // Section
			'title'    => __('Expandable Arrow Style', 'bb-powerpack'), // Section Title
			'collapsed'		=> true,
			'fields'   => array( // Section Fields
				'er_arrow_pos'  => array(
					'type'          => 'pp-switch',
					'label'         => __('Position', 'bb-powerpack'),
					'default'       => 'bottom',
					'options'       => array(
						'bottom'        => __('Below Text', 'bb-powerpack'),
						'right'         => __('Beside Text', 'bb-powerpack')
					)
				),
				'er_arrow_size' => array(
					'type'          => 'text',
					'label'         => __('Size', 'bb-powerpack'),
					'default'       => 12,
					'description'   => 'px',
					'class'         => 'input-small',
					'size'          => 5,
					'preview'       => array(
						'type'          => 'css',
						'selector'      => '.pp-er-arrow',
						'property'      => 'font-size',
						'unit'          => 'px'
					)
				),
				'er_arrow_weight'   => array(
					'type'              => 'pp-switch',
					'label'             => __('Weight', 'bb-powerpack'),
					'default'           => 'bold',
					'options'           => array(
						'light'             => __('Light', 'bb-powerpack'),
						'bold'              => __('Bold', 'bb-powerpack')
					)
				),
				'er_arrow_color'    => array(
					'type'              => 'pp-color',
					'label'             => __('Color', 'bb-powerpack'),
					'options'           => array(
						'primary'           => __('Default', 'bb-powerpack'),
						'secondary'         => __('Hover', 'bb-powerpack'),
					),
					'show_reset'        => true,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-er-arrow',
						'property'          => 'color'
					)
				),
				'er_arrow_bg'       => array(
					'type'              => 'pp-color',
					'label'             => __('Background Color', 'bb-powerpack'),
					'options'           => array(
						'primary'           => __('Default', 'bb-powerpack'),
						'secondary'         => __('Hover', 'bb-powerpack'),
					),
					'show_reset'        => true,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-er-arrow',
						'property'          => 'background-color'
					)
				),
				'er_arrow_border'   => array(
					'type'              => 'text',
					'label'             => __('Border Width', 'bb-powerpack'),
					'default'           => 0,
					'description'       => 'px',
					'class'             => 'input-small',
					'size'              => 5,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-er-arrow:before',
						'property'          => 'border-width',
						'unit'              => 'px'
					)
				),
				'er_arrow_border_color' => array(
					'type'                  => 'pp-color',
					'label'                 => __('Border Color', 'bb-powerpack'),
					'options'               => array(
						'primary'               => __('Default', 'bb-powerpack'),
						'secondary'             => __('Hover', 'bb-powerpack'),
					),
					'show_reset'            => true,
					'preview'               => array(
						'type'                  => 'css',
						'selector'              => '.pp-er-arrow:before',
						'property'              => 'border-color'
					)
				),
				'er_arrow_padding_all'  => array(
					'type'              => 'pp-multitext',
					'label'             => __('Padding', 'bb-powerpack'),
					'description'       => 'px',
					'default'           => array(
						'top'               => 0,
						'bottom'            => 0,
						'left'              => 0,
						'right'             => 0
					),
					'options'           => array(
						'top'               => array(
							'placeholder'       => __('Top', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-up',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-arrow:before',
								'property'          => 'padding-top',
								'unit'              => 'px'
							),
							'tooltip'           => __('Top', 'bb-powerpack')
						),
						'bottom'            => array(
							'placeholder'       => __('Bottom', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-down',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-arrow:before',
								'property'          => 'padding-bottom',
								'unit'              => 'px'
							),
							'tooltip'           => __('Bottom', 'bb-powerpack')
						),
						'left'            => array(
							'placeholder'       => __('Left', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-left',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-arrow:before',
								'property'          => 'padding-left',
								'unit'              => 'px'
							),
							'tooltip'           => __('Left', 'bb-powerpack')
						),
						'right'            => array(
							'placeholder'       => __('Right', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-right',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-arrow:before',
								'property'          => 'padding-right',
								'unit'              => 'px'
							),
							'tooltip'           => __('Right', 'bb-powerpack')
						),
					)
				),
				'er_arrow_radius'   => array(
					'type'              => 'text',
					'label'             => __('Round Corners', 'bb-powerpack'),
					'default'           => 0,
					'description'       => 'px',
					'class'             => 'input-small',
					'size'              => 5,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-er-arrow:before',
						'property'          => 'border-radius',
						'unit'              => 'px'
					)
				),
			)
		),
		'er_background' => array( // Section
			'title'         => __('Expandable Background & Padding', 'bb-powerpack'), // Section Title
			'collapsed'		=> true,
			'fields'        => array( // Section Fields
				'er_bg_color'   => array(
					'type'          => 'color',
					'label'         => __('Color', 'bb-powerpack'),
					'default'       => '',
					'preview'       => array(
						'type'          => 'css',
						'selector'      => '.pp-er-wrap',
						'property'      => 'background-color'
					)
				),
				'er_bg_opacity' => array(
					'type'          => 'text',
					'label'         => __('Opacity', 'bb-powerpack'),
					'default'       => 1,
					'description'   => __('between 0 to 1', 'bb-powerpack'),
					'class'         => 'input-small',
					'size'          => 5
				),
				'er_title_padding'   => array(
					'type'              => 'pp-multitext',
					'label'             => __('Padding', 'bb-powerpack'),
					'default'           => array(
						'top'               => 18,
						'bottom'            => 18
					),
					'options'           => array(
						'top'               => array(
							'placeholder'       => __('Top', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-up',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-wrap',
								'property'          => 'padding-top',
								'unit'              => 'px'
							),
							'tooltip'           => __('Top', 'bb-powerpack')
						),
						'bottom'            => array(
							'placeholder'       => __('Bottom', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-down',
							'preview'           => array(
								'selector'          => '.pp-er .pp-er-wrap',
								'property'          => 'padding-bottom',
								'unit'              => 'px'
							),
							'tooltip'           => __('Bottom', 'bb-powerpack')
						)
					)
				)
			)
		)
	);

	return array_merge( $sections, $data );
}

/** Down Arrow */
function pp_row_downarrow( $sections ) {
	$data = array(
		'enable_down_arrow'         => array(
			'title'                     => __('Down Arrow', 'bb-powerpack'),
			'collapsed'					=> true,
			'fields'                    => array(
				'enable_down_arrow'         => array(
					'type'                      => 'pp-switch',
					'label'                     => __('Enable Down Arrow?', 'bb-powerpack'),
					'default'                   => 'no',
					'options'                   => array(
						'yes'                       => __('Yes', 'bb-powerpack'),
						'no'                        => __('No', 'bb-powerpack')
					),
					'toggle'                    => array(
						'yes'                       => array(
							'sections'                  => array('da_style'),
							'fields'                    => array('da_transition_speed', 'da_top_offset')
						)
					)
				),
				'da_transition_speed'   => array(
					'type'                  => 'text',
					'label'                 => __('Transition Speed', 'bb-powerpack'),
					'default'               => 500,
					'description'           => 'ms',
					'class'                 => 'input-small'
				),
				'da_top_offset'         => array(
					'type'                  => 'text',
					'label'                 => __('Top Offset', 'bb-powerpack'),
					'default'               => 0,
					'description'           => 'px',
					'class'                 => 'input-small',
					'help'                  => __('If your theme uses a sticky header, then please enter the header height in px (numbers only) to avoid overlapping of row content.', 'bb-powerpack')
				),
				'da_animation'          => array(
					'type'                  => 'pp-switch',
					'label'                 => __('Enable Animation', 'bb-powerpack'),
					'default'               => 'no',
					'options'               => array(
						'yes'                   => __('Yes', 'bb-powerpack'),
						'no'                    => __('No', 'bb-powerpack')
					)
				),
				'da_hide_mobile'    => array(
					'type'              => 'pp-switch',
					'label'             => __('Hide on Mobile', 'bb-powerpack'),
					'default'           => 'no',
					'options'           => array(
						'yes'               => __('Yes', 'bb-powerpack'),
						'no'                => __('No', 'bb-powerpack'),
					)
				)
			)
		),
		'da_style'      => array(
			'title'         => __('Style', 'bb-powerpack'),
			'fields'        => array(
				'da_arrow_weight'   => array(
					'type'              => 'pp-switch',
					'label'             => __('Weight', 'bb-powerpack'),
					'default'           => 'light',
					'options'           => array(
						'light'             => __('Light', 'bb-powerpack'),
						'bold'              => __('Bold', 'bb-powerpack')
					)
				),
				'da_arrow_color'    => array(
					'type'              => 'pp-color',
					'label'             => __('Color', 'bb-powerpack'),
					'default'           => array(
						'primary'           => '000000',
						'secondary'         => '000000',
					),
					'options'           => array(
						'primary'           => __('Default', 'bb-powerpack'),
						'secondary'         => __('Hover', 'bb-powerpack'),
					),
					'preview'           => array(
						'type'              => 'css',
						'rules'             => array(
							array(
								'selector'          => '.pp-down-arrow-wrap .pp-down-arrow svg path',
								'property'          => 'stroke'
							),
							array(
								'selector'          => '.pp-down-arrow-wrap .pp-down-arrow svg path',
								'property'          => 'fill'
							)
						)
					)
				),
				'da_arrow_bg'       => array(
					'type'              => 'pp-color',
					'label'             => __('Background Color', 'bb-powerpack'),
					'default'           => array(
						'primary'           => 'f4f4f4',
						'secondary'         => 'f4f4f4',
					),
					'options'           => array(
						'primary'           => __('Default', 'bb-powerpack'),
						'secondary'         => __('Hover', 'bb-powerpack'),
					),
					'show_reset'        => true,
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-down-arrow-wrap .pp-down-arrow',
						'property'          => 'background-color'
					)
				),
				'da_arrow_border'   => array(
					'type'              => 'text',
					'label'             => __('Border Width', 'bb-powerpack'),
					'default'           => 0,
					'description'       => 'px',
					'class'             => 'input-small',
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-down-arrow-wrap .pp-down-arrow',
						'property'          => 'border-width',
						'unit'              => 'px'
					)
				),
				'da_arrow_border_color' => array(
					'type'                  => 'pp-color',
					'label'                 => __('Border Color', 'bb-powerpack'),
					'default'               => array(
						'primary'               => '000000',
						'secondary'             => '000000',
					),
					'options'               => array(
						'primary'               => __('Default', 'bb-powerpack'),
						'secondary'             => __('Hover', 'bb-powerpack'),
					),
					'show_reset'            => true,
					'preview'               => array(
						'type'                  => 'css',
						'selector'              => '.pp-down-arrow-wrap .pp-down-arrow',
						'property'              => 'border-color'
					)
				),
				'da_arrow_padding'  => array(
					'type'              => 'text',
					'label'             => __('Padding', 'bb-powerpack'),
					'default'           => 0,
					'description'       => 'px',
					'class'             => 'input-small',
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-down-arrow-wrap .pp-down-arrow',
						'property'          => 'padding',
						'unit'              => 'px'
					)
				),
				'da_arrow_margin'  => array(
					'type'              => 'pp-multitext',
					'label'             => __('Margin', 'bb-powerpack'),
					'description'       => 'px',
					'default'           => array(
						'top'               => 0,
						'bottom'            => 30
					),
					'options'           => array(
						'top'               => array(
							'placeholder'       => __('Top', 'bb-powerpack'),
							'tooltip'           => __('Top', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-up',
							'preview'           => array(
								'selector'          => '.pp-down-arrow-container',
								'property'          => 'margin-top',
								'unit'              => 'px'
							)
						),
						'bottom'            => array(
							'placeholder'       => __('Bottom', 'bb-powerpack'),
							'tooltip'           => __('Bottom', 'bb-powerpack'),
							'icon'              => 'fa-long-arrow-down',
							'preview'           => array(
								'selector'          => '.pp-down-arrow-wrap',
								'property'          => 'bottom',
								'unit'              => 'px'
							)
						)
					)
				),
				'da_arrow_radius'   => array(
					'type'              => 'text',
					'label'             => __('Round Corners', 'bb-powerpack'),
					'default'           => 0,
					'description'       => 'px',
					'class'             => 'input-small',
					'preview'           => array(
						'type'              => 'css',
						'selector'          => '.pp-down-arrow-wrap .pp-down-arrow',
						'property'          => 'border-radius',
						'unit'              => 'px'
					)
				),
			)
		)
	);

	return array_merge( $sections, $data );
}
