<?php

use yii\helpers\Url;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function amLoggedInAsAdmin()
    {
        $this->amLoggedInByCredentials('admin', 'adminpass');
    }

    public function amLoggedInAsUser()
    {
        $this->amLoggedInByCredentials('user', 'userpass');
    }

    public function amLoggedInByCredentials($username, $password)
    {
        $I = $this;
        $I->amOnPage(Url::to(['/user/default/login']));
        $I->seeInTitle('Login');
        $I->fillField('#loginform-username', $username);
        $I->fillField('#loginform-password', $password);
        $I->click('login-button');
        $I->wait(2);
        $I->see('Profile', '.nav');
    }
}
