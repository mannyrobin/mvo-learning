<?php 

namespace PuckLabs\AutopopMenus;
use Pimple\Container;

class Plugin extends Container
{
	
	private $walker = 'PuckLabs\AutopopMenus\EditNavWalker';
	
	public function __construct()
	{
	}
	
	public function run()
	{
		if ( is_admin() ) {
			add_filter( 'wp_edit_nav_menu_walker', [ $this, 'getWalker' ] );
			add_action( 'wp_update_nav_menu_item', [ $this, 'updateNavMenuItem' ], 10, 3 );
		}
		
		add_filter( 'wp_setup_nav_menu_item', [ $this, 'setupNavMenuItem' ] );
		add_filter( 'wp_get_nav_menu_items', [ $this, 'addMenuObjects' ], 10, 3 );
	}
	
	public function getWalker( $walker )
	{
		return $this->walker;
	}
	
	public function updateNavMenuItem( $menu_id, $menu_item_db_id, $args )
	{
		$args['menu-item-autopop'] = isset($_POST['menu-item-autopop'][$menu_item_db_id]);
		
		update_post_meta( $menu_item_db_id, '_menu-item-autopop', $args['menu-item-autopop'] );
	}
	
	public function setupNavMenuItem( $menu_item )
	{
		if ( isset( $menu_item->post_type ) ) {
			if ( 'nav_menu_item' == $menu_item->post_type ) {
				$menu_item->autopop = empty( $menu_item->autopop ) 
					? get_post_meta( $menu_item->ID, '_menu-item-autopop', true )
					: $menu_item->autopop;
			}
		}
		
		return $menu_item;
	}
	
	public function addMenuObjects( $items, $menu, $args )
	{
		if ( is_admin() && $GLOBALS['pagenow'] == 'nav-menus.php' ) return $items;
		
		if ( !is_array( $items ) ) return $items;
		
		$order = sizeof($items) + 1;
		
		foreach( $items as $key => $item ) {
			if ( ! $item->autopop ) continue;
			
			$children = $this->getChildren( $item, $order );
			
			if ( is_array( $children ) ) {				
				foreach ( $children as $child ) {
					$items[] = $child;
				}
				
				$order = sizeof($items) + 1;
			}
		}
				
		return $items;
	}
	
	public function getChildren( $parent, $order )
	{
		$children = [];
		$child_posts = [];
		if ( 'taxonomy' == $parent->type ) {
			$tax_object = get_taxonomy( $parent->object );
			$child_posts = get_posts( [
				'post_type'				=> $tax_object->object_type,
				'post_status'			=> 'publish',
				'posts_per_page'	=> -1,
				'tax_query'				=> [ [
					'taxonomy'				=> $parent->object,
					'field'						=> 'name',
					'terms'						=> get_term_field( 'name', $parent->object_id, $parent->object, 'raw' )
				] ]
			] );
		} elseif ( 'post_type_archive' == $parent->type ) {
			$child_posts = get_posts( [
				'post_type'				=> $parent->object,
				'post_status'			=> 'publish',
				'posts_per_page'	=> -1
			] );
		} else {
			$child_posts = get_posts( [
				'post_type'				=> $parent->object,
				'post_status'			=> 'publish',
				'posts_per_page'	=> -1,
				'post_parent'			=> (int)$parent->object_id
			] );
		}
		
		if ( !empty( $child_posts ) ) {
			foreach( $child_posts as $post ) {
				$children[] = $this->createMenuItem( $post, $parent, $order + 1 );
				$order++;
			}
		}
		
		return $children;
	}
	
	public function createMenuItem( $post, $parent, $order )
	{
		$item = clone $post;
		
		$item->ID = $order;
		$item->db_id = $order;
		$item->object_id = $post->ID;
		$item->url = get_permalink($post->ID);
		$item->post_type = 'nav_menu_item';
		$item->menu_item_parent = $parent->ID;
		$item->description = $item->post_excerpt;
		$item->menu_order = $order;
		$item->type = 'post_type';
		$item->target = '';
		$item->attr_title = '';
		$item->classes = [ 0 => '' ];
		$item->xfn = '';
		
		$object = get_post_type_object($post->post_type);
		$item->object = $object->name;
		$item->type_label = $object->labels->singular_name;
		
		if ( !empty( $post->post_title ) ) {
			$item->title = $post->post_title;
		} else {
			$item->title = $post->ID . ' (No Title)';
		}
		
		return $item;
	}
}
