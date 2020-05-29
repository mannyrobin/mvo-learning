# Google Analytics for WPForms
This plugin offers very basic event tracking for WPForms form submissions in Google Analytics. No need for javascript snippets or bloated analytics plugins.

Whenever a form is submitted, it triggers an event with the following properties:  
* Category: Form
* Action: Submit
* Label: Form Name

When used, it only captures the Submit event and it captures it for every form.

## Installation
Installation is done via composer. Simply run `composer require ydlr/wpforms-ga` from the root of your project.   

If you are unfamiliar with using composer to manage dependencies on WordPress sites, check out [this helpful introduction](https://roots.io/using-composer-with-wordpress/).  

## Setup 
First, [setup Google Analytics](https://support.google.com/analytics/answer/1008080) if you haven't done so already. Next, add your GA Tracking ID to WPForms settings:  
1. From WordPress Admin, navigate to WPForms->Settings.
2. Select the "Integrations" tab. 
3. Click the "Google Analytics" provider, then select "+ Add New Account".
4. Insert your Google Tracking ID and a nickname for the account. The nickname can be anything you like.
5. Click "Connect to Google Analytics". 

That's all. Form submissions will now be tracked in Google Analytics.

## Issues
Please report any bugs, feature requests, suggestions, or pull requests through github.