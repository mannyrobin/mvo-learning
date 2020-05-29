<?php 
namespace WPFGS;

class GSheetsProcess extends WPAsyncRequest 
{
    protected $action = 'wpfgs_gsheets_request';

    protected function handle()
    {
        $item = $_POST;
        $service = $this->getGSheetsService( $item['accessToken'], $item['refreshToken']);
        
        $values = str_replace( "\\", "", $item['values']);
        $body = new \Google_Service_Sheets_ValueRange( [
            'values'	=> [ json_decode($values) ]
        ] );

        $param = [
            'valueInputOption'	=> 'USER_ENTERED'
        ];

        try {
            $result = $service->spreadsheets_values->append( 
                $item['spreadsheet'], 
                $item['worksheet'],
                $body,
                $param
            );

            error_log('Result: ' . json_encode($result));
        } catch ( Exception $e ) {
            error_log( 'Error: ' . $e->getMessage() );
        }

        return false;
    }

    public function getGSheetsService( $accessToken, $refreshToken )
    {
        $conn = new GSheetsConnection($accessToken, $refreshToken);
        return $conn->getService();
    }
}