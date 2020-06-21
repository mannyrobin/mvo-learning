<?php 
namespace Hip\Theme;

class GoogleFontsHandler
{
	/**
	 * api key for getting google fonts from webfont api
	 * @var string
	 */
    private $api_key = 'AIzaSyC1lJQcAk0_O8gigUc43fV4HaQpXCf9lUk';

    /**
     * Stored fonts.
     * Keep a copy so only have to request from google once
     */
    private $fontList;

    /**
     * Returns an array of Font information
     * @return mixed
     */
    public function getFontList()
    {
        if ( !empty( $this->fontList ) ) {
            return $this->fontList;
        }
        
        $fonts_object = $this->getFontsFromGoogle();

		$google_fonts = array();
		foreach ($fonts_object->items as $font) {
			$google_fonts[$font->family] = array();
			$google_fonts[$font->family]['family'] = $font->family;
			$google_fonts[$font->family]['weights'] = array();
			foreach ($font->variants as $weight) {
				if ($weight == 'italic') {
					array_push($google_fonts[$font->family]['weights'], 'Regular (italic)');
				} else {
					if (stripos($weight, 'italic')) {
						array_push($google_fonts[$font->family]['weights'], str_replace('italic', ' (italic)', $weight));
					} else {
						array_push($google_fonts[$font->family]['weights'], ucfirst($weight));
					}
				}
			}
        }

        $this->fontList = $google_fonts;
		return $google_fonts;
    }

    /**
     * Returns a stylesheet link for given fonts
     * @param array
     * @return string
     */

    public function getStyleSheetLink($fonts = [])
    {
        if ( empty($fonts) )
            return '';

        $base = 'https://fonts.googleapis.com/css?family=';

        $fontString = '';

        foreach( $fonts as $index => $font ) {
            $fontString .= str_replace( ' ', '+', $font->family) 
                . ':' . $font->weight;

            if ( ( $index + 1 ) == count($fonts) ) 
                continue;
            
            $fontString .= '|';
        }
                
        return $base . $fontString;
    }

	/**
	 * Get google fonts from google webfont api
	 * @param string
	 * @return mixed
	 */
	protected function getFontsFromGoogle()
	{
		/*get google fonts*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/webfonts/v1/webfonts?key=' .$this->api_key);
		if (defined('WP_ENV')) {
			if (WP_ENV == 'development') {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			}
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		$output = curl_exec($ch);
		if ($output === false) {
			return 'curl_error ' . curl_error($ch);
		}
        curl_close($ch);
        
        return json_decode($output);
    }

    public function getWeightValFromLabel( $label ) {
        $fw = strtolower($label);
        if ( $fw == 'regular') {
            return '400';
        } else if ( $fw == 'regular (italic)') {
            return '400i';
        } else if (stripos($fw, '(italic)')) {
            return str_replace(' (italic)', 'i', $fw );
        } else {
            return $fw;
        }
    }
}