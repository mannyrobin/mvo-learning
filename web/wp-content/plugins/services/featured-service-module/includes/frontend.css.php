.fl-node-<?php echo $id; ?> .homepage-services-headline{
<?php
if ($settings->headline_color) {
	echo 'color:'.$settings->headline_color.'!important;';
}
?>
<?php if (strtolower($settings->heading_font['family']) != 'default') : ?>
	font-family: <?php echo $settings->heading_font['family'].'sans-serif'; ?>;
	font-weight: <?php echo $settings->heading_font['weight']; ?>;
<?php endif?>
<?php if ($settings->heading_font_size) {
	echo 'font-size:'.$settings->heading_font_size.'px;';
}?>
	line-height: 46px;
	font-style: normal;
	text-transform: uppercase;
	padding-bottom: 4px;
	position: relative;
}
.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap a {
<?php if ($settings->featured_link_color) {
	echo 'color:#'.$settings->featured_link_color.';';
} ?>
	text-decoration: none;
<?php if ($settings->featured_link_font_size) {
	echo 'font-size:'.$settings->featured_link_font_size.'px;';
}?>
	line-height: 26px;
<?php if (strtolower($settings->featured_link_font['family'] != 'default')) : ?>
	font-family: <?php echo $settings->featured_link_font['family'].',sans-serif';?>;
	font-weight: <?php echo $settings->featured_link_font['weight'] == 'regular' ? '400' : $settings->featured_link_font['weight']; ?>;
<?php endif?>
	font-style: normal;
}

.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-services-inner-wrap .homepage-services-service.active a {
<?php if ($settings->featured_active_color) {
	echo 'color:#'.$settings->featured_active_color.'!important;';
} ?>
	text-decoration: none;
	font-weight: 600;
}

.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service .homepage-services-service-title {
	padding: 10px 5px;
	position: relative;
	border-bottom: 1px solid;
<?php if ($settings->featured_post_border_color) {
	echo 'border-color:#'.$settings->featured_post_border_color.'!important;';
} ?>
}

.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service .homepage-services-service-button a.button {
	display: block;
<?php if ($settings->button_color_text) {
	echo 'color:#'.$settings->button_color_text.'!important;';
} ?>
<?php if ($settings->button_bg_color) {
	echo 'background:#'.$settings->button_bg_color.';';
} ?>
	padding: <?php echo $settings->featured_button_top_bottom ? $settings->featured_button_top_bottom.'px' : '10px'; ?> <?php  echo $settings->featured_button_left_right ? $settings->featured_button_left_right.'px' : '20px';  ?>;
	border-bottom: 4px solid;
<?php if ($settings->button_border_bottom_color) {
	echo 'border-color:#'.$settings->button_border_bottom_color.';';
} ?>
}
.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service .homepage-services-service-button a.button:hover {
<?php if ($settings->button_hover_bg) {
	echo 'background:#'.$settings->button_hover_bg.';';
} ?>
}

@media screen and (min-width: 993px) {
	.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-title {
	<?php if ($settings->featured_link_active_bgcolor) {
		echo 'background-color:#'.$settings->featured_link_active_bgcolor.'!important;';
    } ?>
		position: relative;
	}
	.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-title:after {
		content: "";
		position: absolute;
		left: 100%;
		top: 0;
		bottom: 0;
		width: 0;
		border-top: 24px solid transparent;
		border-left: 32px solid;
	<?php if ($settings->featured_link_active_bgcolor) {
		echo 'border-left-color:#'.$settings->featured_link_active_bgcolor.';';
    } ?>
		border-bottom: 24px solid transparent;
		z-index:100;
		transition: opacity 200ms ease 0s;
	}

	.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-image:after {
		position: absolute;
		content: "";
		background: <?php echo $settings->featured_post_overlay_color ? '#'.$settings->featured_post_overlay_color : 'rgba(0, 73, 100, 0.5)'; ?>;
		height: 100%;
		width: 100%;
		display: block;
		left: 0;
		top: 0;
		opacity:<?php echo $settings->featured_post_overlay_opacity ? $settings->featured_post_overlay_opacity : '0.5' ?>;
	}

	.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service.active .homepage-services-service-inner .homepage-services-service-description {
		font-size: <?php echo $settings->content_font_size ? $settings->content_font_size : '24'; ?>px;
		line-height: 30px;
	<?php if (strtolower($settings->content_font['family']) != 'default') : ?>
		font-family: <?php echo $settings->content_font['family']=='Default' ? 'Droid serif' : $settings->content_font['family']; ?>;
		font-weight: <?php echo $settings->content_font['weight']=='default' ? '400' : $settings->content_font['weight']; ?>;
	<?php endif?>
		font-style: normal;
		max-width: 550px;
		padding-top: 60px;
	}
	.fl-node-<?php echo $id; ?> .homepage-services-headline:after{
		content: "";
		height: 1px;
		position: absolute;
		left: 0;
		width: 50%;
	<?php if ($settings->featured_post_border_color) {
		echo 'background:#'.$settings->featured_post_border_color.';';
    }?>
		bottom: 0;
	}
}

.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-services-inner-wrap .homepage-services-service .homepage-services-service-inner .homepage-services-service-description{
<?php if ($settings->featured_content_color) {
	echo 'color:#'.$settings->featured_content_color.'!important;';
} ?>
}


.fl-node-<?php echo $id; ?> .homepage-services-wrap .homepage-services-inner-wrap .homepage-services-inner-inner-wrap{
	padding: <?php echo $settings->featured_post_tb_padding ? $settings->featured_post_tp_padding.'px' : '60px'; ?> 0 <?php  echo $settings->featured_post_tb_padding ? $settings->featured_post_tp_padding.'px' : '60px '; ?><?php  echo $settings->featured_post_l_padding ? $settings->featured_post_l_padding.'px' : '0'; ?>;
}
