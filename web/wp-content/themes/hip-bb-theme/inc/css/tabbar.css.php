@media screen and ( min-width: <?php echo $hip_settings->settings['max_width'] + 1; ?>px ) {
	.tabbar-wrapper { display: none; }
}

.tabbar {
	border-top: 1px solid <?php echo $hip_settings->settings['selected_color'] ?>;
}
.tabbar .tab {
	background-color: <?php echo $hip_settings->settings['bg_color'] ?>;
	color: <?php echo $hip_settings->settings['fg_color'] ?>;
	border-right: 1px solid <?php echo $hip_settings->settings['selected_color'] ?>;
}
.tabbar .tab button, .tabbar .tab button svg {
	background-color: <?php echo $hip_settings->settings['bg_color'] ?>;
	color: <?php echo $hip_settings->settings['fg_color'] ?>;
	fill: <?php echo $hip_settings->settings['fg_color'] ?>;
}
.tabbar .tab, .tabbar .tab.selected button {
	background-color: <?php echo $hip_settings->settings['selected_color'] ?>;
}
.c-hamburger span, .c-hamburger span:before, .c-hamburger span:after {
	background: <?php echo $hip_settings->settings['fg_color'] ?>;
}
.tabbar .tab div.tabbar-menu {
	background: <?php echo $hip_settings->settings['bg_color'] ?>;
}
.tabbar .tab div.tabbar-menu ul li a {
	color: <?php echo $hip_settings->settings['fg_color'] ?>;
}
.tabbar .tab div.tabbar-menu ul li {
	border-bottom: 1px solid <?php echo $hip_settings->settings['fg_color'] ?>;
}
.tabbar .tab div.tabbar-menu  ul  li  ul {
	background: <?php echo $hip_settings->settings['selected_color'] ?>;
}
.tabbar .tab div.tabbar-menu  ul  li  ul  li  ul {
	background: <?php echo $hip_settings->settings['bg_color'] ?>;
}
.tabbar .tab div.tabbar-menu .search-bar{
	background: <?php echo $hip_settings->settings['bg_color'] ?>;
}
<?php if(!empty($hip_settings->settings['search_bg'])) : ?>
.tabbar .tab div.tabbar-menu .search-bar input{
	background:  <?php echo $hip_settings->settings['search_bg']; ?>;
}
<?php elseif (!empty($hip_settings->settings['bg_color'])): ?>
	background: <?php echo (new \Mexitek\PHPColors\Color($hip_settings->settings['bg_color']))->darken(20); ?>
<?php endif; ?>

.tabbar .tab div.tabbar-menu .search-bar #searchsubmit{
	color:  <?php echo !empty($hip_settings->settings['search_btn_color']) ? $hip_settings->settings['search_btn_color'] : $hip_settings->settings['fg_color']  ?>;
}
.tabbar-wrapper .tabbar .tab div.tabbar-menu li.menu-item-has-children:after{
	color: <?php echo $hip_settings->settings['fg_color']; ?>
}
.tabbar-wrapper .tabbar .tab .tabbar-icon-wrap{
	width: 24px;
	height: 24px;
	margin: 0 auto 5px;
	display: block;
}
.tabbar-wrapper .tabbar .tab .tabbar-icon-wrap img{
	max-width: 100%;
}
.tabbar-wrapper .tabbar .tab .tabbar-icon-wrap .genericon-wrap{
	width: 100%;
	height: 100%;
}
.tabbar-wrapper .tabbar .tab .tabbar-icon-wrap .genericon-wrap svg{
	width: 100%;
	height: 100%;
	fill: #fff;
	background: transparent;
}
.tabbar-wrapper .tabbar .tab .tabbar-icon-wrap i{
	font-size: 20px;
}
body.logged-in.admin-bar .tabbar-wrapper .tabbar .tab.selected div.tabbar-menu{
	height: calc(100% - 106px);
}