<?php
/**
 * @class HIPPostCategoriesModule
 */

class HIPPostCategoriesModule extends FLBuilderModule{
	public function __construct()
	{
		parent::__construct(array(
			'name'            => __('HIP Posts Categories', 'fl-builder'),
			'description'     => __('List post categories with custom filtering option', 'fl-builder'),
			'category'        => __('Hip Modules', 'fl-builder'),
			'dir'             => HIP_POST_CATEGORIES_DIR . 'hip-post-categories-module/',
			'url'             => HIP_POST_CATEGORIES_URL . 'hip-post-categories-module/',
			'enabled'         => true,
			'editor_export'   => false,
			'partial_refresh' => true
		));
		$this->icon = $this->moduleIcon();
	}
	public function moduleIcon($icon = '')
	{
		return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M5.5 7C4.67 7 4 6.33 4 5.5 4 4.68 4.67 4 5.5 4 6.32 4 7 4.68 7 5.5 7 6.33 6.32 7 5.5 7zM8 5h9v1H8V5zm-2.5 7c-.83 0-1.5-.67-1.5-1.5C4 9.68 4.67 9 5.5 9c.82 0 1.5.68 1.5 1.5 0 .83-.68 1.5-1.5 1.5zM8 10h9v1H8v-1zm-2.5 7c-.83 0-1.5-.67-1.5-1.5 0-.82.67-1.5 1.5-1.5.82 0 1.5.68 1.5 1.5 0 .83-.68 1.5-1.5 1.5zM8 15h9v1H8v-1z"/></g></svg>';
	}
}
/*Builder options*/
FLBuilder::register_module('HIPPostCategoriesModule', array(
	'general' => array(
		'title'    => __('General', 'fl-builder'),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'heading'      => array(
						'type'    => 'text',
						'label'   => __('Heading', 'fl-builder'),
						'default' => '',

					),
					'number_of_categories'  => array(
						'type'        => 'text',
						'label'       => __('Number of categories', 'fl-builder'),
						'default'     => '',
						'maxlength'   => '3',
						'size'        => '4'
					),
					'match_post_categories' => array(
						'type'         => 'select',
						'label'        => __('Categories', 'fl-builder'),
						'default'      => 'include',
						'size' => 100,
						'options'      => array(
							'include' => 'Match these post categories',
							'exclude' => 'Exclude these post categories'
						)
					),
					'categories' => array(
						'type'          => 'suggest',
						'label'         => __(' ', 'fl-builder'),
						'action'        => 'fl_as_terms',
						'data'          => 'category',
					),
				)
			)
		)
	),
	'style'   => array(
		'title'    => __('Style', 'fl-builder'),
		'sections' => array(
			'general'       => array(
				'title'  => __('General', 'fl-builder'),
				'fields' => array(
					'bg_color' => array(
						'type'       => 'color',
						'label'      => __('Background', 'fl-builder')
					),
				)
			),
			'heading_style' => array(
				'title'  => __('Heading', 'fl-builder'),
				'fields' => array(
					'heading_font_size'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px'
					),
					'heading_text_align' => array(
						'type'    => 'select',
						'label'   => __('Text align', 'fl-builder'),
						'default' => 'left',
						'options' => array(
							'left'   => __('Left', 'fl-builder'),
							'right'  => __('Right', 'fl-builder'),
							'center' => __('Center', 'fl-builder'),
						),
					),
					'heading_text_color'      => array(
						'type'       => 'color',
						'label'      => __('Color', 'fl-builder')
					),
					'heading_margin_btm'  => array(
						'type'        => 'text',
						'label'       => __('Margin bottom', 'fl-builder'),
						'default'     => '15',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px'
					),
				)
			),
			'categories_style' => array(
				'title'  => __('Categories', 'fl-builder'),
				'fields' => array(
					'list_style' => array(
						'type'    => 'select',
						'label'   => __('List style', 'fl-builder'),
						'default' => 'dot',
						'options' => array(
							'dot'   => __('Dot', 'fl-builder'),
							'square'  => __('Square', 'fl-builder'),
							'none' => __('None', 'fl-builder'),
						),
					),
					'list_font_size'  => array(
						'type'        => 'text',
						'label'       => __('Font Size', 'fl-builder'),
						'default'     => '',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px'
					),
					'list_text_color'      => array(
						'type'       => 'color',
						'label'      => __('Text Color', 'fl-builder')
					),
					'list_text_hover_color'      => array(
						'type'       => 'color',
						'label'      => __('Text Hover Color', 'fl-builder')
					),
					'list_spacing'  => array(
						'type'        => 'text',
						'label'       => __('List item spacing', 'fl-builder'),
						'default'     => '5',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px'
					),
					'list_margin_left'  => array(
						'type'        => 'text',
						'label'       => __('List margin from left', 'fl-builder'),
						'default'     => '20',
						'maxlength'   => '3',
						'size'        => '4',
						'description' => 'px'
					)
				)
			)
		)
	),
));