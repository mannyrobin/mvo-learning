<?php 

namespace WPFGS;

class Provider extends \WPForms_Provider
{
	private $client = null;
	
	public function api_auth( $data = [], $form_id = '' )
	{
		try {
			$token = $this->client->fetchAccessTokenWithAuthCode( trim($data['authcode']) );
			$this->client->setAccessToken($token);
		} catch( Exception $e ) {
			return $this->error( $e->getMessage() );
		}
		
		$id = uniqid();
		$providers = get_option( 'wpforms_providers', [] );
		$providers[ $this->slug ][ $id ] = [
			'authcode'		=> trim($data['authcode']),
			'token'				=> $token,
			'refresh'			=> $this->client->getRefreshToken(),
			'label'				=> sanitize_text_field( $data['label'] ),
			'date'				=> time()
		];
		
		update_option( 'wpforms_providers', $providers );
		
		return $id;
	}
	
	public function api_columns( $connection_id = '', $account_id = '', $list_id = '' )
	{
		$client = $this->api_connect( $account_id );
		
		if ( is_wp_error( $client ) ) 
			return $client;
		
		$split_id = ProviderHelper::splitId($list_id);
		$spreadsheet_id = $split_id[0];
		$worksheet_name = $split_id[1];
		
		try {
			$service = new \Google_Service_Sheets( $this->client );
			$results = $service->spreadsheets_values->get( $spreadsheet_id, $worksheet_name . '!A1:Z1' );
			$helper = new ProviderHelper();
			return $helper->mapRowToHeadings( $results->values[0] );
		} catch ( Exception $e ) {
			wpforms_log(
				__( 'Error retrieving heading columns', 'wpforms-gsheets' ),
				$e->getMessage(),
				[ 'type' => [ 'provider', 'error' ] ]
			);
			
			$error_msg = sprintf( '%s: %s', __( 'Google API Error', 'wpforms-gsheets' ), $e->getMessage() );
			return $this->error( $error_msg );
		}
	}
	
	public function api_connect( $account_id )
	{
		$providers = get_option( 'wpforms_providers' );
		if ( ! empty( $providers[ $this->slug ][ $account_id ][ 'token' ] ) ) {
			$this->client->setAccessToken( $providers[ $this->slug ][ $account_id ][ 'token' ] );
			if ( $this->client->isAccessTokenExpired() ) {
				if ( !empty ( $refresh = $providers[ $this->slug ][ $account_id ][ 'refresh' ] ) ) {
					$token = $this->client->fetchAccessTokenWithRefreshToken( $refresh );
					$providers[ $this->slug ][ $account_id ][ 'token' ] = $token;
					$this->client->setAccessToken( $token );
					update_option( 'wpforms_providers', $providers );
				} else {
					return $this->error( __( 'Unable to Refresh Expired Google Credentials', 'wpforms-gsheets' ) );
				}
			}
			return $this->client;
		} else {
			return $this->error( __( 'Error Connecting to Google APIs', 'wpforms-gsheets' ) );
		}
	}
	
	public function api_worksheets( $connection_id = '', $account_id = '', $list_id = '' ) 
	{
		$client = $this->api_connect( $account_id );
		
		if ( is_wp_error( $client ) )
			return $client;
		
		if ( empty( $list_id ) ) 
			return $this->error( __( 'Unable to retrieve spreadsheet' ) );
		
		try {
			$service = new \Google_Service_Sheets( $this->client );
			$results = $service->spreadsheets->get( $list_id );
			
			$sheets = [];
			foreach( $results->sheets as $sheet ) {
				$sheets[$sheet->properties->sheetId] = [
					'id'		=> $sheet->properties->sheetId,
					'name'	=> $sheet->properties->title
				];
			}
			
			return $sheets;
		} catch ( Exception $e ) {
			wpforms_log(
				__( 'Error retrieving sheets', 'wpforms-gsheets' ),
				$e->getMessage(),
				[ 'type' => [ 'provider', 'error' ] ]
			);
			
			$error_msg = sprintf( '%s: %s', __( 'Google API Error', 'wpforms-gsheets' ), $e->getMessage() );
			return $this->error( $error_msg );
		}
	}
	
	public function api_spreadsheets( $connection_id = '', $account_id = '' )
	{
		$client = $this->api_connect( $account_id );
		
		if ( is_wp_error( $client ) ) 
			return $client;
		
		try {
			$service = new \Google_Service_Drive( $this->client );
			$results = $service->files->listFiles( [
				'q'	=> "mimeType='application/vnd.google-apps.spreadsheet'"
			] );
			
			$spreadsheets = [];
			foreach ( $results->files as $file ) {
				$spreadsheets[$file->id] = [
					'id'		=> $file->id,
					'name'	=> $file->name,
					'worksheets'	=> $this->api_worksheets( $connection_id, $account_id, $file->id )
				];
			}
			
			return $spreadsheets;
		} catch ( Exception $e ) {
			wpforms_log(
				__( 'Error retrieving spreadsheets', 'wpforms-gsheets' ),
				$e->getMessage(),
				[ 'type' => [ 'provider', 'error' ] ]
			);
			
			$error_msg = sprintf( '%s: %s', __( 'Google API Error', 'wpforms-gsheets' ), $e->getMessage() );
			return $this->error( $error_msg );
		}
	}
		
	public function integrations_tab_new_form()
	{ ?>	
		<p>
			<a href='<?php echo $this->client->createAuthUrl(); ?>' target="_blank"><?php _e( 'Click here to retrieve Google Access Code', 'wpforms-gsheets' ) ?></a>
		</p>
		<p>
			<?php printf( '<input type="text" name="authcode" placeholder="%s" class="wpforms-required">', __( 'Access Code', 'wpforms-gsheets' ) ); ?>
			<?php printf( '<input type="text" name="label" placeholder="%s" class="wpforms-required">', __( 'Account Nickname', 'wpforms-gsheets' ) ); ?>
		</p>
		
		<?php 
	}
	
	function init()
	{
		global $wpfgs;
		$this->name = 'Google Sheets';
		$this->version = $wpfgs->getVersion();
		$this->slug = 'gsheets';
		$this->priority = 30;
		$this->icon = $wpfgs->getURL() . '/assets/images/addon-icon.png';
		$this->client = $this->setupClient();
	}
	
	public function output_auth() 
	{
		$providers = get_option( 'wpforms_providers' );
		$class = ! empty( $providers[ $this->slug ] ) ? 'hidden ' : '';
		
		$output = '<div class="wpforms-provider-account-add ' . $class . ' wpforms-connection-block">';
		$output .= sprintf( '<h4>%s</h4>', __( 'Add New Account', 'wpforms-gsheets' ) );
		$output .= sprintf( '<p><a href="%s" target="_blank">%s</a></p>', $this->client->createAuthUrl(), __( 'Click here to retrieve Google Access Code', 'wpforms-gsheets' ) );
		$output .= sprintf( '<input type="text" data-name="authcode" placeholder="%s %s" class="wpforms-required">', $this->name, __( 'Auth Code', 'wpforms-gsheets' ) );
		$output .= sprintf( '<input type="text" data-name="label" placeholder="%s %s" class="wpforms-required">', $this->name, __( 'Account Nickname', 'wpforms-gsheets' ) );
		$output .= sprintf( '<button data-provider="%s">%s</button>', $this->slug, __( 'Connect', 'wpforms-gsheets' ) );
		$output .= '</div>';
		
		return $output;
	}
	
	public function output_fields( $connection_id = '', $connection = array(), $form = '' ) {

		if ( empty( $connection_id ) || empty( $connection['account_id'] ) || empty( $connection['list_id'] ) || empty( $form ) )
			return;
		
		$provider_fields = $this->api_columns( 
			$connection_id, 
			$connection['account_id'], 
			$connection['list_id'] 
		);
		
		$form_fields = $this->get_form_fields( $form );

		if ( is_wp_error( $provider_fields ) )
			return $provider_fields;

		$output = '<div class="wpforms-provider-fields wpforms-connection-block">';

			$output .= sprintf( '<h4>%s</h4>', __( 'List Fields', 'wpforms' ) );

			// Table with all the fields
			$output .= '<table>';

				$output .= sprintf( '<thead><tr><th>%s</th><th>%s</th></thead>', __( 'List Fields', 'wpforms'), __( 'Available Form Fields', 'wpforms' ) );

				$output .= '<tbody>';

				foreach( $provider_fields as $provider_field ) :

					$output .= '<tr>';

						$output .= '<td>';

							$output .= esc_html( $provider_field['name'] );
							if ( !empty( $provider_field['req']) && $provider_field['req'] == '1' ) {
								$output .= '<span class="required">*</span>';
							}

						$output .= '<td>';

							$output .= sprintf( '<select name="providers[%s][%s][fields][%s]">', $this->slug, $connection_id, esc_attr( $provider_field['tag'] ) );

								$output .= '<option value=""></option>';

								$options = $this->get_form_field_select( $form_fields, $provider_field['field_type'] );

								foreach( $options as $option ) {
									$value    = sprintf( '%d.%s.%s', $option['id'], $option['key'], $option['provider_type'] );
									$selected = !empty( $connection['fields'][$provider_field['tag']] ) ? selected( $connection['fields'][$provider_field['tag']], $value, false ) : '';
									$output  .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $value ), $selected, esc_html( $option['label'] ) );
								}

							$output .= '</select>';

						$output .= '</td>';

					$output .= '</tr>';

				endforeach;

				$output .= '</tbody>';

			$output .= '</table>';

		$output .= '</div>';

		return $output;
	}
	
	public function output_groups( $connection_id = '', $connection = array() ) 
	{
		return;
	}
	
	public function output_lists( $connection_id ='', $connection = array() ) 
	{

		if ( empty( $connection_id ) || empty( $connection['account_id'] ) )
			return;

		$spreadsheets = $this->api_spreadsheets( $connection_id, $connection['account_id'] );
		$selected = !empty( $connection['list_id'] ) ? $connection['list_id'] : '';

		if ( is_wp_error( $spreadsheets ) ) {
			return $spreadsheets;
		}
		
		$output = '<style>.wpforms-provider-lists select { max-width: 100%; }</style>';

		$output .= '<div class="wpforms-provider-lists wpforms-connection-block">';

		$output .= sprintf( '<h4>%s</h4>', __( 'Select a Sheet', 'wpforms' ) );

		$output .= sprintf( '<select name="providers[%s][%s][list_id]">', $this->slug, $connection_id );
		$output .= sprintf( '<option value="">%s</option>', __( 'Select A Spreadsheet', 'wpforms-gsheets' ) );
		
		if ( ! empty( $spreadsheets ) ) {
			foreach ( $spreadsheets as $spreadsheet ) {
				foreach( $spreadsheet['worksheets'] as $worksheet ) {
					$output .= sprintf(
						'<option value="%s" %s>%s</option>',
						esc_attr( $spreadsheet['id'] . '--' . $worksheet['name'] ),
						selected( $selected, $spreadsheet['id'] . '--' . $worksheet['name'], false ),
						esc_attr( $spreadsheet['name'] . ' -- ' . $worksheet['name'] )
					);
				}
			}
		}

		$output .= '</select>';

		$output .= '</div>';

		return $output;
	}
	
	public function process_entry( $fields, $entry, $form_data, $entry_id ) {
		global $wpfgs;
		if ( empty( $form_data['providers'][$this->slug]) )
			return;
		
		$providers = get_option( 'wpforms_providers' );

		$gsheets_process = $wpfgs->gsheets_process;
					
		foreach( $form_data['providers'][$this->slug] as $connection ) {		
			$pass = $this->process_conditionals( $fields, $entry, $form_data, $connection );
			if ( ! $pass ) {
				wpforms_log (
					__( 'GSheets Append stopped by conditional logic', 'wpforms-gsheets' ),
					$fields,
					[
						'type'	=> [ 'provider', 'conditional_logic' ],
						'parent'	=> $entry_id,
						'form_id'	=> $form_data['id']
					]
				);
				continue;
			}
			
			$split_id = ProviderHelper::splitId($connection['list_id']);
			$spreadsheet_id = $split_id[0];
			$worksheet_name = $split_id[1];
			
			$values = [];
			foreach ( $connection['fields'] as $column => $value ) {
				if ( ! $value ) {
					$values[] = '';
					continue;
				}
				$field = explode( '.', $value );
				$id = $field[0];
				$key = $field[1];
				$values[] = $fields[$id][$key];
			}
			
			$request = [ 
				'accessToken'	=> $providers[$this->slug][$connection['account_id']]['token']['access_token'],
				'refreshToken'	=> $providers[$this->slug][$connection['account_id']]['refresh'],
				'spreadsheet'	=> $spreadsheet_id,
				'worksheet'		=> $worksheet_name,
				'values'		=> wp_json_encode($values)
			];

			$gsheets_process->data( $request );
			$gsheets_process->dispatch();
			error_log('Dispatched');
		}
	}

	public function setupClient()
	{
		$conn = new GSheetsConnection();
		return $conn->getClient();
	}
}
