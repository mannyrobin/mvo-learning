<?php 
/**
 * Plugin Name: Autopopulate Menus
 * Plugin URI: https://pucklabs.com/autopopulate-menus
 * Description: Autopopulate submenus based on taxonomy, post type, or post hierarchy.
 * Version: 0.1.1
 * Author: Puck Labs
 * Author URI: http://pucklabs.com
 * Text Domain: autopop_menus
 * Domain Path: /locale

============================================================================================================
This software is provided "as is" and any express or implied warranties, including, but not limited to, the
implied warranties of merchantibility and fitness for a particular purpose are disclaimed. In no event shall
the copyright owner or contributors be liable for any direct, indirect, incidental, special, exemplary, or
consequential damages(including, but not limited to, procurement of substitute goods or services; loss of
use, data, or profits; or business interruption) however caused and on any theory of liability, whether in
contract, strict liability, or tort(including negligence or otherwise) arising in any way out of the use of
this software, even if advised of the possibility of such damage.

For full license details see LICENSE.md
============================================================================================================
*/

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	require __DIR__ . '/vendor/autoload.php';

add_action( 'plugins_loaded', function() {
	$plugin = new PuckLabs\AutopopMenus\Plugin();
	$plugin['version'] = '0.1.0';
	$plugin['url'] = plugins_url( '', __FILE__ );
	$plugin['dir'] = plugin_dir_path( __FILE__ );
	
	$plugin->run();
} );
