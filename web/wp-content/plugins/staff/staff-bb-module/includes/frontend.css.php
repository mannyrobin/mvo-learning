.staff-slider .staff-slider-wrapper{
	height: <?php echo !empty($settings->slider_min_height) ? $settings->slider_min_height : '450'; ?>px;
	min-height: <?php echo !empty($settings->slider_min_height) ? $settings->slider_min_height : '450'; ?>px;
	visibility: hidden;
	-webkit-transition: all 0.3s ease;
	transition: all 0.3s ease;
	opacity: 0;
}
.staff-slider .staff-slider-wrapper.fl-post-slider-loaded{
	height: inherit;
	min-height: inherit;
	visibility: visible;
	opacity: 1;
}
.staff-slider .staff-slider-wrapper .staff-slider .bx-viewport{
	min-height: <?php echo !empty($settings->slider_min_height) ? $settings->slider_min_height : '450'; ?>px;
}
.staff-slider .fl-post-slider-navigation{
	float: left;
	width: 170px;
	display: block;
	top: 90%;
	left: 28px;
}
.staff-slider .fl-post-slider-navigation a{
	opacity: 1;
	position: absolute;
}
.staff-slider .fl-post-slider-navigation a.slider-prev{
	left: 0;
}
.staff-slider .fl-post-slider-navigation a.slider-next{
	right: 0;
}
.staff-slider .fl-post-slider-navigation i{
<?php if(!empty($settings->arrow_bg)): ?>
	background: #<?php echo $settings->arrow_bg; ?>;
<?php endif;?>
<?php if(!empty($settings->arrow_icon_color)): ?>
	color: #<?php echo $settings->arrow_icon_color; ?>;
<?php endif;?>
	opacity: 1;
	text-align: center;
	width: 70px;
	height: 40px;
	font-size: 40px;
<?php if(!empty($settings->arrow_border_color)): ?>
	border-bottom: 4px solid #<?php echo $settings->arrow_border_color; ?>;
<?php else: ?>
	border-bottom: 4px solid #eb9e24;
<?php endif; ?>
}
.staff-slider-post{
	height: <?php echo !empty($settings->slider_min_height) ? $settings->slider_min_height : '450'; ?>px;
	min-height: inherit;
}


.staff-image{
	height: inherit;
	min-height: inherit;
	width: 50% !important;
	float: left;
	background-position: top center;
	background-size: cover;
}
.staff-slider-post .staff-image-sm img{
	width: 100%;
}
.staff-content-wrapper{
	height: inherit;
	min-height: inherit;
	display: table;
	width: 50%;
	float: left;
	position: relative;
	padding-left: 30px;
<?php if(!empty($settings->content_bg)):?>
	background-color: #<?php echo $settings->content_bg ?>;
<?php endif;?>
	padding-bottom: 60px;
}
.staff-content{
	max-width: 550px;
	vertical-align: middle;
	position: relative;
	z-index: 11;
}
.fl-node-<?php echo $id; ?> .staff-content .staff-heading{
	color: #<?php echo $settings->headline_color ?>;
	font-size: 40px;
	line-height: 46px;
	font-style: normal;
	font-weight: 700;
	text-transform: uppercase;
	position: relative;
	padding-bottom: 5px;
	margin: 20px 0;
	display: block;
}
.staff-heading:after{
	content: "";
	height: 1px;
	position: absolute;
	left: 0;
	width: 80%;
	background: #e6e5e1;
	bottom: 0;
}
.staff-content .staff-name{
	color: #<?php echo !empty($settings->name_color) ? $settings->name_color : '965f48'?>;
	font-size: 26px;
	line-height: 32px;
	font-style: italic;
	font-weight: 400;
	margin: 15px 0;
	display: block;
}
.staff-content p.staff-bio{
	color: #<?php echo !empty($settings->desc_color) ? $settings->desc_color : '965f48'?>;
	font-size: 18px;
	line-height: 24px;
	text-align: left;
}
.staff-content .staff-more-button a{
	display: block;
	color: #fff;
<?php if(!empty($settings->button_bg)): ?>
	background: #<?php echo $settings->button_bg; ?>;
<?php endif;?>
	padding: 8px;
	width: 170px;
<?php if(!empty($settings->button_border_color)): ?>
	border-bottom: 4px solid #<?php echo $settings->button_border_color; ?>;
<?php else: ?>
	border-bottom: 4px solid #eb9e24;
<?php endif; ?>
	text-transform: uppercase;
	text-align: center;
	font-size: 18px;
	font-weight: 600;
}
.staff-content .staff-more-button a:hover{
	background: #<?php echo !empty($settings->button_hover_bg) ? $settings->button_hover_bg : 'eb9e24'?>;
}
.staff-image-sm{
	display: block;
}
@media (max-width: 992px) {
	.staff-slider .staff-slider-wrapper{
		height: auto;
		min-height: unset;
	}
	.staff-slider-post{
		display: block;
		width: 100%;
		margin: 0 auto;
		height: auto;
		min-height: unset;
	}
	.staff-image{
		display: none;
	}
	.staff-heading:after{
		left: 10%;
	}
	.staff-content-wrapper{
		width: 100%;
		display: block;
		padding-left: 50px;
		padding-right: 50px;
		float: none;
		padding-top: 30px;
		padding-bottom: 30px;
		height: auto;
		min-height: unset;
	}
	.staff-content{
		position: relative;
		max-width: 100%;
	}
	.staff-details{
		background: #ffffff;
	}
	.staff-content h1{
		text-align: center;
	}
	.staff-content h1:after{
		content: "";
		height: 1px;
		position: absolute;
		left: 25%;
		width: 50%;
		background: #e6e5e1;
		bottom: 0;
	}
	.staff-content .staff-name{
		text-align: center;
		padding-top: 15px;
		display: inline-block;
		width: 100%;
	}
	.staff-content p.staff-bio{
		padding: 15px;
		margin: 0;
	}
	.staff-slider .fl-post-slider-navigation{
		position: absolute;
		top: 50%;
		width: 100%;
		left: 0;
	}
	.staff-content .staff-more-button a{
		width: 100%;
	}
	.staff-slider .fl-post-slider-navigation a.slider-prev{
		left: 0;
	}
	.staff-slider .fl-post-slider-navigation a.slider-next{
		right: 0;
	}
	.staff-slider .fl-post-slider-navigation i{
		width: 50px;
		height: 50px;
		padding-top: 4px;
	}
	.fl-node-<?php echo $id; ?> .staff-content .staff-heading{
		text-align: center;
	}
}
<?php if (!empty($settings->content_bg_image)):?>
@media(min-width: 993px){
	.staff-content-wrapper:before{
		content: '';
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: url(<?php echo !empty($settings->content_bg_image_src) ? $settings->content_bg_image_src : wp_get_attachment_url($settings->content_bg_image);?>) no-repeat;
		background-size: 100%;
		background-position: right center;
		opacity: <?php echo !empty($settings->content_bg_image_opacity) ? $settings->content_bg_image_opacity / 100 : '0.4' ;?>;
		z-index: 1;
	}
}
<?php endif;?>
@media(max-width: 767px){
	.fl-node-<?php echo $id; ?> .staff-content .staff-heading{
		font-size: 24px;
	}
}
@media (max-width: 479px) {
	.staff-content h1{
		font-size: 34px !important;
		line-height: 38px !important;
	}
	.staff-content-wrapper{
		padding-top: 25px;
		padding-bottom: 25px;
	}
	.homepage-services-service-description{
		text-align: left;
	}
}
@media (min-width: 993px) {
	.staff-image-sm{
		display: none;
	}
}