<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_see_create_form_logged_in()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))
            ->assertSeeLivewire('link-create-form');
    }

    public function test_redirect_logged_out()
    {
        $this->get(route('home'))
            ->assertRedirect('/auth/login');
    }
}
