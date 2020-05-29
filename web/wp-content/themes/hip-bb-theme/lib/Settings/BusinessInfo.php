<?php
namespace Hip\Theme\Settings;

/**
 * require files for hip businessinfo
 * @var string
 */
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
			\FLPageData::add_post_property('businessinfo_phone_number_link', array(
				'label'   => 'Phone Number Link',
				'group'   => 'general',
				'type'    => 'url',
				'getter'  => [ $this, 'getPhoneLink' ]
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
		$html = '<a class="phone-link" href="tel:';
		$html .= !empty($this->business_settings['businessinfo_phone_number']) ? $this->business_settings['businessinfo_phone_number'] : "Your phone number";
		$html .=  '">';
		$html .= !empty($this->business_settings['businessinfo_phone_number']) ? $this->business_settings['businessinfo_phone_number'] : "Your phone number";
		$html .= '</a>';

		return $html;
	}

	/**
	 * @return string Phone Number
	 */
	public function getPhone()
	{
		return !empty($this->business_settings['businessinfo_phone_number']) ? $this->business_settings['businessinfo_phone_number'] : true;
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
		ob_start();
		if(class_exists('Hip\Theme\Settings')):
			?>
			<?php if(!empty($this->business_settings['social_media'])): ?>
			<div class="hip-businessinfo-social_icons">
				<ul class="social-icons">
					<?php foreach ($this->business_settings['social_media'] as $media): ?>
						<li><a href="<?php echo !empty($media['link']) ? $media['link'] : '#'?>" target="_blank"><i class="<?php echo !empty($media['icon']) ? $media['icon'] : '';?>"></i></a></li>
					<?php endforeach;?>
				</ul>
			</div>
		<?php else: ?>
			<div class="hip-businessinfo-social_icons">
				<ul class="social-icons">
					<?php if(!empty($this->business_settings['businessinfo_facebook_link'])):?>
						<li class="facebook"><a href="<?php echo $this->business_settings['businessinfo_facebook_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_facebook_icon']) ? $this->business_settings['businessinfo_facebook_icon'] : 'fa fa-facebook';  ?>"></i></a></li>
					<?php endif; ?>

					<?php if(!empty($this->business_settings['businessinfo_instagram_link'])):?>
						<li class="instagram"><a href="<?php echo $this->business_settings['businessinfo_instagram_link'];?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_instagram_icon']) ? $this->business_settings['businessinfo_instagram_icon'] : 'fa fa-instagram';  ?>"></i></a></li>
					<?php endif; ?>

					<?php if(!empty($this->business_settings['businessinfo_google_link'])):?>
						<li class="googleplus"><a href="<?php echo $this->business_settings['businessinfo_google_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_google_icon']) ? $this->business_settings['businessinfo_google_icon'] : 'fa fa-google-plus';  ?>"></i></a></li>
					<?php endif; ?>
					<?php if(!empty($this->business_settings['businessinfo_twitter_link'])):?>
						<li class="twitter"><a href="<?php echo $this->business_settings['businessinfo_twitter_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_twitter_icon']) ? $this->business_settings['businessinfo_twitter_icon'] : 'fa fa-twitter';  ?>"></i></a></li>
					<?php endif; ?>
					<?php if(!empty($this->business_settings['businessinfo_linkedin_link'])):?>
						<li class="linkedin"><a href="<?php echo $this->business_settings['businessinfo_linkedin_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_linkedin_icon']) ? $this->business_settings['businessinfo_linkedin_icon'] : 'fa fa-linkedin';  ?>"></i></a></li>
					<?php endif; ?>
					<?php if(!empty($this->business_settings['businessinfo_youtube_link'])):?>
						<li class="youtube"><a href="<?php echo $this->business_settings['businessinfo_youtube_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_youtube_icon']) ? $this->business_settings['businessinfo_youtube_icon'] : 'fa fa-youtube';  ?>"></i></a></li>
					<?php endif; ?>
					<?php if(!empty($this->business_settings['businessinfo_pinterest_link'])):?>
						<li class="pinterest"><a href="<?php echo $this->business_settings['businessinfo_pinterest_link'];  ?>" target="_blank"><i class="<?php echo !empty($this->business_settings['businessinfo_pinterest_icon']) ? $this->business_settings['businessinfo_pinterest_icon'] : 'fa fa-pinterest';  ?>"></i></a></li>
					<?php endif; ?>

				</ul>
			</div>
		<?php endif;?>
		<?php
		endif;
		return ob_get_clean();
	}

	/**
	 * @return string Phone Number
	 */
	public function getPhoneLink()
	{
		return !empty($this->business_settings['businessinfo_phone_number']) ? 'tel:'.$this->business_settings['businessinfo_phone_number'] : '#';
	}
}
