<?php

class BB_PowerPack_Post_Helper {
    static public $post_slides = array();

    static public function post_catch_image( $content )
	{
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
		if ( isset( $matches[1][0] ) ) {
			$first_img = $matches[1][0];
		}
		return $first_img;
    }
    
    static public function post_image_get_settings( $id, $crop, $settings )
    {
		// get image source and data
		$src = self::post_image_get_full_src( $id, $settings );
		$photo_data = self::post_image_get_data( $id );

		// set params
		$photo_settings = array(
			'crop'          => $crop,
			'link_type'     => '',
			'link_url'      => '',
			'photo'         => $photo_data,
			'photo_src'     => $src,
			'photo_source'  => 'library',
			'attributes'	=> array(
				'data-no-lazy'	=> 1
			)
		);

		if ( in_array( $settings->more_link_type, array( 'button', 'thumb', 'title_thumb' ) ) ) {
			$photo_settings['link_type'] = 'url';
			$photo_settings['link_url'] = get_the_permalink( $id );
        }
        
        return $photo_settings;
    }
    
    static public function post_image_get_full_src( $id, $settings )
    {
        $thumb_id = get_post_thumbnail_id( $id );
		$size = isset( $settings->image_thumb_size ) ? $settings->image_thumb_size : 'medium';
		$img = wp_get_attachment_image_src( $thumb_id, $size );
		return $img[0];
    }

    static protected function post_image_get_data( $id )
    {
        $thumb_id = get_post_thumbnail_id( $id );
		return FLBuilderPhoto::get_attachment_data( $thumb_id );
    }

    static public function post_build_array( $settings ){

		// checks if the post_slides array is cached
		if( !is_array( self::$post_slides ) ){

			// if not, create it
			self::$post_slides = array();

			// check if we have selected posts
			if( empty( $settings->posts_post ) ){

				// if not, create a default query with it
				$settings = !empty( $settings ) ? $settings : new stdClass();
				// set WP_Query "fields" arg as 'ids' to return less information
				$settings->fields = 'ids';

				// Get the query data.
				$query = FLBuilderLoop::query( $settings );

				// build the post_slides array with post id's and featured image url's
				foreach( $query->posts as $key => $id ){
					self::$post_slides[ $id ] = self::post_image_get_full_src( $id, $settings );
				}

			} else{

				// if yes, get the selected posts and build the post_slides array
				$slides = explode( ',', $settings->posts_post );

				foreach( $slides as $key => $id ){
					self::$post_slides[$id] = self::post_image_get_full_src( $id, $settings );
				}

			}
		}

		return self::$post_slides;
	}

	public function post_get_uncropped_url( $id, $settings ){
		$posts = self::post_build_array( $settings );
		return $posts[$id];
    }
    
    /**
	 * Build base URL for our custom pagination.
	 *
	 * @param string $permalink_structure  The current permalink structure.
	 * @param string $base  The base URL to parse
	 * @since 1.3.1
	 * @return string
	 */
	static public function build_base_url( $permalink_structure, $base ) {
		// Check to see if we are using pretty permalinks
		if ( ! empty( $permalink_structure ) ) {

			if ( strrpos( $base, 'paged-' ) ) {
				$base = substr_replace( $base, '', strrpos( $base, 'paged-' ), strlen( $base ) );
			}

			// Remove query string from base URL since paginate_links() adds it automatically.
			// This should also fix the WPML pagination issue that was added since 1.10.2.
			if ( count( $_GET ) > 0 ) {
				$base = strtok( $base, '?' );
			}

			$base = untrailingslashit( $base );

		} else {
			$url_params = wp_parse_url( $base, PHP_URL_QUERY );

			if ( empty( $url_params ) ) {
				$base = trailingslashit( $base );
			}
		}

		return $base;
	}

	/**
	 * Build the custom pagination format.
	 *
	 * @param string $permalink_structure
	 * @param string $base
	 * @since 1.3.1
	 * @return string
	 */
	static public function paged_format( $permalink_structure, $base ) {
		if ( FLBuilderLoop::$loop_counter > 1 ) {
			$page_prefix = 'paged-' . FLBuilderLoop::$loop_counter;
		} else {
			$page_prefix = empty( $permalink_structure ) ? 'paged' : 'page';
		}

		if ( ! empty( $permalink_structure ) ) {
			$format = ! empty( $page_prefix ) ? '/' . $page_prefix . '/' : '/';
			$format .= '%#%';
			$format .= substr( $permalink_structure, -1 ) == '/' ? '/' : '';
		} elseif ( empty( $permalink_structure ) || is_search() ) {
			$parse_url = wp_parse_url( $base, PHP_URL_QUERY );
			$format = empty( $parse_url ) ? '?' : '&';
			$format .= $page_prefix . '=%#%';
		}

		return $format;
	}

	static public function pagination( $query, $settings )
	{
		$total = 0;
		$page = 0;
		$paged = FLBuilderLoop::get_paged();
		$total_posts_count = $settings->total_posts_count;
		$posts_aval = $query->found_posts;
		$permalink_structure = get_option('permalink_structure');
		$base = untrailingslashit( html_entity_decode( get_pagenum_link() ) );

		if( $settings->total_post == 'custom' && $total_posts_count != $posts_aval ) {

			if( $total_posts_count > $posts_aval ) {
				$page = $posts_aval / $settings->posts_per_page;
				$total = $posts_aval % $settings->posts_per_page;
			}
			if( $total_posts_count < $posts_aval ) {
				$page = $total_posts_count / $settings->posts_per_page;
				$total = $total_posts_count % $settings->posts_per_page;
			}

			if( $total > 0 ) {
				$page = $page + 1;
			}

		}
		else {
			$page = $query->max_num_pages;
			//FLBuilderLoop::pagination($query);
		}

		if ( $page > 1 ) {

			if ( ! $current_page = $paged ) {
				$current_page = 1;
			}

			$base = self::build_base_url( $permalink_structure, $base );
			$format = self::paged_format( $permalink_structure, $base );

			echo paginate_links(array(
				'base'	   => $base . '%_%',
				'format'   => $format,
				'current'  => $current_page,
				'total'	   => $page,
				'type'	   => 'list'
			));
		}
	}

	/**
     * Build pagination.
     *
     * @since 1.1.0
     * @return void
     */
    static public function ajax_pagination( $query, $current_url = '', $paged = 1 ) {
		$total_pages = $query->max_num_pages;
        $permalink_structure = get_option( 'permalink_structure' );
        $current_url = empty( $current_url ) ? get_pagenum_link() : $current_url;
		$base = untrailingslashit( html_entity_decode( $current_url ) );

		if ( $total_pages > 1 ) {

			if ( ! $current_page = $paged ) { // @codingStandardsIgnoreLine
				$current_page = 1;
			}

			$base = FLBuilderLoop::build_base_url( $permalink_structure, $base );

			echo paginate_links(array(
				'base'	   => $base . '%_%',
				'format'   => '/#page-%#%',
				'current'  => $current_page,
				'total'	   => $total_pages,
				'type'	   => 'list',
			));
		}
    }
}