<?php

namespace tests\codeception\functional\admin;

use FunctionalTester;
use tests\codeception\_pages\admin\users\UserCreatePage;
use tests\codeception\_pages\admin\users\UserUpdatePage;
use tests\codeception\functional\FunctionalCest;
use app\modules\user\models\User;
use yii\helpers\Url;

class UsersCest extends FunctionalCest
{
    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testList(FunctionalTester $I)
    {
        $I->wantTo('ensure that user index page works');
        $I->amOnPage(['admin/users/default/index']);
        $I->seeInTitle('Users');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testView(FunctionalTester $I)
    {
        $I->wantTo('ensure that user view page works');
        $I->amOnPage(['admin/users/default/view', 'id' => 1]);
        $I->seeInTitle('admin');
        $I->seeLink('Update');

        $I->amOnPage(['admin/users/default/view', 'id' => 100]);
        $I->canSee('404');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testCreate(FunctionalTester $I)
    {
        $I->wantTo('ensure that user create page works');

        $page = UserCreatePage::openBy($I);
        
        $I->seeInTitle('Create');

        $I->amGoingTo('submit form with no data');
        $page->submit([
            'username' => '',
            'email' => '',
            'newPassword' => '',
            'newPasswordRepeat' => '',
        ]);
        $I->expectTo('see validation errors');
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->see('New password cannot be blank.', '.help-block');
        $I->see('Repeat new password cannot be blank.', '.help-block');

        $I->amGoingTo('submit form with correct data');
        $page->submit([
            'username' => 'user-create-tester',
            'email' => 'user.create.tester.email@example.com',
            'newPassword' => 'tester_password',
            'newPasswordRepeat' => 'tester_password',
            'status' => 'Active',
        ]);
        $I->expectTo('see that user is created');
        $I->seeRecord(User::className(), [
            'username' => 'user-create-tester',
            'email' => 'user.create.tester.email@example.com',
        ]);

        $I->expectTo('see view page');
        $I->seeInTitle('user-create-tester');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testUpdate(FunctionalTester $I)
    {
        $I->wantTo('ensure that user create page works');

        $page = UserCreatePage::openBy($I);

        $I->seeInTitle('Create');

        $I->amGoingTo('create test user');
        $page->submit([
            'username' => 'user-update-tester',
            'email' => 'user.update.tester.email@example.com',
            'newPassword' => 'tester_password',
            'newPasswordRepeat' => 'tester_password',
            'status' => 'Active',
        ]);
        $I->seeInTitle('user-update-tester');

        $I->amGoingTo('open update page');
        $id = $I->grabFromCurrentUrl('#(\d+)#');
        $page = UserUpdatePage::openBy($I, ['id' => $id]);

        $I->amGoingTo('submit form with no data');
        $page->submit([
            'username' => '',
            'email' => '',
            'newPassword' => '',
            'newPasswordRepeat' => '',
        ]);
        $I->expectTo('see validation errors');
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->dontSee('New password cannot be blank.', '.help-block');
        $I->dontSee('Repeat new password cannot be blank.', '.help-block');

        $I->amGoingTo('submit form with correct data');
        $page->submit([
            'username' => 'new-user-update-tester',
            'email' => 'new.user.update.tester.email@example.com',
            'newPassword' => 'new_tester_password',
            'newPasswordRepeat' => 'new_tester_password',
            'status' => 'Waits of verify',
        ]);
        $I->expectTo('see that user is updated');
        $I->seeRecord(User::className(), [
            'username' => 'new-user-update-tester',
            'email' => 'new.user.update.tester.email@example.com',
            'status' => User::STATUS_WAIT,
        ]);

        $I->expectTo('see view page');
        $I->seeInTitle('new-user-update-tester');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testDelete(FunctionalTester $I)
    {
        $I->wantTo('ensure that user create page works');

        $page = UserCreatePage::openBy($I);

        $I->seeInTitle('Create');

        $I->amGoingTo('create test user');
        $page->submit([
            'username' => 'user-update-tester',
            'email' => 'user.update.tester.email@example.com',
            'newPassword' => 'tester_password',
            'newPasswordRepeat' => 'tester_password',
            'status' => 'Active',
        ]);
        $I->seeInTitle('user-update-tester');

        $I->amGoingTo('delete item');
        $id = $I->grabFromCurrentUrl('#(\d+)#');

        $I->sendAjaxPostRequest(Url::to(['/admin/users/default/delete', 'id' => $id]));

        $I->expectTo('see that user is deleted');
        $I->dontSeeRecord(User::className(), [
            'username' => 'user-update-tester',
        ]);
    }
}