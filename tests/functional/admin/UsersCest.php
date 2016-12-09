<?php

namespace tests\functional\admin;

use FunctionalTester;
use app\modules\user\models\User;
use tests\_fixtures\UserFixture;
use yii\helpers\Url;

class UsersCest
{
    private $formId = '#user-form';
    
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amLoggedInAsAdmin();
    }

    public function home(FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/default/index');
        $I->seeInTitle('Users');
    }

    public function viewExisting(FunctionalTester $I)
    {
        $id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;
        $I->amOnRoute('admin/user/default/view', ['id' => $id]);
        $I->seeInTitle('admin');
        $I->seeLink('Update');
    }

    public function viewWrong(FunctionalTester $I)
    {
        $I->amOnPage(['admin/user/default/view', 'id' => 100]);
        $I->canSee('404');
    }

    public function openCreatePage(FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/default/create');
        $I->seeInTitle('Create');
    }

    public function createWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/default/create');

        $I->submitForm($this->formId, [
            'User[username]' => '',
            'User[email]' => '',
            'User[newPassword]' => '',
            'User[newPasswordRepeat]' => '',
            'User[status]' => '',
        ]);

        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->see('New password cannot be blank.', '.help-block');
        $I->see('Repeat new password cannot be blank.', '.help-block');
    }

    public function createSuccess(FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/default/create');

        $I->submitForm($this->formId, [
            'User[username]' => 'user-create-tester',
            'User[email]' => 'user.create.tester.email@example.com',
            'User[newPassword]' => 'tester_password',
            'User[newPasswordRepeat]' => 'tester_password',
            'User[status]' => User::STATUS_ACTIVE,
        ]);

        $I->seeRecord(User::className(), [
            'username' => 'user-create-tester',
            'email' => 'user.create.tester.email@example.com',
        ]);

        $I->seeInTitle('user-create-tester');
    }

    public function openUpdatePage(FunctionalTester $I)
    {
        $id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;
        $I->amOnRoute('admin/user/default/view', ['id' => $id]);
        $I->seeInTitle('admin-update');
    }

    public function updateWithEmptyFields(FunctionalTester $I)
    {
        $id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;

        $I->amOnRoute('admin/user/default/update', ['id' => $id]);

        $I->submitForm($this->formId, [
            'User[username]' => '',
            'User[email]' => '',
            'User[newPassword]' => '',
            'User[newPasswordRepeat]' => '',
        ]);

        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->dontSee('New password cannot be blank.', '.help-block');
        $I->dontSee('Repeat new password cannot be blank.', '.help-block');
    }

    public function updateSuccess(FunctionalTester $I)
    {
        $id = $I->grabRecord(User::className(), ['username' => 'admin-update'])->id;

        $I->amOnRoute('admin/user/default/update', ['id' => $id]);

        $I->submitForm($this->formId, [
            'User[username]' => 'new-user-update',
            'User[email]' => 'new.user.update.email@example.com',
            'User[newPassword]' => 'new_tester_password',
            'User[newPasswordRepeat]' => 'new_tester_password',
            'User[status]' => User::STATUS_WAIT,
        ]);

        $I->seeRecord(User::className(), [
            'username' => 'new-user-update',
            'email' => 'new.user.update.email@example.com',
            'status' => User::STATUS_WAIT,
        ]);

        $I->seeInTitle('new-user-update');
    }

    public function testDelete(FunctionalTester $I)
    {
        $id = $I->grabRecord(User::className(), ['username' => 'admin-delete'])->id;

        $I->amOnRoute('admin/user/default/view', ['id' => $id]);
        $I->seeInTitle('admin-delete');
        $I->sendAjaxPostRequest(Url::to(['/admin/user/default/delete', 'id' => $id]));

        $I->dontSeeRecord(User::className(), [
            'username' => 'user-update-tester',
        ]);
    }
}