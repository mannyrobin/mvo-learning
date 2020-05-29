<?php 

namespace BBVL;

class YoutubeVideo
{
	private $embed;
	private $uniqueid;
	
	public function __construct( $embed, $uniqueid = '' )
	{
		$this->embed = $embed;
		$this->uniqueid = $uniqueid;
	}
	
	public function getVideoId()
	{
		if ( ! $this->embed )
			return false;
		
		$pattern = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";
		preg_match( $pattern, $this->embed, $matches );
		
		return $matches[1];
	}
	
	public function getiFrame()
	{
		return '<iframe id="iframe-' . $this->uniqueid . '" type="text/html" '
		 . 'src="https://www.youtube.com/embed/' . $this->getVideoId() . '?enablejsapi=1&rel=0"></iframe>';
	}
	
	public function getDefaultScreenshot()
	{
		$vidId = $this->getVideoId();
		
		if ( ! $vidId )
			return '';
		
		return "https://img.youtube.com/vi/$vidId/0.jpg";
	}
	
	public function getVideoLink()
	{
		return 'https://www.youtube.com/watch?v=' . $this->getVideoId() . '?autoplay=1&rel=0&showinfo=0&enablejsapi=1';
	}
}
