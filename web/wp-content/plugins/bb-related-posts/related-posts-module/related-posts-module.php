<?php

/**
 * @class HIPRelatedPostsModule
 */
class HIPRelatedPostsModule extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('HIP Related Posts', 'fl-builder'),
            'description'     => __('Related posts based on category or selected posts', 'fl-builder'),
            'category'        => __('Advanced Modules', 'fl-builder'),
            'dir'             => RELATED_POSTS_DIR . 'related-posts-module/',
            'url'             => RELATED_POSTS_URL . 'related-posts-module/',
            'enabled'         => true,
            'editor_export'   => false,
            'partial_refresh' => true
        ));
    }
    
    public static function getCatOptions()
    {
			$categories = get_categories(array(
					'exclude'    => '1',
					'hide_empty' => false,
			));
			
			foreach ($categories as $category) {
				$cat_options[$category->term_id] = ucfirst($category->name . ' (' . $category->category_count . ' Posts)');
			}
			
			return $cat_options;
		}
		
		public static function getPostOptions()
		{
			/*Get posts*/
			$posts = get_posts(array(
					'posts_per_page' => -1,
			));
			foreach ($posts as $post) {
					$post_options[$post->ID] = $post->post_title;
			}
			
			return $post_options;
		}
}

/*Builder options*/
FLBuilder::register_module('HIPRelatedPostsModule', array(
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
                    'layout'       => array(
                        'type'    => 'select',
                        'label'   => __('Layout', 'fl-builder'),
                        'default' => 'main_content',
                        'options' => array(
                            'main'  => __('Main', 'fl-builder'),
                            'aside' => __('Aside', 'fl-builder')
                        ),
                        'toggle'  => array(
                            'main' => array(
                                'fields'   => array('summery_text'),
                                'sections' => array('summery_style')
                            ),
                        ),
                    ),
                    'summery_text' => array(
                        'type'    => 'editor',
                        'label'   => __('Summery', 'fl-builder'),
                        'rows'    => 12,
                        'wpautop' => false
                    )
                )
            )
        )
    ),
    'content' => array(
        'title'    => __('Content', 'fl-builder'),
        'sections' => array(
            'general'           => array(
                'title'  => __('General', 'fl-builder'),
                'fields' => array(
                    'display_by' => array(
                        'type'    => 'select',
                        'label'   => __('Display by', 'fl-builder'),
                        'default' => 'category',
                        'options' => array(
                            'category' => __('Category', 'fl-builder'),
                            'post'     => __('Selected Post', 'fl-builder')
                        ),
                        'toggle'  => array(
                            'category' => array(
                                'sections' => array('category_settings'),

                            ),
                            'post'     => array(
                                'sections' => array('posts_settings'),
                            ),
                        )
                    )
                )
            ),
            'category_settings' => array(
                'title'  => __('Category Settings', 'fl-builder'),
                'fields' => array(
                    'selected_category' => array(
                        'type'    => 'select',
                        'label'   => __('Select Category', 'fl-builder'),
                        'options' => HIPRelatedPostsModule::getCatOptions(),
                    ),
                    'number_of_posts'   => array(
                        'type'      => 'text',
                        'label'     => __('Number of Posts', 'fl-builder'),
                        'default'   => '5',
                        'maxlength' => '2',
                        'size'      => '3'
                    )
                )
            ),
            'posts_settings'    => array(
                'title'  => __('Select Posts to display', 'fl-builder'),
                'fields' => array(
                    'selected_posts' => array(
                        'type'         => 'select',
                        'label'        => __('Select Post', 'fl-builder'),
                        'options'      => HIPRelatedPostsModule::getPostOptions(),
                        'multi-select' => true,
                        'help'         => __('Ctrl (windows) / Command (Mac) + click for multiple select', 'fl-builder')
                    )
                )
            ),
            'ordering'          => array(
                'title'  => 'Post Order',
                'fields' => array(
                    'order'    => array(
                        'type'    => 'select',
                        'label'   => __('Order', 'fl-builder'),
                        'default' => 'def',
                        'options' => array(
                            'def'  => __('Default', 'fl-builder'),
                            'DESC' => __('Descending', 'fl-builder'),
                            'ASC'  => __('Ascending', 'fl-builder')
                        ),
                    ),
                    'order_by' => array(
                        'type'    => 'select',
                        'label'   => __('Order By', 'fl-builder'),
                        'default' => 'def',
                        'options' => array(
                            'def'   => __('Default', 'fl-builder'),
                            'date'  => __('Date', 'fl-builder'),
                            'id'    => __('ID', 'fl-builder'),
                            'title' => __('Title', 'fl-builder')
                        ),
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
                        'label'      => __('Background', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
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
                    'heading_color'      => array(
                        'type'       => 'color',
                        'label'      => __('Color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
                    ),
                )
            ),
            'summery_style' => array(
                'title'  => __('Summery Style', 'fl-builder'),
                'fields' => array(
                    'summery_font_size'  => array(
                        'type'        => 'text',
                        'label'       => __('Font Size', 'fl-builder'),
                        'default'     => '',
                        'maxlength'   => '3',
                        'size'        => '4',
                        'description' => 'px'
                    ),
                    'summery_text_align' => array(
                        'type'    => 'select',
                        'label'   => __('Text align', 'fl-builder'),
                        'default' => 'left',
                        'options' => array(
                            'left'   => __('Left', 'fl-builder'),
                            'right'  => __('Right', 'fl-builder'),
                            'center' => __('Center', 'fl-builder'),
                        ),
                    ),
                    'summery_color'      => array(
                        'type'       => 'color',
                        'label'      => __('Color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
                    ),
                )
            ),
            'posts_style'   => array(
                'title'  => __('Posts List Style', 'fl-builder'),
                'fields' => array(
                    'list_style'          => array(
                        'type'    => 'select',
                        'label'   => __('List Style', 'fl-builder'),
                        'default' => 'none',
                        'options' => array(
                            'none'   => __('None', 'fl-builder'),
                            'disc'   => __('Bullet', 'fl-builder'),
                            'square' => __('Square', 'fl-builder')
                        ),
                    ),
                    'list_font_size'      => array(
                        'type'        => 'text',
                        'label'       => __('Font Size', 'fl-builder'),
                        'default'     => '',
                        'maxlength'   => '3',
                        'size'        => '4',
                        'description' => 'px'
                    ),
                    'list_text_align'     => array(
                        'type'    => 'select',
                        'label'   => __('Text align', 'fl-builder'),
                        'default' => 'left',
                        'options' => array(
                            'left'   => __('Left', 'fl-builder'),
                            'right'  => __('Right', 'fl-builder'),
                            'center' => __('Center', 'fl-builder'),
                        ),
                    ),
                    'bottom_border'       => array(
                        'type'        => 'text',
                        'label'       => __('Bottom border', 'fl-builder'),
                        'default'     => '',
                        'maxlength'   => '3',
                        'size'        => '4',
                        'description' => 'px'
                    ),
                    'bottom_border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
                    ),
                    'list_color'          => array(
                        'type'       => 'color',
                        'label'      => __('Color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
                    ),
                    'list_hover_color'    => array(
                        'type'       => 'color',
                        'label'      => __('Hover Color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true
                    ),
                )
            )
        )
    ),
));
