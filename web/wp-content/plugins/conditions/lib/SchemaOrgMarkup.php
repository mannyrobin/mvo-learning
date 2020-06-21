<?php

namespace Hip\Conditions;

class SchemaOrgMarkup
{
	public function addMarkupToHeader($post)
	{
		if (! $this->isCondition()) {
			return;
		}

		$tsf = ( function_exists('the_seo_framework') ) ?  \the_seo_framework() : null;
		
		echo $this->getWebPageTag($post, $tsf);
	}

	public function getWebPageTag($post, $tsf = null)
	{
		return '<script type="application/ld+json">' . \json_encode($this->getWebPageObject($post, $tsf)) . '</script>';
	}

	public function getConditionObject($post)
	{
		$condition = [
			"@type"             => "MedicalCondition",
			"name"              => \get_the_title($post)
		];

		return (object)$condition;
	}

	public function getWebPageObject($post, $tsf = null)
	{
		$page = [
			"@context"          => "http://schema.org",
			"@type"             => "MedicalWebPage",
			"about"             => $this->getConditionObject($post),
			"name"              => \get_the_title($post),
			"datePublished"     => $this->getPublishedDate($post),
			"dateModified"      => $this->getModifiedDate($post),
			"audience"          => "http://schema.org/Patient",
			"author"            => $this->getAuthor($post),
			"image"             => \get_the_post_thumbnail_url($post, 'large'),
			'url'               => \get_the_permalink($post)
		];

		if (isset($tsf)) {
			if(method_exists($tsf,'description_from_cache')){
				$page['description'] = \esc_attr($tsf->description_from_cache());
			}else{
				$page['description'] = \esc_attr($tsf->get_description());
			}
			$page['publisher'] = [
				"@type"     => 'Organization',
				"name"      => $this->getOrgName($post, $tsf),
				"logo"      => \get_site_icon_url(32)
			];
		}

		if ( class_exists( '\Hip\Theme\Settings\BusinessInfo' ) ){

			$settings = \Hip\Theme\Settings\BusinessInfo\Settings::getSettings();

			if ( in_array( 'businessinfo_specialty', $settings ) ) {
				$pages['specialty'] = "http://schema.org/" . $settings['businessinfo_specialty'];
			}
		}

		return (object)$page;
	}

	protected function getPublishedDate($post)
	{
		$time = strtotime($post->post_date);

		return \esc_attr(date('c', $time));
	}

	protected function getModifiedDate($post)
	{
		$time = strtotime($post->post_modified);

		return \esc_attr(date('c', $time));
	}
	
	protected function getAuthor($post)
	{
		$author = \get_userdata($post->post_author);

		return (object) [
			"@type"     => 'Person',
			"name"      => \esc_attr($author->display_name)
		];
	}
	
	protected function getOrgName($post, $tsf)
	{
		return (string) \apply_filters('the_seo_framework_articles_name', $tsf->get_option('knowledge_name')) ?: $tsf->get_blogname();
	}
	
	protected function isCondition()
	{
		if (is_single() && get_post_type() == 'conditions') {
			return true;
		}

		return false;
	}
}
