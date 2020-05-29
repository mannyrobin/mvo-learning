<?php

require( dirname( dirname ( __DIR__ ) ) . '/lib/YoutubeVideo.php');

class YoutubeVideoTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testConstructYoutubeVideo()
    {
			$video = new \BBVL\YoutubeVideo( 'https://youtu.be/cGVdCGxh1IY', 'uniqueString' );
			
			$this->assertInstanceOf(\BBVL\YoutubeVideo::class, $video);
    }
    
    public function testGetVideoId()
    {
			$tests = [
				'https://youtube.com/embed/vyuJcmKSmEM',
				'https://youtu.be/vyuJcmKSmEM',
				'https://www.youtube.com/watch?v=vyuJcmKSmEM',
				'https://www.youtube.com/watch?v=vyuJcmKSmEM&autoplay=1'
			];
			
			$expect = 'vyuJcmKSmEM';
			
			foreach ( $tests as $test ) {
				$video = new \BBVL\YoutubeVideo( $test );
				$this->assertEquals ( $expect, $video->getVideoId() );
			}
		}
}
