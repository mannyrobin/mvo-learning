<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('see Google Sheets in Integrations Tab');
$I->loginAsAdmin();
$I->amOnPage('/wp-admin/admin.php?page=wpforms-settings&view=integrations');
$I->wait(1);
$I->see('Google Sheets');
