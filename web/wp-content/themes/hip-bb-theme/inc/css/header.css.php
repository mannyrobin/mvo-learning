<?php if(!empty($hip_settings->settings['primary_color'])): ?>
header .main-header.style-1 ul.menu li.menu-item-has-children .fl-menu-toggle:before,header .main-header.style-1 .fl-row-content-wrap{
	border-color: <?php echo $hip_settings->settings['primary_color'];?>;
}
header .main-header ul.menu li ul.sub-menu{
	background-color: <?php echo $hip_settings->settings['primary_color'];?>;
}
header .main-header.style-1 .fl-row-content-wrap ul li ul.sub-menu li a:hover{
	background-color: #<?php echo (new \Mexitek\PHPColors\Color($hip_settings->settings['primary_color']))->darken(5);?>;
}
.header3.top-header .phone-button .uabb-creative-button-wrap a {
	color: <?php echo $hip_settings->settings['primary_color']; ?> !important;
	background: transparent;
	border: none;
}

.header3.top-header .phone-button .uabb-creative-button-wrap a i {
	color: <?php echo $hip_settings->settings['primary_color']; ?> !important;
}

.header3.top-header .phone-button .uabb-creative-button-wrap a span {
	color: <?php echo $hip_settings->settings['primary_color']; ?> !important;
}

.header3.header-main-nav .primary-nav ul.sub-menu li {
	background-color: <?php echo $hip_settings->settings['primary_color']; ?>;
}
<?php endif;?>
<?php if(!empty($hip_settings->settings['secondary_color'])): ?>
header .top-header.style-1 ul.menu li.top-menu-btn a,header .top-header.style-2 ul.menu li.top-menu-btn{
	background-color: <?php echo !empty($hip_settings->settings['secondary_color']) ? $hip_settings->settings['secondary_color'] : '';?>;
}
header .top-header.style-1 ul.menu li.top-menu-btn a:hover{
	background-color: #<?php echo (new \Mexitek\PHPColors\Color($hip_settings->settings['secondary_color']))->darken(5);?>;
}
.header3.header-main-nav .primary-nav ul.sub-menu li:hover {
	background-color: <?php echo $hip_settings->settings['secondary_color']; ?>;
}
header .main-header.style-2 .fl-row-content-wrap ul li a:hover{
	color: <?php echo $hip_settings->settings['secondary_color']?>;
}
<?php endif;?>
<?php if(!empty($hip_settings->settings['body_font_color'])): ?>
header .top-header.style-2 .header-phone svg{
	fill: <?php echo $hip_settings->settings['body_font_color'];?>
}
header .top-header.style-2 ul.menu li.top-menu-btn:hover{
	background-color: <?php echo $hip_settings->settings['body_font_color'];?>;
}
<?php endif;?>
<?php if(!empty($hip_settings->settings['primary_highlight_color'])): ?>
header .top-header.style-2 ul.menu li a:hover{
	color: <?php echo $hip_settings->settings['primary_highlight_color']?>;
}
<?php endif;?>
header .header3.top-header ul.menu .top-menu-btn {
<?php if(!empty($hip_settings->settings['btn_bg_color'])):?>
	background: <?php echo $hip_settings->settings['btn_bg_color']; ?>;
<?php endif;?>
<?php if(!empty($hip_settings->settings['btn_bg_hover_color'])):?>
	border-bottom: 3px solid <?php echo $hip_settings->settings['btn_bg_hover_color']; ?>;
<?php endif;?>
}
header .header3.top-header ul.menu .top-menu-btn:hover {
<?php if(!empty($hip_settings->settings['btn_bg_hover_color'])):?>
	background: <?php echo $hip_settings->settings['btn_bg_hover_color']; ?>;
<?php endif;?>
}
header .header3.top-header ul.menu .top-menu-btn a {
<?php if(!empty($hip_settings->settings['btn_color'])):?>
	color: <?php echo $hip_settings->settings['btn_color']; ?>;
<?php endif;?>
}
header .header3.top-header ul.menu .top-menu-btn:hover a {
<?php if(!empty($hip_settings->settings['btn_hover_color'])):?>
	color: <?php echo $hip_settings->settings['btn_hover_color']; ?>;
<?php endif;?>
}

.call-now-button-module.next-to-white-logo a.fl-button {
<?php if(!empty($hip_settings->settings['btn_bg_color'])):?>
	background: <?php echo $hip_settings->settings['btn_bg_color']; ?>;
	border: 1px solid <?php echo $hip_settings->settings['btn_bg_color']; ?>;
<?php endif;?>
<?php if(!empty($hip_settings->settings['btn_color'])):?>
	color: <?php echo $hip_settings->settings['btn_color']; ?>;
<?php endif;?>
}
.call-now-button-module.next-to-white-logo a.fl-button:hover {
<?php if(!empty($hip_settings->settings['btn_bg_hover_color'])):?>
	background: <?php echo $hip_settings->settings['btn_bg_hover_color']; ?>;
<?php endif;?>
<?php if(!empty($hip_settings->settings['btn_hover_color'])):?>
	color: <?php echo $hip_settings->settings['btn_hover_color']; ?>;
<?php endif;?>
}
<?php if(!empty($hip_settings->settings['menu_item_hover_color'])):?>
@media (min-width: 992px) {
	header div.main-header.style-1 .fl-row-content-wrap .fl-menu > ul.menu > li > a:hover,
	header div.main-header.style-1 .fl-row-content-wrap .fl-menu > ul.menu > li > .fl-has-submenu-container > a:hover,
	header div.main-header.style-2 .fl-row-content-wrap .fl-menu > ul.menu > li > a:hover,
	header div.main-header.style-2 .fl-row-content-wrap .fl-menu > ul.menu > li > .fl-has-submenu-container > a:hover{
		background-color: <?php echo $hip_settings->settings['menu_item_hover_color']; ?>;
	}
	header .header3.header-main-nav .primary-nav .fl-module-content .fl-menu > ul.menu > li > a:hover,
	header .header3.header-main-nav .primary-nav .fl-module-content .fl-menu > ul.menu > li > .fl-has-submenu-container > a{
		border-color: <?php echo $hip_settings->settings['menu_item_hover_color']; ?>;
	}
}
<?php endif;?>
<?php if(!empty($hip_settings->settings['sub_menu_font_color']) || !empty($hip_settings->settings['sub_menu_bg_color'])):?>
@media (min-width: 992px) {
	header div.main-header .fl-row-content-wrap .fl-menu > ul.menu > li > ul.sub-menu li a,
	header .header3.header-main-nav .primary-nav .fl-module-content ul.menu li ul.sub-menu li a{
	<?php if(!empty($hip_settings->settings['sub_menu_font_color'])): ?>
		color: <?php echo $hip_settings->settings['sub_menu_font_color']; ?>;
	<?php endif; ?>
	<?php if(!empty($hip_settings->settings['sub_menu_bg_color'])): ?>
		background-color: <?php echo $hip_settings->settings['sub_menu_bg_color']; ?>;
	<?php endif; ?>
	}
}
<?php endif;?>
<?php if(!empty($hip_settings->settings['sub_menu_font_hover_color']) || !empty($hip_settings->settings['sub_menu_bg_hover_color'])):?>
@media (min-width: 992px) {
	header div.main-header .fl-row-content-wrap .fl-menu > ul.menu > li > ul.sub-menu li a:hover,
	header .header3.header-main-nav .primary-nav .fl-module-content ul.menu li ul.sub-menu li a:hover{
	<?php if(!empty($hip_settings->settings['sub_menu_font_hover_color'])): ?>
		color: <?php echo $hip_settings->settings['sub_menu_font_hover_color']; ?>;
	<?php endif; ?>
	<?php if(!empty($hip_settings->settings['sub_menu_bg_hover_color'])): ?>
		background-color: <?php echo $hip_settings->settings['sub_menu_bg_hover_color']; ?>;
	<?php endif; ?>
	}
}
<?php endif;?>