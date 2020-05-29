<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('see new integration form');
$I->loginAsAdmin();
$I->amOnPage('/wp-admin/admin.php?page=wpforms-settings&view=integrations');
$I->wait(30);
$I->click(['css' => '#wpforms-integration-gsheets .wpforms-settings-provider-header']);
$I->wait(30);
$I->click(['css' => '#wpforms-integration-gsheets .wpforms-settings-provider-accounts-toggle a.wpforms-btn']);
$I->wait(1);
$I->see('Click here to retrieve Google Access Code');
$I->seeElement('input', [ 'name' => 'authcode' ]);
$I->seeElement('input', [ 'name' => 'label' ]);
