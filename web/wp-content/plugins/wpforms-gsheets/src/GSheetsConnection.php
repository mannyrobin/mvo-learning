<?php 
namespace WPFGS;

class GSheetsConnection
{
    protected $client = null;
    protected $accessToken = '';
    protected $refreshToken = '';

    public function __construct($accessToken = '', $refreshToken = '')
    {
        if ( ! empty($accessToken) ) {
            $this->accessToken = $accessToken;
        }

        if ( ! empty($refreshToken) ) {
            $this->refreshToken = $refreshToken;
        }
    }

    public function getClient() 
    {
        if ( $this->client ) {
            return $this->client;
        }

		$this->client = new \Google_Client();
		$this->client->setClientId('618672039579-j9316481d8tm2grvdrkv1vvii75iasl0.apps.googleusercontent.com');
		$this->client->setClientSecret('NDRdEzOGFlyZCRge3KjXifB2');
		$this->client->setScopes(implode( ' ', [ 
			\Google_Service_Sheets::SPREADSHEETS,
			\Google_Service_Drive::DRIVE_READONLY
		] ));
		$this->client->setAccessType('offline');
		$this->client->setRedirectUri( 'urn:ietf:wg:oauth:2.0:oob' );
		$this->client->setApprovalPrompt( 'force' );
		
		return $this->client;        
    }

    public function getService()
    {
        if ( empty( $this->accessToken) ) {
            error_log( 'Google Access Token not provided' );
            return false;
        }

        $this->setAccessToken();
        return new \Google_Service_Sheets( $this->client );
    }

    public function setAccessToken()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->accessToken);
        if ( $client->isAccessTokenExpired() ) {
            if ( !empty( $this->refreshToken ) ) {
                $token = $client->fetchAccessTokenWithRefreshToken( $this->refreshToken );
                $client->setAccessToken($token);
            } else {
                error_log('Unable to Refresh Expired Google Credentials');
                return false;
            }
        }

        return true;
    }
}