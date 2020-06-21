<?php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

class GA_WPForms extends WPForms_Provider
{
    public function init()
    {
        $this->version = GA_WPFORMS_VERSION;
        $this->name = "Google Analytics";
        $this->slug = "google-analytics";
        $this->priority = 30;
        $this->icon = GA_WPFORMS_URL . '/assets/icon.jpg';
    }
    
    public function api_auth($data = array(), $form_id = '')
    {
        $id = uniqid();
        $providers = get_option('wpforms_providers', []);
        $providers[$this->slug][$id] = [
            'trackid'   => trim($data['trackid']),
            'label'     => sanitize_text_field($data['label'])
        ];
        
        update_option('wpforms_providers', $providers);
        
        return $id;
    }
    
    public function process_entry($fields, $entry, $form_data, $entry_id = 0)
    {
        $analytics = new Analytics();
                
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $label = $form_data['settings']['form_title'];
        $uid = md5($ip);
        
        $analytics->setProtocolVersion('1')
            ->setClientId(md5($ip))
            ->setEventCategory('Form')
            ->setEventAction('Submit')
            ->setEventLabel($label);
        
        $providers = get_option('wpforms_providers');
        
        foreach ($providers[$this->slug] as $connection) {
            $analytics->setTrackingId($connection['trackid']);
            $response = $analytics->sendEvent();
        }
    }
    
    public function integrations_tab_new_form()
    {
        ?>
        <p>
            <input type="text" name="trackid" placeholder="GA Tracking ID">
            <input type="text" name="label" placeholder="Account Nickname">
        </p>
        <?php
    }
    
    public function builder_output()
    {
        ?>
        <div class="wpforms-panel-content-section wpforms-panel-content-section-<?php echo $this->slug; ?>" id="<?php echo $this->slug; ?>-provider">

            <?php $this->builder_output_before(); ?>

            <div class="wpforms-panel-content-section-title">

                <?php echo $this->name; ?>
                
            </div>

            <div class="wpforms-provider-connections-wrap wpforms-clear">

                <div class="wpforms-provider-connections">

                    <h2>You're Good!</h2>
                    <p>There is nothing for you to configure here.</p>

                </div>

            </div>

            <?php $this->builder_output_after(); ?>

        </div>
        <?php
    }
}
