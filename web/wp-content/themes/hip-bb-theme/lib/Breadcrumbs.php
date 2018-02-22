<?php
namespace HipBBTheme;

class Breadcrumbs
{
	protected $post;
	
	public function __construct(\WP_Post $post)
	{
		$this->post = $post;
	}
	
	public function getCrumbs()
	{
		$list = [];
		
		$post_type = get_post_type($this->post);
		$post_type_object = get_post_type_object($post_type);
		
		if ($post_type == 'page') {
			$list[] = [
				'name'	=> 'Home',
				'link'	=> home_url('/')
			];
		} else {
			$list[] = [
				'name'	=> $post_type_object->label,
				'link'	=> get_post_type_archive_link($post_type)
			];
		}
		
		if ($post_type !== 'post') {
			$tax = $post_type . '_category';
		} else {
			$tax = 'category';
		}
		
		if (taxonomy_exists($tax)) {
			$terms = get_the_terms($this->post, $tax);
			if ($terms) {
				$list[] = [
					'name'	=> $terms[0]->name,
					'link'	=> get_term_link($terms[0])
				];
			}
		}
		
		$list[] = [
			'name'	=> $this->post->post_title,
			'link'	=> get_the_permalink($this->post)
		];
		
		return $list;
	}
	
	public function render()
	{
		$crumbs = $this->getCrumbs();
		
		$html = '<div class="breadcrumbs-wrap container">';
		$html .= '<ul class="breadcrumbs">';
		
		foreach ($crumbs as $index => $crumb) {
			$html .= '<li class="crumb">';
			if ($index == ( count($crumbs) - 1 )) {
				$html .= $crumb['name'];
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
