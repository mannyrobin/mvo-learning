<?php 

class HipCTAModule extends \FLBuilderModule
{
	public function __construct()
	{
		parent::__construct( [
			'name'			=> 'Hip Call-to-Action',
			'description'	=> 'Add a CTA anywhere in your content.',
			'category'		=> 'Hip Modules'
		] );
	}
	
	public static function getCTA()
	{
		$ctas = get_posts([
			'numberposts' => -1,
			'post_type'     => 'hipcta_cta'
		]);
        
		$select_options = [];
		
		foreach ($ctas as $cta) {
			$select_options[ $cta->ID ] = $cta->post_title;
		}
		
		return $select_options;
	}
}

FLBuilder::register_module( 'HipCTAModule', [
	'general'	=> [
		'title'		=> 'General',
		'sections'	=> [
			'general'		=> [
				'title'			=> 'General Settings',
				'fields'		=> [
					'cta'				=> [
						'type'			=> 'select',
						'label'			=> 'Select Call-to-Action',
						'options'		=> HipCTAModule::getCTA()
					]
				]
			]
		]
	]
] );
