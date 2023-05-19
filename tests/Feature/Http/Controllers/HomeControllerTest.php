<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSeeCreateFormLoggedIn()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))
            ->assertSeeLivewire('link-create-form');
    }

    public function testRedirectLoggedOut()
    {
        $this->get(route('home'))
            ->assertRedirect('/auth/login');
    }
}
