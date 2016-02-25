<?php

namespace tests\codeception\_pages\admin\users;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class UserUpdatePage extends UserCreatePage
{
    public $route = 'admin/users/default/update';
}
