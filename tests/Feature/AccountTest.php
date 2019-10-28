<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class AccountTest extends TestCase
{
    /**
     * Registering an account creates the account.
     * Login is Working
     *
     * @return void
     */
    public function testRegisterAndLoginAccount()
    {
        $this->registerTestUser();

        $userExists = Auth::guard()->attempt(
            [
                'email' => 'tester@testuser.ci',
                'password' => 'test123!'
            ]
        );

        self::assertTrue($userExists);
        $this->assertTrue(Auth::check());
    }

    /**
     * Login attempt with wrong Credentials is rejected
     *
     * @return void
     */
    public function testLoginNotCorrect()
    {
        $this->registerTestUser();

        $userExists = Auth::guard()->attempt(
            [
                'email' => 'tester@testuser.ci',
                'password' => 'WrongPassword!!'
            ]
        );

        self::assertFalse($userExists);
        $this->assertFalse(Auth::check());
    }


    /**
     * Registering an account creates the account.
     * Login is Working
     *
     * @return void
     */
    public function testRegisterAccountFrontend()
    {
        $this->registerTestUserFrontend();

        $this->post('logout');

        $userExists = Auth::guard()->attempt(
            [
                'email' => 'tester@testuser.ci',
                'password' => 'test123!'
            ]
        );

        self::assertTrue($userExists);
        $this->assertTrue(Auth::check());
    }

    /**
     * Login to /login with correct Credentials works
     *
     * @return void
     */
    public function testLoginCorrectFrontend()
    {
        $this->registerTestUserFrontend();

        $this->post('logout');

        $response = $this->post('login', [
            'email' => 'tester@testuser.ci',
            'password' => 'test123!',
        ]);

        self::assertEmpty(session('errors'));
        $this->assertTrue(Auth::check());
        $response->assertStatus(302);
    }

    /**
     * Login to /login with wrong Credentials is rejected
     *
     * @return void
     */
    public function testLoginNotCorrectFrontend()
    {
        $this->registerTestUserFrontend();

        $this->post('logout');

        $response = $this->post('login', [
            'email' => 'tester@testuser.ci',
            'password' => 'WrongPassword!!',
        ]);

        self::assertNotEmpty(session('errors'));
        /** @var ViewErrorBag $errors */
        $errors = session('errors');
        $errorMessages = $errors->getMessages();

        self::assertArrayHasKey('email', $errorMessages);

        self::assertEquals('These credentials do not match our records.', $errorMessages['email'][0]);

        $this->assertFalse(Auth::check());
        $response->assertStatus(302);
    }
}
