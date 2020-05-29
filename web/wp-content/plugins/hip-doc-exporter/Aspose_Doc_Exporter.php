<?php
/*
Plugin Name: Hip Doc Exporter
Description: Hip Doc Exporter is a plugin for exporting contents of posts into the doc / docx file. Extends Aspose-Doc-Exporter to add some extra features
Version: 1.0.0
Author: Hip Creative
Author URI: https://hip.agency/
*/


#### INSTALLATION PROCESS ####
/*
1. Download the plugin and extract it
2. Upload the directory '/Aspose-Doc-Exporter/' to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Click on 'Aspose Doc Exporter' link under Settings menu to access the admin section
*/

add_filter('plugin_action_links', 'AsposeDocExporterPluginLinks', 10, 2);

/**
 * Create the settings link for this plugin
 * @param $links array
 * @param $file string
 * @return $links array
 */
function AsposeDocExporterPluginLinks($links, $file) {
     static $this_plugin;

     if (!$this_plugin) {
		$this_plugin = plugin_basename(__FILE__);
     }

     if ($file == $this_plugin) {
		$settings_link = '<a href="' . admin_url('options-general.php?page=AsposeDocExporterAdminMenu') . '">' . __('Settings', 'Aspose-Doc-Exporter') . '</a>';
		array_unshift($links, $settings_link);
     }

     return $links;
}


/**
 * For removing options
 * @param no-param
 * @return no-return
 */
function UnsetOptionsAsposeDocExporter() {
    // Deleting the added options on plugin uninstall
    delete_option('aspose_doc_exporter_app_sid');
    delete_option('aspose_doc_exporter_app_key');
    delete_option('aspose_doc_exporter_comments_text');
    delete_option('aspose_doc_exporter_post_comments');
    delete_option('aspose_doc_exporter_archive_posts');
    delete_option('aspose_doc_exporter_file_type');
    delete_option('aspose_doc_exporter_post_content_filters');
    delete_option('aspose_doc_exporter_post_date');
    delete_option('aspose_doc_exporter_post_author');
    delete_option('aspose_doc_exporter_post_categories');


}

register_uninstall_hook(__FILE__, 'UnsetOptionsAsposeDocExporter');

function AsposeDocExporterAdminRegisterSettings() {
     // Registering the settings

     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_app_sid');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_app_key');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_comments_text');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_post_comments');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_file_type');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_post_content_filters');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_post_date');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_post_author');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_archive_posts');
     register_setting('aspose_doc_exporter_options', 'aspose_doc_exporter_post_categories');

}

add_action('admin_init', 'AsposeDocExporterAdminRegisterSettings');


if (is_admin()) {
	// Include the file for loading plugin settings
	require_once('aspose_doc_exporter_admin.php');
}

