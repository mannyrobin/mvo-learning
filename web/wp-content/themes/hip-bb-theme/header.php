<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php do_action('inline_css'); ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	do_action('before_header');
	do_action('hip_bb_header');
	do_action('after_header');
?>
