<?php
namespace Hip\Theme;

class Breadcrumbs
{
	protected $post;
	
	public function __construct(\WP_Post $post)
	{
		$this->post = $post;
	}
	public function getCrumbs()
	{
		global $post;
		$list = [];
		$tax = '';
		
		$post_type = get_post_type($this->post);
		$post_type_object = get_post_type_object($post_type);
		$list[] = [
			'name'	=> 'Home',
			'link'	=> home_url('/')
		];
		if ($post_type !== 'page' && $post_type !== 'post') {
			$list[] = [
				'name'	=> $post_type_object->label,
				'link'	=> get_post_type_archive_link($post_type)
			];
		}
		if($post_type == 'post'){
			$list[] = [
				'name'	=> 'Blog',
				'link'	=> get_post_type_archive_link($post_type)
			];
		}
		if ($post_type !== 'post') {
			if ( taxonomy_exists( $post_type . '_category' ) ) {
				$tax = $post_type . '_category';
			} elseif ( taxonomy_exists( $post_type . '-cat' ) ) {
				$tax = $post_type . '-cat';
			} elseif ( taxonomy_exists( $post_type . '-category' ) ) {
				$tax = $post_type . '-category';
			} elseif ( taxonomy_exists( 'gallery-category' ) ) {
				$tax = 'gallery-category';
			}

		}
		if(is_category()){
			$tax = 'category';
		}
		
		if (taxonomy_exists($tax) && ! is_post_type_archive()) {
			$terms = get_the_terms($this->post, $tax);
			if ($terms) {
				$list[] = [
					'name'	=> $terms[0]->name,
					'link'	=> get_term_link($terms[0])
				];
			} else {
				$ancestors = array_reverse(get_post_ancestors($this->post->ID));
				foreach ($ancestors as $ancestor) {
					$list[] = [
						'name'	=> get_the_title($ancestor),
						'link'	=> get_the_permalink($ancestor)
					];
				}
			}
		} else {
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			foreach ($ancestors as $ancestor) {
				$list[] = [
					'name'	=> get_the_title($ancestor),
					'link'	=> get_the_permalink($ancestor)
				];
			}
		}
		if (is_singular()) {
			$list[] = [
				'name'	=> $this->post->post_title,
				'link'	=> get_the_permalink($this->post)
			];
		}
		
		return apply_filters( 'hip_breadcrumb_list', $list );
	}
	
	public function render()
	{
		$crumbs = $this->getCrumbs();
		
		$html = '<div class="breadcrumbs-wrap">';
		$html .= '<ul class="breadcrumbs">';
		
		foreach ($crumbs as $index => $crumb) {
			$html .= '<li class="crumb">';
			if ($index == ( count($crumbs) - 1 )) {
				$html .= '<span class="current">'.$crumb['name'].'</span>';
			} else {
				$html .= '<a href="' . $crumb['link'] . '">' . $crumb['name'] . '</a></li>';
				$html .= '<li class="separator"><i class="fa fa-caret-right"></i>';
			}
			$html .= '</li>';
		}
		$html .= '</ul></div>';
		
		return $html;
	}
}
