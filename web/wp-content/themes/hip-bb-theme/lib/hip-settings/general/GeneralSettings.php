<?php
require_once __DIR__ . '/inc/Settings.php';
require_once __DIR__ . '/inc/SettingsPage.php';
require_once __DIR__ . '/inc/API.php';

class GeneralSettings
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
     * all google fonts
     * @var array
     */
    private $google_fonts;

    /**
     * method __construct()
     * set values in properties
     * @uses add_action(), add_shortcode() wp functions
     */
    public function __construct()
    {
        $this->assets = get_template_directory_uri() . '/dist/';
        $this->settings = General\Settings::getSettings();
        $this->_build_css();
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
        $settingsPage = new General\SettingsPage($this->assets);
        $this->google_fonts = $settingsPage->google_fonts;
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
        ob_start();
        ?>
        <link href="<?php echo esc_url('https://fonts.googleapis.com/css?family=' . $this->_get_selected_fonts()); ?>"
              rel="stylesheet">
        <style id="hip-settings-css" type="text/css">
            <?php echo $this->_build_css();?>
            .fl-module-button .fl-module-content .fl-button-wrap a.fl-button span, .fl-module-button .fl-module-content .fl-button-wrap a.fl-button:hover span {
                color: inherit;
            }
        </style>
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
                return $this->settings['svg_logo'];
            } else {
                return '<img src="' . $this->settings['logo_img'] . '" alt="logo">';
            }
        } else {
            if ($this->settings['alt_logo_type'] == 'alt_svg') {
                return $this->settings['alt_svg_logo'];
            } else {
                return '<img src="' . $this->settings['alt_logo_img'] . '" alt="logo">';
            }
        }
    }

    /**
     * get selected fonts by user
     * @return string
     */

    private function _get_selected_fonts()
    {
        $font_families = '';
        $fonts = [
            'body_font',
            'header_font'
        ];
        $selected = array();
        foreach ($this->settings as $key => $val) {
            if (!in_array($val, $selected)) {
                if (in_array($key, $fonts)) {
                    $font_families .= str_replace(' ', '+', $val);
                    $font_families .= ':'. $this->_get_font_weights($this->google_fonts[$val]['weights']).'|';
                    array_push($selected, $val);
                }
            }

        }
        return rtrim($font_families, '|');
    }

    /**
     * prepare css according to settings
     * @uses _get_css_font_weight() method
     * @return string
     */

    private function _build_css()
    {
        $css = '';
        $css .= 'body,p,ul,ol,form input,form textarea,form select,form radio, form checkbox,blockquote,.fl-rich-text p{';
        $css .= 'font-family: "' . $this->settings['body_font'] . '", sans-serif;';
        if (!empty($this->settings['body_font_size'])) {
            $css .= 'font-size: ' . $this->settings['body_font_size'] . ';';
        }
        if (!empty($this->settings['body_font_weight'])) {
            $css .= $this->_get_css_font_weight($this->settings['body_font_weight']);
        }
        if (!empty($this->settings['body_font_color'])) {
            $css .= 'color: ' . $this->settings['body_font_color'] . ';';
        }
        $css .= '}';

        for ($i = 1; $i <= 6; $i++) {
            $css .= 'h' . $i . ',.fl-module-heading h' . $i . '.fl-heading{';
            if (!empty($this->settings['header_font'])) {
                $css .= 'font-family: "' . $this->settings['header_font'] . '", sans-serif;';
            }
            if (!empty($this->settings['header_font_weight'])) {
                $css .= $this->_get_css_font_weight($this->settings['header_font_weight']);
            }
            $css .= '}';
        }
        if (!empty($this->settings['link_color'])) {
            $css .= 'a, .fl-builder-content .fl-button-wrap .fl-button{ color: ' . $this->settings['link_color'] . ';}';
        }
        if (!empty($this->settings['link_hover_color'])) {
            $css .= 'a:hover, .fl-builder-content .fl-button-wrap .fl-button:hover,.fl-button-wrap a:focus{ color: ';
            $css .= $this->settings['link_hover_color'];
            $css .= ';}';
        }
        if (!empty($this->settings['primary_color'])) {
            $css .= '.fl-menu > .menu > li > a,.fl-menu > .menu > li > .fl-has-submenu-container > a{color: '. $this->settings['primary_color'].';}';
            $css .= '.primary-heading .fl-module-content .fl-heading,';
            $css .= '.fl-module h1[class^="fl"][class$="title"],.fl-module h2[class^="fl"][class$="title"],.fl-module h3[class^="fl"][class$="title"],.fl-module h4[class^="fl"][class$="title"].fl-module h5[class^="fl"][class$="title"],.fl-module h6[class^="fl"][class$="title"],';
            $css .= '.fl-module h1,.fl-module h2,.fl-module h3,.fl-module h4,.fl-module h5,.fl-module h6,';
            $css .= ' .text-primary .fl-rich-text p, .primary-txt, .text-primary .fl-module-content div[class^="fl-post"][class$="content"] p,.text-primary .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-primary .fl-module-content div[class^="fl-"][class$="text"] p';
            $css .= '{color:' . $this->settings['primary_color'] . ';';
            $css .= '}';
            $css .= '.bg-primary, .primary-bg .fl-row-content-wrap, .button-primary,.fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button,.primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]{';
            $css .= 'background-color:' . $this->settings['primary_color'] . ';';
            $css .= '}';
        }
        if (!empty($this->settings['primary_highlight_color'])) {
            $css .= '.bg-primary-highlight, .primary-bg-highlight .fl-row-content-wrap, .button-primary:hover, .button-primary:focus, .fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button:hover, .primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]:hover,.fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button:focus, .primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:focus,.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:focus,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]:focus{';
            $css .= 'background:' . $this->settings['primary_highlight_color'] . ';}';
            $css .= ' .text-primary-highlight .fl-rich-text p, .primary-txt-highlight, .text-primary-highlight .fl-module-content div[class^="fl-post"][class$="content"] p,.text-primary-highlight .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-primary-highlight .fl-module-content div[class^="fl-"][class$="text"] p';
            $css .= '{color:'. $this->settings['primary_highlight_color'] .';}';
        }
        if (!empty($this->settings['secondary_color'])) {
            $css .= '.secondary-heading .fl-module-content .fl-heading,.fl-module.secondary-heading h1[class^="fl"][class$="title"],.fl-module.secondary-heading h2[class^="fl"][class$="title"],.fl-module.secondary-heading h3[class^="fl"][class$="title"],.fl-module.secondary-heading h4[class^="fl"][class$="title"].fl-module.secondary-heading h5[class^="fl"][class$="title"],.fl-module.secondary-heading h6[class^="fl"][class$="title"]';
            $css .= ' .text-secondary .fl-rich-text p, .secondary-txt, .text-secondary .fl-module-content div[class^="fl-post"][class$="content"] p,.text-secondary .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-secondary .fl-module-content div[class^="fl-"][class$="text"] p';
            $css .= '{color:' . $this->settings['secondary_color'] . ';';
            $css .= '}';
            $css .= '.bg-secondary, .secondary-bg .fl-row-content-wrap, .button-secondary, .fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button,.secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]{';
            $css .= 'background-color:' . $this->settings['secondary_color'] . ';';
            $css .= '}';
        }
        if (!empty($this->settings['secondary_highlight_color'])) {
            $css .= '.bg-secondary-highlight, .secondary-bg-highlight .fl-row-content-wrap, .button-secondary:hover, .button-secondary:focus,.fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button:hover, .secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]:hover,.fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button:focus, .secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:focus,.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:focus,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]:focus{';
            $css .= 'background-color:' . $this->settings['secondary_highlight_color'] . ';}';

            $css .= ' .text-secondary-highlight .fl-rich-text p, .secondary-txt-highlight, .text-secondary-highlight .fl-module-content div[class^="fl-post"][class$="content"] p,.text-secondary-highlight .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-secondary-highlight .fl-module-content div[class^="fl-"][class$="text"] p';
            $css .= '{color:' . $this->settings['secondary_highlight_color'] . ';}';

        }
        if (!empty($this->settings['btn_color']) || !empty($this->settings['btn_bg_color'])) {
            $css .= '.btn-general,.fl-builder-content .general-btn .fl-module-content .fl-button-wrap a.fl-button,.general-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.general-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.general-btn .fl-module-content form button[type="submit"]{ color: ';
            $css .= $this->settings['btn_color'] . ';';
            $css .= 'background:' . $this->settings['btn_bg_color'] . ';';
            if ($this->settings['btn_border'] != 'none') {
                $css .= 'border-style: solid;';
                if ($this->settings['btn_border'] == 'all') {
                    $css .= 'border-width:';
                    $css .= !empty($this->settings['btn_border_width']) ? $this->settings['btn_border_width'] . 'px;' : '1px;';
                } else if ($this->settings['btn_border'] == 'btm') {
                    $css .= 'border-width:';
                    $css .= !empty($this->settings['btn_border_width']) ? '0 0 ' . $this->settings['btn_border_width'] . 'px;' : '0 0 1px;';
                }
                $css .= !empty($this->settings['btn_border_color']) ? 'border-color:' . $this->settings['btn_border_color'] . ';' : 'border-color:' . $this->settings['btn_bg_color'] . ';';

            }
            if (!empty($this->settings['btn_radius'])) {
                $css .= '-webkit-border-radius:' . $this->settings['btn_radius'] . 'px;';
                $css .= 'border-radius:' . $this->settings['btn_radius'] . 'px;';
            }
            $css .= '}';
            if (!empty($this->settings['btn_hover_color']) || !empty($this->settings['btn_bg_hover_color'])) {
                $css .= '.btn-general:hover,.fl-builder-content .general-btn .fl-module-content .fl-button-wrap a.fl-button:hover,.general-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.general-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.general-btn .fl-module-content form button[type="submit"]:hover{';
                if (!empty($this->settings['btn_hover_color'])) {
                    $css .= 'color:' . $this->settings['btn_hover_color'] . ';';
                }
                if (!empty($this->settings['btn_bg_hover_color'])) {
                    $css .= 'background-color:' . $this->settings['btn_bg_hover_color'] . ';';
                }
                if (!empty($this->settings['btn_border_hover_color'])) {
                    $css .= 'border-color:' . $this->settings['btn_border_hover_color'] . ';';
                }
                $css .= '}';
            }
        }

        return $css;
    }

    /**
     * prepare font weight for css
     * @param string
     * @return string
     */

    private function _get_css_font_weight($weight)
    {
        $styles = '';
        if (stripos($weight, 'i')) {
            $styles .= 'font-weight:' . str_replace('i', '', $weight) . ';';
            $styles .= 'font-style:italic' . ';';
        } else {
            $styles .= 'font-weight:' . $weight . ';';
        }

        return $styles;
    }

    /**
     * prepare font weights for pulling fonts from google
     * @param array
     * @return string
     */

    private function _get_font_weights($weights)
    {
        $required = [
            '300',
            '300 (italic)',
            'Regular',
            'Regular (italic)',
            '500',
            '700',
            '700 (italic)'
        ];
        $weights_str = '';
        foreach ($weights as $weight) {
            if (in_array($weight, $required)) {
                switch ($weight){
                    case 'Regular':
                        $weights_str .= '400,';
                        break;
                    case 'Regular (italic)':
                        $weights_str .= '400i,';
                        break;
                    default:
                        if(stripos($weight,'(italic)')){
                            $weights_str .= str_replace(' (italic)','i',$weight).',';
                        }else{
                            $weights_str .= $weight.',';
                        }

                }
            }
        }

        return rtrim($weights_str,',');
    }

}

$general_settings = new GeneralSettings();
