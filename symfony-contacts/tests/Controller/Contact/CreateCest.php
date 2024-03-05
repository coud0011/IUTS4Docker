<?php

namespace App\Tests\Controller\Contact;

use App\Factory\UserFactory;
use App\Tests\ControllerTester;

class CreateCest
{
    public function formContactDataBeforeUpdating(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'email' => 'root@example.fr',
            'firstname' => 'PETE',
            'lastname' => 'Park',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/contact/create');

        $I->seeInTitle('Création d`un nouveau contact');
        $I->see('Création d`un nouveau contact', 'h1');
    }
}
