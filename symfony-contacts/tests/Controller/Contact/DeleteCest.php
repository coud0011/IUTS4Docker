<?php

namespace App\Tests\Controller\Contact;

use App\Factory\CategoryFactory;
use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\ControllerTester;
use Codeception\Util\HttpCode;

class DeleteCest
{
    public function form(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'email' => 'root@example.fr',
            'firstname' => 'PETE',
            'lastname' => 'Park',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        CategoryFactory::createOne();
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/1/delete');

        $I->seeInTitle('Suppression de Simpson, Homer');
        $I->see('Suppression de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        CategoryFactory::createOne();
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage('/contact/1/update');
        $I->amOnRoute('app_login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'email' => 'user@example.fr',
            'firstname' => 'PETE',
            'lastname' => 'Park',
            'roles' => ['ROLE_USER'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        CategoryFactory::createOne();
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage('/contact/1/update');
        $I->canSeeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
