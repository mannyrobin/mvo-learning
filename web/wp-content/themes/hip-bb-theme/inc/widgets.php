<?php
// Creating the widget 
class popular_category_widget extends WP_Widget
{
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct()
	{
		$widget_options = array(
			'classname' => 'popular_categories',
			'description' => 'Get most populer categories',
		);
		parent::__construct('popular_category_widget', 'Popular Category', $widget_options);
	}
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance)
	{
		// extrach $args
		extract($args, EXTR_SKIP);
		// Check for title
		$title = apply_filters('widget_title', $instance['title']);
		
		$output = '';
		
		if (! empty($title)) {
			$output .= $before_title . $title . $after_title;
		}
		
		if (is_category()) {
			$current_term_id = get_queried_object()->term_id;
		}

		$top_categories = get_categories(array(
			'number'  =>  $instance['cat_count'] ? $instance['cat_count'] : 5,
			'exclude' => '1',
			'orderby' => 'count',
			'order'   => 'DESC'
		));
		
		$output .= '<ul>';
		foreach ($top_categories as $category) {
			$current = '';
			if (!empty($current_term_id)) {
				$current = $current_term_id == $category->term_id ? ' class="current"' : '';
			}
			$output .= '<li'.$current.'>';
			$output .= '<a href="'.get_category_link($category->term_id).'">'.$category->name.'</a>';
			$output .= '</li>';
		}
		 $output .= '</ul>';

		 // print all output;
		 echo $before_widget;
		 echo $output;
		 echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 * @param array $instance The widget options
     * @return void
	 */
	public function form($instance)
	{
		// outputs the options form on admin
		
		$cat_count = isset($instance[ 'cat_count' ]) ? $instance[ 'cat_count' ] : 5;
		$title = isset($instance['title']) ? $instance['title'] : __('Popular category');
	 
		// markup for form
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('cat_count'); ?>">Number of category (Default 5):</label>
				<input type="number" min="1" id="<?php echo $this->get_field_id('cat_count'); ?>" name="<?php echo $this->get_field_name('cat_count'); ?>" value="<?php echo esc_attr($cat_count); ?>">
			</p>
					 
		<?php
	}

	/**
	 * Processing widget options on save
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 * @return array
	 */
	public function update($new_instance, $old_instance)
	{
		// processes widget options to be saved
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags($new_instance[ 'title' ]);
		$instance[ 'cat_count' ] = strip_tags($new_instance[ 'cat_count' ]);
		return $instance;
	}
} // Class popular_category_widget ends here

// Register and load the widget
function load_custom_widgets()
{
	register_widget('popular_category_widget');
}
add_action('widgets_init', 'load_custom_widgets');
