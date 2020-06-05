<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('セキュリティチェックプラグインの確認をする');
$I->amOnPage('/admin');
$I->submitForm('#form1', [
    'login_id' => 'admin',
    'password' => 'password'
]);

$I->see('ホーム', '#main .page-header');

$I->amOnPage('/admin/store/plugin');
// $I->click(['css' => '#main > div > div > div > div:nth-child(3) > div.box-body > div > div > table > tbody > tr > td.ta.text-center > a']); // 設定リンク
$I->amOnPage('/admin/plugin/DataBackup3/config'); // 設定画面
$I->expect('初期値を確認します');

$I->see('バックアッププラグイン');

$I->click(['css' => '#common_button_box__edit_button > div > button']); // チェック実行
