<?php if(!empty($settings->bg_color)) : ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper{
	background-color: <?php echo '#'.$settings->bg_color; ?>;
}
<?php endif;?>

<?php if(!empty($settings->heading_font_size) || !empty($settings->heading_text_align) || !empty($settings->heading_text_color) || !empty($settings->heading_margin_btm)): ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .heading h3{
	<?php if(!empty($settings->heading_font_size)):?>
	font-size: <?php echo $settings->heading_font_size.'px'; ?>;
	<?php endif; ?>
	<?php if(!empty($settings->heading_text_align)):?>
	text-align: <?php echo $settings->heading_text_align; ?>;
	<?php endif; ?>
	<?php if(!empty($settings->heading_text_color)):?>
	color: <?php echo '#'.$settings->heading_text_color; ?>;
	<?php endif; ?>
	<?php if(!empty($settings->heading_margin_btm)):?>
	margin-bottom: <?php echo $settings->heading_margin_btm.'px';?>;
	<?php endif; ?>
	margin-top: 0;
}
<?php endif; ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .categories-list ul{
	margin: 0;
	padding: 0;
<?php if(!empty($settings->list_margin_left)) : ?>
	padding-left: <?php echo $settings->list_margin_left.'px'; ?>;
<?php endif; ?>
}
<?php if(!empty($settings->list_style) || !empty($settings->list_font_size)): ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .categories-list ul li{
	<?php if(!empty($settings->list_style)): ?>
	list-style: <?php echo $settings->list_style; ?>;
	<?php endif;?>
	<?php if(!empty($settings->list_font_size)): ?>
	font-size: <?php echo $settings->list_font_size.'px'; ?>;
	<?php endif;?>
}
<?php endif;?>
<?php if(!empty($settings->list_spacing)) : ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .categories-list ul li + li{
	padding-top: <?php echo $settings->list_spacing.'px'; ?>
}
<?php endif; ?>
<?php if(!empty($settings->list_text_color)) : ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .categories-list ul li a{
	color: <?php echo '#'.$settings->list_text_color; ?>;
}
<?php endif; ?>
<?php if(!empty($settings->list_text_hover_color)) : ?>
.fl-node-<?php echo $id; ?> .hip-categories-wrapper .categories-list ul li a:hover{
	color: <?php echo '#'.$settings->list_text_hover_color; ?>;
}
<?php endif; ?>




