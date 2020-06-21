<?php 
namespace WPFGS;
class Plugin
{
	private $version = '0.3.0';
	public $gsheets_process;
	
	public function __construct()
	{
		add_action( 'wpforms_loaded', function() {
			$this->provider = new Provider( $this );
		} );

		$this->gsheets_process = new GSheetsProcess();
	}
	
	public function getDir()
	{
		return plugin_dir_path( dirname(__FILE__) );
	}
	
	public function getURL()
	{
		return plugin_dir_url( dirname(__FILE__) );
	}
	
	public function getVersion()
	{
		return $this->version;
	}
}
