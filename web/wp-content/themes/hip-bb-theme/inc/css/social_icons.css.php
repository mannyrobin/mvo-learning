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

	width: <?php echo !empty($hip_settings->settings['social_media_width']) ? $hip_settings->settings['social_media_width'] : '36px'; ?>;
	text-align: center;
	height: <?php echo !empty($hip_settings->settings['social_media_height']) ? $hip_settings->settings['social_media_height'] : '36px'; ?>;
	font-size: <?php echo !empty($hip_settings->settings['icon_font_size']) ? $hip_settings->settings['icon_font_size'] : '18px'; ?>;
	line-height: <?php echo !empty($hip_settings->settings['social_media_height']) ? $hip_settings->settings['social_media_height'] : '36px'; ?>;
	border-radius: 50%;
	display: block;
<?php if(empty($hip_settings->settings['social_brand_styles'])):?>
<?php if(array_key_exists('social_icon_bg', $hip_settings->settings)): ?>
	background-color: <?php echo $hip_settings->settings['social_icon_bg'] ?>;
<?php else : ?>
	background-color: <?php echo $hip_settings->settings['link_color'] ? $hip_settings->settings['link_color'] : '#0066ff' ; ?>;
<?php endif; ?>
<?php if(array_key_exists('social_icon_color', $hip_settings->settings)): ?>
	color: <?php echo $hip_settings->settings['social_icon_color'] ?>;
<?php else : ?>
	color: #fff;
<?php endif; ?>
<?php endif; ?>
}
.hip-businessinfo-social_icons > ul.social-icons li a:hover {
<?php if(empty($hip_settings->settings['social_brand_styles'])):?>
<?php if(array_key_exists('social_icon_hover_bg', $hip_settings->settings)): ?>
	background-color: <?php echo $hip_settings->settings['social_icon_hover_bg'] ?>;
<?php else : ?>
	background-color: <?php echo $hip_settings->settings['link_hover_color'] ? $hip_settings->settings['link_hover_color'] : '#0033cc' ; ?>;
<?php endif; ?>
<?php if(array_key_exists('social_icon_hover_color', $hip_settings->settings)): ?>
	color: <?php echo $hip_settings->settings['social_icon_hover_color'] ?>;
<?php else : ?>
	color: #fff;
<?php endif; ?>
<?php endif;  ?>
	transition: all 0.3s ease;
}
.hip-businessinfo-social_icons > ul.social-icons li a i{
	line-height: <?php echo !empty($hip_settings->settings['social_media_height']) ? $hip_settings->settings['social_media_height'] : '36px'; ?>;
}

<?php
 if(array_key_exists('social_brand_styles', $hip_settings->settings)){
	 if(!empty($hip_settings->settings['social_brand_styles'])){
?>
.hip-businessinfo-social_icons > ul.social-icons li a{
	color: #fff;
}
.hip-businessinfo-social_icons > ul.social-icons li.facebook a{
	background-color: #3b5998;
}
.hip-businessinfo-social_icons > ul.social-icons li.facebook:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#3b5998'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.twitter a{
	background-color: #55acee;
}
.hip-businessinfo-social_icons > ul.social-icons li.twitter:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#55acee'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.instagram a{
	background-color: #cd486b;
}
.hip-businessinfo-social_icons > ul.social-icons li.instagram:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#cd486b'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.linkedin a{
	background-color: #007bb5;
}
.hip-businessinfo-social_icons > ul.social-icons li.linkedin:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#007bb5'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.youtube a{
	background-color: #ff0000;
}
.hip-businessinfo-social_icons > ul.social-icons li.youtube:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#ff0000'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.googleplus a{
	background-color: #dd4b39;
}
.hip-businessinfo-social_icons > ul.social-icons li.googleplus:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#dd4b39'))->darken(5) ?>;
}
.hip-businessinfo-social_icons > ul.social-icons li.pinterest a{
	background-color: #bd081c;
}
.hip-businessinfo-social_icons > ul.social-icons li.pinterest:hover a{
	background-color: <?php (new \Mexitek\PHPColors\Color('#bd081c'))->darken(5) ?>;
}
<?php }  } ?>