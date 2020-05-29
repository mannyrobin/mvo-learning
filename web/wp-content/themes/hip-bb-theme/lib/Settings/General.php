<?php
namespace Hip\Theme\Settings;

class General
{
    /**
     * assets directory
     * @var string
     */
    protected $assets;
    /**
     * saved general settings
     * @var array
     */
    private $settings;

    /**
     * @var GoogleFontsHandler
     */
    private $font_handler;

    /**
     * method __construct()
     * set values in properties
     * @uses add_action(), add_shortcode() wp functions
     */
    public function __construct()
    {
        $this->assets = get_template_directory_uri() . '/dist/';
        $this->settings = General\Settings::getSettings();
        $this->font_handler = new \Hip\Theme\GoogleFontsHandler();
        add_action('init', [$this, 'init']);
        add_action('rest_api_init', [$this, 'rest_init']);
        add_shortcode('hip_logo', [$this, 'render_logo']);
        add_shortcode('hip_alt_logo', [$this, 'render_alt_logo']);
        add_action('wp_head', [$this, 'render_css']);
    }

    /**
     * initialize settings page in admin
     * @uses General\SettingsPage class
     */

    public function init()
    {
        $settingsPage = new General\SettingsPage($this->assets, $this->font_handler);
    }

    /**
     * initialize general settings api
     * @uses General\API class
     */

    public function rest_init()
    {
        $api = new General\API();
        $api->addRoutes();
    }

    /**
     * render logo
     * @uses _get_logo() method
     * @return mixed
     */

    public function render_logo()
    {
        ob_start();
        ?>
        <div class="logo-wrap">
            <a href="<?php echo get_bloginfo('url'); ?>">
                <?php echo $this->_get_logo(); ?>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * render alternative logo
     * @uses _get_logo() method
     * @return mixed
     */

    public function render_alt_logo()
    {
        ob_start();
        ?>
        <div class="logo-wrap">
            <a href="<?php echo get_bloginfo('url'); ?>">
                <?php echo $this->_get_logo(true); ?>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * render css for frontend
     * @uses _get_selected_fonts() method
     * @uses _build_css() method
     * @return mixed
     */

    public function render_css()
    {
        $font_link = $this->font_handler->getStyleSheetLink( $this->_get_selected_fonts() );
        ob_start();
        ?>
        <link rel="stylesheet" href="<?php echo $font_link ?>">
        <?php
        return ob_get_flush();
    }

    //========= Helper methods ===========\\

    /**
     * get logo from settings
     * @param bool (optional, for getting alternative logo)
     * @return string
     */

    private function _get_logo($alt = false)
    {
        if ($alt === false) {
            if ($this->settings['logo_type'] == 'svg') {
                return !empty($this->settings['svg_logo']) ? $this->settings['svg_logo'] : '<h3>Your logo</h3>';
            } else {
            	if(!empty($this->settings['logo_img'])){
					return '<img src="' . $this->settings['logo_img'] . '" alt="logo">';
				}else{
            		return '<h3>Your logo</h3>';
				}

            }
        } else {
            if ($this->settings['alt_logo_type'] == 'alt_svg') {
                return !empty($this->settings['alt_svg_logo']) ? $this->settings['alt_svg_logo'] : '<h3>Your logo</h3>';
            } else {
				if(!empty($this->settings['alt_logo_img'])){
					return '<img src="' . $this->settings['alt_logo_img'] . '" alt="logo">';
				}else{
					return '<h3>Your logo</h3>';
				}
            }
        }
    }

    /**
     * get selected fonts by user
     * @return array
     */

    private function _get_selected_fonts()
    {

        return [
            (object)[
                'family'    => $this->settings['body_font'],
                'weight'    => $this->settings['body_font_weight']
            ],
            (object)[
                'family'    => $this->settings['header_font'],
                'weight'    => $this->settings['header_font_weight']
            ]
        ];
    }
}
