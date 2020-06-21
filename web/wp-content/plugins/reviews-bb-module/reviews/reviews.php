<?php

class ReviewsBBModule extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'            => 'Review Us',
            'description'     => 'Allow Customer to review our services.',
            'category'        => __('Hip Modules', 'fl-builder'),
            'dir'             => ReviewDir . 'reviews/',
            'url'             => ReviewURL . 'reviews/',
            'partial_refresh' => true,
        ]);

        $this->add_css('reviews-bb-module-css', $this->url . 'style.css');
    }

    public function get_icon($icon = '')
    {
        return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
            <path d="M12.72 2c0.15-0.020 0.26 0.020 0.41 0.070 0.56 0.19 0.83 0.79 0.66 1.35-0.17 0.55-1 3.040-1 3.58 0 0.53 0.75 1 1.35 1h3c0.6 0 1 0.4 1 1s-2 7-2 7c-0.17 0.39-0.55 1-1 1h-9.14v-9h2.14c0.41-0.41 3.3-4.71 3.58-5.27 0.21-0.41 0.6-0.68 1-0.73zM2 8h2v9h-2v-9z"></path>
        </svg>';
    }
}

FLBuilder::register_module('ReviewsBBModule', array(
    'positive-reviews' => [
        'title'    => 'Positive Reviews',
        'sections' => [
            'general' => [
                'title'  => 'General',
                'fields' => [
                    'positive_intro' => [
                        'type'          => 'editor',
                        'media_buttons' => true,
                        'rows'          => 10
                    ]
                ]
            ]
        ]
    ],
    'negative-reviews' => [
        'title'    => 'Negative Reviews',
        'sections' => [
            'general' => [
                'title'  => 'General',
                'fields' => [
                    'negative_intro' => [
                        'type'          => 'editor',
                        'media_buttons' => true,
                        'rows'          => 10
                    ]
                ]
            ]
        ]
    ],
    'review_sites'     => [
        'title'    => __('Review Sites', 'fl-builder'),
        'sections' => [
            'general' => [
                'title'  => '',
                'fields' => [
                    'review_site' => [
                        'type'         => 'form',
                        'label'        => __('Review Site', 'fl-builder'),
                        'form'         => 'review_site_form',
                        'preview_text' => 'name',
                        'multiple'     => true,
                    ],
                ],
            ],
        ],
    ],
));

FLBuilder::register_settings_form('review_site_form',[
    'title' => __('Review site', 'fl-builder'),
    'tabs'  =>[
        'general' => [
            'title'    =>'',
            'sections' => [
                'general' => [
                    'title'  => 'Site details',
                    'fields' => [
                        'name'     => [
                            'type'  => 'text',
                            'label' => 'Name',
                            'minlength' => '3'
                        ],
                        'logo'     => [
                            'type'  => 'photo',
                            'label' => 'Logo'
                        ],
                        'url'      => [
                            'type'  => 'text',
                            'label' => 'Review URL'
                        ],
                        'instruction' => [
                            'label'         => 'Instructions',
                            'type'          => 'editor',
                            'media_buttons' => true,
                            'rows'          => 30
                        ],
                        'featured' => [
                            'type'          => 'select',
                            'label'         => __( 'Featured review site', 'fl-builder' ),
                            'default'       => false,
                            'options'       => array(
                                false      => __( 'No', 'fl-builder' ),
                                true      => __( 'Yes', 'fl-builder' )
                            )
                        ],
                    ]
                ],
            ]
        ]
    ]
]);

