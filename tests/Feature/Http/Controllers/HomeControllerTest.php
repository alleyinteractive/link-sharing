<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testSeeCreateFormLoggedIn()
    {

    }

    public function testRedirectLoggedOut()
    {
        $this->get(route('home'))
            ->assertRedirect('/auth/login');
    }
}
