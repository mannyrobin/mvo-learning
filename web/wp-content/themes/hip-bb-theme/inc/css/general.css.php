<?php
$css = '';
$css .= 'body,p,ul,ol,form input,form textarea,form select,form radio, form checkbox,blockquote,.fl-rich-text p{';
$css .= 'font-family: "' . $hip_settings->settings['body_font'] . '", sans-serif;';
if (!empty($hip_settings->settings['body_font_size'])) {
	$css .= 'font-size: ' . $hip_settings->settings['body_font_size'] . ';';
}
if (!empty($hip_settings->settings['body_font_weight'])) {
    $weight = $hip_settings->settings['body_font_weight'];
    if ( stripos($weight, 'i') ) {
        $css .= 'font-weight:' . str_replace('i', '', $weight) . ';';
        $css .= 'font-style: italic;';
    } else {
        $css .= 'font-weight:' . $weight . ';';
    }
}
if (!empty($hip_settings->settings['body_font_color'])) {
	$css .= 'color: ' . $hip_settings->settings['body_font_color'] . ';';
}
$css .= '}';

for ($i = 1; $i <= 6; $i++) {
	$css .= 'h' . $i . ',.fl-module-heading h' . $i . '.fl-heading{';
	if (!empty($hip_settings->settings['header_font'])) {
		$css .= 'font-family: "' . $hip_settings->settings['header_font'] . '", sans-serif;';
	}
	if (!empty($hip_settings->settings['header_font_weight'])) {
        $weight = $hip_settings->settings['header_font_weight'];
        if ( stripos($weight, 'i') ) {
            $css .= 'font-weight:' . str_replace('i', '', $weight) . ';';
            $css .= 'font-style: italic;';
        } else {
            $css .= 'font-weight:' . $weight . ';';
        }
	}
	$css .= '}';
}
if (!empty($hip_settings->settings['link_color'])) {
	$css .= 'a, .fl-builder-content .fl-button-wrap .fl-button{ color: ' . $hip_settings->settings['link_color'] . ';}';
}
if (!empty($hip_settings->settings['link_hover_color'])) {
	$css .= 'a:hover, .fl-builder-content .fl-button-wrap .fl-button:hover,.fl-button-wrap a:focus{ color: ';
	$css .= $hip_settings->settings['link_hover_color'];
	$css .= ';}';
}
if (!empty($hip_settings->settings['primary_color'])) {
	$css .= '.fl-menu > .menu > li > a,.fl-menu > .menu > li > .fl-has-submenu-container > a{color: '. $hip_settings->settings['primary_color'].';}';
	$css .= '.primary-heading .fl-module-content .fl-heading,';
	$css .= '.fl-module h1[class^="fl"][class$="title"],.fl-module h2[class^="fl"][class$="title"],.fl-module h3[class^="fl"][class$="title"],.fl-module h4[class^="fl"][class$="title"].fl-module h5[class^="fl"][class$="title"],.fl-module h6[class^="fl"][class$="title"],';
	$css .= '.fl-module h1,.fl-module h2,.fl-module h3,.fl-module h4,.fl-module h5,.fl-module h6,';
	$css .= ' .text-primary .fl-rich-text p, .primary-txt, .text-primary .fl-module-content div[class^="fl-post"][class$="content"] p,.text-primary .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-primary .fl-module-content div[class^="fl-"][class$="text"] p';
	$css .= '{color:' . $hip_settings->settings['primary_color'] . ';';
	$css .= '}';
	$css .= '.bg-primary, .primary-bg .fl-row-content-wrap, .button-primary,.fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button,.primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]{';
	$css .= 'background-color:' . $hip_settings->settings['primary_color'] . ';';
	$css .= '}';
}
if (!empty($hip_settings->settings['primary_highlight_color'])) {
	$css .= '.bg-primary-highlight, .primary-bg-highlight .fl-row-content-wrap, .button-primary:hover, .button-primary:focus, .fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button:hover, .primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]:hover,.fl-builder-content .primary-btn .fl-module-content .fl-button-wrap a.fl-button:focus, .primary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:focus,.primary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:focus,.fl-builder-content div.primary-btn .fl-module-content form button[type="submit"]:focus{';
	$css .= 'background:' . $hip_settings->settings['primary_highlight_color'] . ';}';
	$css .= ' .text-primary-highlight .fl-rich-text p, .primary-txt-highlight, .text-primary-highlight .fl-module-content div[class^="fl-post"][class$="content"] p,.text-primary-highlight .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-primary-highlight .fl-module-content div[class^="fl-"][class$="text"] p';
	$css .= '{color:'. $hip_settings->settings['primary_highlight_color'] .';}';
}
if (!empty($hip_settings->settings['secondary_color'])) {
	$css .= '.secondary-heading .fl-module-content .fl-heading,.fl-module.secondary-heading h1[class^="fl"][class$="title"],.fl-module.secondary-heading h2[class^="fl"][class$="title"],.fl-module.secondary-heading h3[class^="fl"][class$="title"],.fl-module.secondary-heading h4[class^="fl"][class$="title"].fl-module.secondary-heading h5[class^="fl"][class$="title"],.fl-module.secondary-heading h6[class^="fl"][class$="title"]';
	$css .= ' .text-secondary .fl-rich-text p, .secondary-txt, .text-secondary .fl-module-content div[class^="fl-post"][class$="content"] p,.text-secondary .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-secondary .fl-module-content div[class^="fl-"][class$="text"] p';
	$css .= '{color:' . $hip_settings->settings['secondary_color'] . ';';
	$css .= '}';
	$css .= '.bg-secondary, .secondary-bg .fl-row-content-wrap, .button-secondary, .fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button,.secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]{';
	$css .= 'background-color:' . $hip_settings->settings['secondary_color'] . ';';
	$css .= '}';
}
if (!empty($hip_settings->settings['secondary_highlight_color'])) {
	$css .= '.bg-secondary-highlight, .secondary-bg-highlight .fl-row-content-wrap, .button-secondary:hover, .button-secondary:focus,.fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button:hover, .secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]:hover,.fl-builder-content .secondary-btn .fl-module-content .fl-button-wrap a.fl-button:focus, .secondary-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:focus,.secondary-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:focus,.fl-builder-content div.secondary-btn .fl-module-content form button[type="submit"]:focus{';
	$css .= 'background-color:' . $hip_settings->settings['secondary_highlight_color'] . ';}';

	$css .= ' .text-secondary-highlight .fl-rich-text p, .secondary-txt-highlight, .text-secondary-highlight .fl-module-content div[class^="fl-post"][class$="content"] p,.text-secondary-highlight .fl-module-content div[class^="fl-post"][class$="excerpt"] p,.text-secondary-highlight .fl-module-content div[class^="fl-"][class$="text"] p';
	$css .= '{color:' . $hip_settings->settings['secondary_highlight_color'] . ';}';
}
if (!empty($hip_settings->settings['tertiary_color'])) {
	$css .= '.bg-tertiary,.tertiary-bg .fl-row-content-wrap, .tertiary-bg-post .fl-post-grid .fl-post-grid-post,.tertiary-bg-post .fl-post-feed .fl-post-feed-post .fl-post-feed-text,.tertiary-bg-post .fl-post-carousel .fl-post-carousel-post';
	$css .= '{background-color:' . $hip_settings->settings['tertiary_color'] . ';}';
}
if (!empty($hip_settings->settings['tertiary_light_color'])) {
	$css .= '.bg-tertiary-light,.tertiary-light-bg .fl-row-content-wrap, .tertiary-light-bg-post .fl-post-grid .fl-post-grid-post,.tertiary-light-bg-post .fl-post-feed .fl-post-feed-post .fl-post-feed-text,.tertiary-light-bg-post .fl-post-carousel .fl-post-carousel-post';
	$css .= '{background-color:' . $hip_settings->settings['tertiary_light_color'] . ';}';
}
if (!empty($hip_settings->settings['btn_color']) || !empty($hip_settings->settings['btn_bg_color'])) {
	$css .= '.btn-general,.fl-builder-content .general-btn .fl-module-content .fl-button-wrap a.fl-button,.general-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"],.general-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a,.fl-builder-content div.general-btn .fl-module-content form button[type="submit"]{ color: ';
	$css .= $hip_settings->settings['btn_color'] . ';';
	$css .= (!empty($hip_settings->settings['btn_bg_color'])) ? 'background-color: ' . $hip_settings->settings['btn_bg_color'] . ';' : 'background-color: ' . $hip_settings->settings['primary_color'] . ';';
	if ($hip_settings->settings['btn_border'] != 'none') {
		$css .= 'border-style: solid;';
		if ($hip_settings->settings['btn_border'] == 'all') {
			$css .= 'border-width:';
			$css .= !empty($hip_settings->settings['btn_border_width']) ? $hip_settings->settings['btn_border_width'] . 'px;' : '1px;';
		} else if ($hip_settings->settings['btn_border'] == 'btm') {
			$css .= 'border-width:';
			$css .= !empty($hip_settings->settings['btn_border_width']) ? '0 0 ' . $hip_settings->settings['btn_border_width'] . 'px;' : '0 0 1px;';
		}
		$css .= !empty($hip_settings->settings['btn_border_color']) ? 'border-color:' . $hip_settings->settings['btn_border_color'] . ';' : 'border-color:' . $hip_settings->settings['btn_bg_color'] . ';';

	}
	if (!empty($hip_settings->settings['btn_radius'])) {
		$css .= '-webkit-border-radius:' . $hip_settings->settings['btn_radius'] . 'px;';
		$css .= 'border-radius:' . $hip_settings->settings['btn_radius'] . 'px;';
	}
	$css .= '}';
	if (!empty($hip_settings->settings['btn_hover_color']) || !empty($hip_settings->settings['btn_bg_hover_color'])) {
		$css .= '.btn-general:hover,.fl-builder-content .general-btn .fl-module-content .fl-button-wrap a.fl-button:hover,.general-btn .fl-module-content div[class^="fl-post-"] a[class^="fl-post-"][class$="more"]:hover,.general-btn .fl-module-content div[class^="fl-post-"] .fl-post-text .fl-post-more-link a:hover,.fl-builder-content div.general-btn .fl-module-content form button[type="submit"]:hover{';
		if (!empty($hip_settings->settings['btn_hover_color'])) {
			$css .= 'color:' . $hip_settings->settings['btn_hover_color'] . ';';
		}
		if (!empty($hip_settings->settings['btn_bg_hover_color'])) {
			$css .= 'background-color:' . $hip_settings->settings['btn_bg_hover_color'] . ';';
		}
		if (!empty($hip_settings->settings['btn_border_hover_color'])) {
			$css .= 'border-color:' . $hip_settings->settings['btn_border_hover_color'] . ';';
		}
		$css .= '}';
	}
}
if(!empty($hip_settings->settings['b_text_color'])){
	$css .= '.breadcrumbs-wrap ul li.crumb a{ color : '.$hip_settings->settings['b_text_color'].'}';
}
if(!empty($hip_settings->settings['b_text_hover_color'])){
	$css .= '.breadcrumbs-wrap ul li.crumb a:hover{ color : '.$hip_settings->settings['b_text_hover_color'].'}';
}
if(!empty($hip_settings->settings['b_current_text_color'])){
	$css .= '.breadcrumbs-wrap ul li.crumb .current{ color : '.$hip_settings->settings['b_current_text_color'].'}';
}
if(!empty($hip_settings->settings['b_bg_color'])){
	$css .= '.breadcrumbs-wrap { background-color : '.$hip_settings->settings['b_bg_color'].'}';
}
if(!empty($hip_settings->settings['b_border_size'])){
	$css .= '.breadcrumbs-wrap { border-left : '.$hip_settings->settings['b_border_size'].'px solid;';
	if(!empty($hip_settings->settings['b_border_color'])){
		$css .= 'border-left-color:'.$hip_settings->settings['b_border_color'].';';
	}
	$css .= '}';
}
if(!empty($hip_settings->settings['b_sep_color'])){
	$css .= '.breadcrumbs-wrap ul li.separator i{ color : '.$hip_settings->settings['b_sep_color'].'}';
}
$css .= '.fl-module-button .fl-module-content .fl-button-wrap a.fl-button span, .fl-module-button .fl-module-content .fl-button-wrap a.fl-button:hover span {color: inherit;}';
echo $css;

