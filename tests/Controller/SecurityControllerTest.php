<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
{
    public function testLoginButtonTextChanged()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test the home page
        $client->request('GET', '/en/main');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#btnLoginLogout', 'Logout');
    }
}