<?php

/**
 * Archive Title
 */
FLPageData::add_archive_property( 'title', array(
	'label'   => __( 'Archive Title', 'fl-theme-builder' ),
	'group'   => 'general',
	'type'    => 'string',
	'getter'  => 'FLPageDataArchive::get_title',
) );

/**
 * Archive Description
 */
FLPageData::add_archive_property( 'description', array(
	'label'   => __( 'Archive Description', 'fl-theme-builder' ),
	'group'   => 'general',
	'type'    => 'string',
	'getter'  => 'get_the_archive_description',
) );
