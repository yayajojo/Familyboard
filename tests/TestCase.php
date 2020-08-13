<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function authenticateUser()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);
        return $user;
    }
}
