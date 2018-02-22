<?php
use Helpers\PHPColors;
/**
 * require files for hip businessinfo
 * @var string
 */
require_once __DIR__ . '/inc/Settings.php';
require_once __DIR__ . '/inc/SettingsPage.php';
require_once __DIR__ . '/inc/API.php';

class BusinessInfo
{
	/**
	 * assets directory
	 * @var string
	 */
	protected $assets;
	/**
	 * saved business settings
	 * @var array
	 */
	private $business_settings;

	/**
	 * method __construct()
	 * set values in properties
	 * @uses add_action(), add_shortcode() wp functions
	 */
	public function __construct()
	{
		$this->assets = get_template_directory_uri() . '/dist/';
		$this->business_settings = BusinessInfo\Settings::getSettings();
		;
		add_action('init', [$this, 'init']);
		add_action('rest_api_init', [$this, 'rest_init']);
		add_shortcode('hip_phone', [$this, 'hip_businessinfo_phone']);
		add_shortcode('hip_address', [$this, 'hip_businessinfo_address']);
		add_shortcode('hip_social_icons', [$this, 'hip_businessinfo_social_icons']);
		if(class_exists('FLPageData')){
            \FLPageData::add_post_property('businessinfo_phone_number', array(
                'label'   => 'Business Info Phone Number',
                'group'   => 'general',
                'type'    => 'string',
                'getter'  => [ $this, 'getPhone' ]
            ));
        }
	}

	/**
	 * initialize business info settings page in admin
	 * @uses BusinessInfo\SettingsPage class
	 * BusinessInfo namespace
	 */

	public function init()
	{
		new BusinessInfo\SettingsPage($this->assets);
	}

	/**
	 * initialize business info settings api
	 * @uses BusinessInfo\API class
	 */

	public function rest_init()
	{
		$api = new BusinessInfo\API();
		$api->addRoutes();
	}

	/**
	 * business info phone number
	 * @uses hip_businessinfo_phone() shortcode
	 * @return string
	 */

	public function hip_businessinfo_phone()
	{
		$html = '<a class="phone-link" href="tel:' . $this->business_settings['businessinfo_phone_number'] . '">';
		$html .= $this->business_settings['businessinfo_phone_number'] . '</a>';

		return $html;
	}

	/**
	 * @return string Phone Number
	 */
	public function getPhone()
	{
		return $this->business_settings['businessinfo_phone_number'];
	}

	/**
	 * business info Address
	 * @uses hip_businessinfo_address() shortcode
	 * @return string
	 */

	public function hip_businessinfo_address()
	{
		ob_start();
		?>
		<span class="hip-businessinfo-address">
			<?php
				$hip_address = nl2br($this->business_settings['businessinfo_address']);
				echo '<span>'.$hip_address.'</span>';
			?>
		</span>
		<?php
		return ob_get_clean();
	}

	/**
	 * business info Social Icons
	 * @uses hip_businessinfo_social_icons() shortcode
	 * @return string
	 */

	public function hip_businessinfo_social_icons()
	{
		$general_settings = General\Settings::getSettings();
		ob_start();
		?>
		<div class="hip-businessinfo-social_icons">
			<ul class="social-icons">
                <?php if(!empty($this->business_settings['businessinfo_facebook_link'])):?>
                    <li class="facebook"><a href="<?php echo $this->business_settings['businessinfo_facebook_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_facebook_icon']) ? $this->business_settings['businessinfo_facebook_icon'] : 'fa fa-facebook';  ?>"></i></a></li>
                <?php endif; ?>

                <?php if(!empty($this->business_settings['businessinfo_instagram_link'])):?>
                    <li class="instagram"><a href="<?php echo $this->business_settings['businessinfo_instagram_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_instagram_icon']) ? $this->business_settings['businessinfo_instagram_icon'] : 'fa fa-instagram';  ?>"></i></a></li>
                <?php endif; ?>

                <?php if(!empty($this->business_settings['businessinfo_google_link'])):?>
                    <li class="googleplus"><a href="<?php echo $this->business_settings['businessinfo_google_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_google_icon']) ? $this->business_settings['businessinfo_google_icon'] : 'fa fa-google-plus';  ?>"></i></a></li>
                <?php endif; ?>
                <?php if(!empty($this->business_settings['businessinfo_twitter_link'])):?>
                    <li class="twitter"><a href="<?php echo $this->business_settings['businessinfo_twitter_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_twitter_icon']) ? $this->business_settings['businessinfo_twitter_icon'] : 'fa fa-twitter';  ?>"></i></a></li>
                <?php endif; ?>
                <?php if(!empty($this->business_settings['businessinfo_linkedin_link'])):?>
                    <li class="linkedin"><a href="<?php echo $this->business_settings['businessinfo_linkedin_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_linkedin_icon']) ? $this->business_settings['businessinfo_linkedin_icon'] : 'fa fa-linkedin';  ?>"></i></a></li>
                <?php endif; ?>
                <?php if(!empty($this->business_settings['businessinfo_youtube_link'])):?>
                    <li class="youtube"><a href="<?php echo $this->business_settings['businessinfo_youtube_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_youtube_icon']) ? $this->business_settings['businessinfo_youtube_icon'] : 'fa fa-youtube';  ?>"></i></a></li>
                <?php endif; ?>
                <?php if(!empty($this->business_settings['businessinfo_pinterest_link'])):?>
                    <li class="pinterest"><a href="<?php echo $this->business_settings['businessinfo_pinterest_link'];  ?>"><i class="<?php echo !empty($this->business_settings['businessinfo_pinterest_icon']) ? $this->business_settings['businessinfo_pinterest_icon'] : 'fa fa-pinterest';  ?>"></i></a></li>
                <?php endif; ?>

			</ul>
		</div>
		<style>
            .hip-businessinfo-social_icons > ul.social-icons{
                margin: 0;
                padding: 0;
            }
			.hip-businessinfo-social_icons > ul.social-icons li {
                display: inline-block;
                list-style: none;
			}
			.hip-businessinfo-social_icons > ul.social-icons li + li{
                margin-left: 5px;
			}
            .hip-businessinfo-social_icons > ul.social-icons li a{

                width: <?php echo $this->business_settings['social_media_width'] ? $this->business_settings['social_media_width'] : '36px'; ?>;
                text-align: center;
                height: <?php echo $this->business_settings['social_media_height'] ? $this->business_settings['social_media_height'] : '36px'; ?>;
                font-size: <?php echo $this->business_settings['icon_font_size'] ? $this->business_settings['icon_font_size'] : '18px'; ?>;
                line-height: <?php echo $this->business_settings['social_media_height'] ? $this->business_settings['social_media_height'] : '36px'; ?>;
                border-radius: 50%;
                display: block;
                <?php if(empty($this->business_settings['social_brand_styles'])):?>
                    <?php if(array_key_exists('social_icon_bg', $this->business_settings)): ?>
                        background-color: <?php echo $this->business_settings['social_icon_bg'] ?>;
                    <?php else : ?>
                        background-color: <?php echo $general_settings['link_color'] ? $general_settings['link_color'] : '#0066ff' ; ?>;
                    <?php endif; ?>
                    <?php if(array_key_exists('social_icon_color', $this->business_settings)): ?>
                        color: <?php echo $this->business_settings['social_icon_color'] ?>;
                    <?php else : ?>
                        color: #fff;
                    <?php endif; ?>
                <?php endif; ?>
            }
            .hip-businessinfo-social_icons > ul.social-icons li a:hover {
                <?php if(empty($this->business_settings['social_brand_styles'])):?>
                    <?php if(array_key_exists('social_icon_hover_bg', $this->business_settings)): ?>
                        background-color: <?php echo $this->business_settings['social_icon_hover_bg'] ?>;
                    <?php else : ?>
                        background-color: <?php echo $general_settings['link_hover_color'] ? $general_settings['link_hover_color'] : '#0033cc' ; ?>;
                    <?php endif; ?>
                    <?php if(array_key_exists('social_icon_hover_color', $this->business_settings)): ?>
                        color: <?php echo $this->business_settings['social_icon_hover_color'] ?>;
                    <?php else : ?>
                        color: #fff;
                    <?php endif; ?>
                <?php endif;  ?>
				transition: all 0.3s ease;
			}

            <?php
             if(array_key_exists('social_brand_styles', $this->business_settings)){
                 if(!empty($this->business_settings['social_brand_styles'])){
            ?>
                .hip-businessinfo-social_icons > ul.social-icons li a{
                    color: #fff;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.facebook a{
                    background-color: #3b5998;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.facebook:hover a{
                    background-color: <?php (new PHPColors\Color('#3b5998'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.twitter a{
                    background-color: #55acee;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.twitter:hover a{
                    background-color: <?php (new PHPColors\Color('#55acee'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.instagram a{
                    background-color: #cd486b;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.instagram:hover a{
                    background-color: <?php (new PHPColors\Color('#cd486b'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.linkedin a{
                    background-color: #007bb5;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.linkedin:hover a{
                    background-color: <?php (new PHPColors\Color('#007bb5'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.youtube a{
                    background-color: #ff0000;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.youtube:hover a{
                    background-color: <?php (new PHPColors\Color('#ff0000'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.googleplus a{
                    background-color: #dd4b39;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.googleplus:hover a{
                    background-color: <?php (new PHPColors\Color('#dd4b39'))->darken(5) ?>;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.pinterest a{
                    background-color: #bd081c;
                }
                .hip-businessinfo-social_icons > ul.social-icons li.pinterest:hover a{
                    background-color: <?php (new PHPColors\Color('#bd081c'))->darken(5) ?>;
                }
              <?php }  } ?>
		</style>
		<?php
		return ob_get_clean();
	}
}//End Class Business Info
new BusinessInfo();
